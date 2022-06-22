<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Sanciones\PersonalRequest;
use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends BaseController
{

    protected $personal = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Personal $personal)
    {
        $this->middleware('auth:api');
        $this->personal = $personal;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $personals = $this->personal->with('catpersonal')->orderBy('lup', 'asc')->paginate(4);

        return $this->sendResponse($personals, 'Listado de Personas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Products\PersonalRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function list()
    {
        $personals = $this->personal->pluck('lup', 'id') ;

        return $this->sendResponse($personals, 'Listado del Personal');
    }

    public function listApe()
    {

        // REVISAR !!!!!!
        $personal = $this->personal->where('apellido',"nombre", "lup" , 'id') -> orderBy('lup', 'asc') ;

        return $this->sendResponse($personal, 'Listado del Personal');
    }

    public function store(PersonalRequest $request)
    {
        $personal = $this->personal->create([
            'lup' => $request->get('lup'),
            'apellido' => $request->get('apellido'),
            'nombre' => $request->get('nombre'),
            'catpersonal_id' => $request->get('catpersonal_id'),

        ]);

        return $this->sendResponse($personal, 'Persona creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $personal = $this->personal->with(['catpersonal'])->findOrFail($id);

        return $this->sendResponse($personal, 'Detalle de la Persona');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Personal  $product
     * @return \Illuminate\Http\Response
     */
    public function update(PersonalRequest $request, $id)
    {
        $personal = $this->personal->findOrFail($id);

        $personal->update($request->all());

        return $this->sendResponse($personal, 'La información de la Persona ha sido Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $personal = $this->personal->findOrFail($id);

        $personal->delete();

        return $this->sendResponse($personal, 'La Persona fue Eliminada');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' .$request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}

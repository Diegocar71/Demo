<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Catpersonal;
use Illuminate\Http\Request;

class CatpersonalController extends BaseController
{
    protected $catpersonal = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Catpersonal $catpersonal)
    {
        $this->middleware('auth:api');
        $this->catpersonal = $catpersonal;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catpersonal = $this->catpersonal->latest()->paginate(10);

        return $this->sendResponse($catpersonal, 'Listado de Categorías');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $catpersonal = $this->catpersonal->pluck('detalle', 'id');

        return $this->sendResponse($catpersonal, 'Listado de Categorías');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $tag = $this->catpersonal->create([
            'id' => $request->get('id'),
            'detalle' => $request->get('detalle'),
        ]);

        return $this->sendResponse($tag, 'Categoría creada con éxito');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $tag = $this->catpersonal->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'La información de la Categoría ha sido actualizada');
    }
}

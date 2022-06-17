<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Sanciones\SancioneRequest;
use App\Models\Sancione;
use Illuminate\Http\Request;

class SancioneController extends BaseController
{

    protected $sancione = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Sancione $sancione)
    {
        $this->middleware('auth:api');
        $this->sancione = $sancione;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sanciones = $this->sancione->with('catpersonal', 'personal')->orderBy('lup', 'asc')->paginate(10);

        return $this->sendResponse($sanciones, 'Listado de Sanciones');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SancioneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SancioneRequest $request)
    {
        $sancione = $this->sancione->create([
            'personal_id' => $request->get('personal_id'),
            'lup' => $request->get('lup'),
            'numero_disp' => $request->get('numero_disp'),
            'numero_rrhh' => $request->get('numero_rrhh'),
            'catpersonal_id' => $request->get('catpersonal_id'),
            'dest_gral' => $request->get('dest_gral'),
            'destino' => $request->get('destino'),
            'fecha_sancion' => $request->get('fecha_sancion'),
            'tipo_sancion' => $request->get('tipo_sancion'),
            'susp_empleo' => $request->get('susp_empleo'),
            'fecha_not' => $request->get('fecha_not'),
            'detalle' => $request->get('detalle'),
            'Impuesta_lup' => $request->get('Impuesta_lup'),
            'cumplida' => $request->get('cumplida'),
            'pri_recurso' => $request->get('pri_recurso'),
            'seg_recurso' => $request->get('seg_recurso'),
            'resolucion' => $request->get('resolucion'),
            'notificacion' => $request->get('notificacion'),
            'observaciones' => $request->get('observaciones'),

        ]);

        return $this->sendResponse($sancione, 'Sancion creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sancione  $sancione
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $sancione = $this->sancione->with(['catpersonal'], ['personal'])->findOrFail($id);

        return $this->sendResponse($sancione, 'Listado de Sanciones');


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sancione  $sancione
     * @return \Illuminate\Http\Response
     */
    public function update(SancioneRequest $request, $id)
    {
        $sancione = $this->sancione->findOrFail($id);

        $sancione->update($request->all());

        return $this->sendResponse($sancione, 'La información de la Sancion ha sido Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sancione  $sancione
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $sancione = $this->sancione->findOrFail($id);

        $sancione->delete();

        return $this->sendResponse($sancione, 'La Sancion fue Eliminada');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' .$request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}

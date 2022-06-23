<?php

namespace App\Http\Requests\Sanciones;

use Illuminate\Foundation\Http\FormRequest;

class SancioneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }
    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */
    public function createRules(): array
    {
        return [

            'personal_id' => 'integer|exists:id',
            'lup' => 'required|string|max:191',
            'numero_disp' => 'string|max:191',
            'numero_rrhh' =>'string|max:191',
            'catpersonal_id' => 'required|integer|exists:catpersonals,id',
            'dest_gral' => 'string|max:191',
            'destino' => 'string|max:191',
            'fecha_sancion' => 'required|date',
            'tipo_sancion' => 'required|string|max:191',
            'susp_empleo' => 'string|max:191',
            'fecha_not' => 'date',
            'detalle' => 'text',
            'Impuesta_lup' => 'string|max:191',
            'cumplida' =>'string|max:191',
            'pri_recurso' => 'string|max:191',
            'seg_recurso' => 'string|max:191',
            'resolucion' => 'string|max:191',
            'notificacion' => 'string|max:191',
            'observaciones' => 'string|max:191',
        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [


            'personal_id' => 'integer|exists:id',
            'lup' => 'required|string|max:191',
            'numero_disp' => 'string|max:191',
            'numero_rrhh' =>'string|max:191',
            'catpersonal_id' => 'required|integer|exists:catpersonals,id',
            'dest_gral' => 'string|max:191',
            'destino' => 'string|max:191',
            'fecha_sancion' => 'required|date',
            'tipo_sancion' => 'required|string|max:191',
            'susp_empleo' => 'string|max:191',
            'fecha_not' => 'date',
            'detalle' => 'text',
            'Impuesta_lup' => 'string|max:191',
            'cumplida' =>'string|max:191',
            'pri_recurso' => 'string|max:191',
            'seg_recurso' => 'string|max:191',
            'resolucion' => 'string|max:191',
            'notificacion' => 'string|max:191',
            'observaciones' => 'string|max:191',

        ];
    }
}

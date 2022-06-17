<?php

namespace App\Http\Requests\Sanciones;

use Illuminate\Foundation\Http\FormRequest;

class PersonalRequest extends FormRequest
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
            // 'category_id'
            'catpersonal_id' => 'required|integer|exists:catpersonals,id',
            'lup' => 'required|unique|string|max:191',
            'apellido' => 'required|string|max:191',
            'nombre' => 'required|string|max:191',
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
            // 'category_id'

            'catpersonal_id' => 'required|integer|exists:catpersonals,id',
            'lup' => 'required|unique|string|max:191',
            'apellido' => 'required|string|max:191',
            'nombre' => 'required|string|max:191',

        ];
    }
}

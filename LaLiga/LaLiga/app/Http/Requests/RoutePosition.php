<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoutePosition extends FormRequest
{
    public $validator = null;
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
        return [
            'position' => 'in:goalkeeper,defender,midfielder,forward',
        ];
    }

    public function messages()
    {
        return [
            'position.in' => 'Only: goalkeeper,defender,midfielder,forward',            
        ];
    }
    public function all($keys = null)
    {
        // Include the next line if you need form data, too.
        $data = parent::all($keys);
        $data['position'] = $this->route('position');
        return $data;
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}

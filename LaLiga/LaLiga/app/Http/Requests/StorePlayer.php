<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayer extends FormRequest
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
            'name' => 'required',
            'position' => 'required|in:goalkeeper,defender,midfielder,forward',
            'price' => 'required',
            'team_id' => 'required|exists:teams,id,deleted_at,NULL',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'position.required' => 'A position is required',
            'position.in' => 'Only: goalkeeper,defender,midfielder,forward',
            'team_id.exists' => 'Not an existing ID',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }
}

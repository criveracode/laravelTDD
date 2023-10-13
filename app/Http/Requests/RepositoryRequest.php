<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepositoryRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => 'required',
            'description' => 'required'
        ];
    }
}

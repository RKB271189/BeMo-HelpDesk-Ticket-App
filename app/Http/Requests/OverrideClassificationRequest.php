<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class OverrideClassificationRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => ['required', 'string'],
            'note' => ['required', 'string', 'max:50'],
        ];
    }
    public function messages(): array
    {
        return [
            'category.required'    => 'Please select for the ticket.',
            'category.string'      => 'The category must be valid string.',
            'note.required' => 'A note is required for the ticket.',
            'note.string'   => 'The note must be a valid string.',
            'note.max'      => 'The note may not be greater than 50 characters.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['error' => $validator->errors()->first()], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}

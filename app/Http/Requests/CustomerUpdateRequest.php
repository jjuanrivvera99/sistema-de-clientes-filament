<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'residence_place' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'approx_enrollment' => ['nullable', 'date'],
            'marital_status' => ['nullable', 'string', 'max:50'],
            'family' => ['nullable', 'string'],
            'document_number' => ['required', 'string', 'max:50'],
            'document_type_id' => ['required', 'integer', 'exists:document_types,id'],
            'contacts' => ['nullable', 'array'],
            'contacts.*.contact_number' => ['nullable', 'string', 'max:20'],
            'contacts.*.address' => ['nullable', 'string', 'max:255'],
            'contacts.*.email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }
}

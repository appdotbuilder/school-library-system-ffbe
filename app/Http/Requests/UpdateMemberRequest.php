<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
            'nisn_nip' => 'nullable|string|unique:members,nisn_nip,' . $this->route('member')->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:members,email,' . $this->route('member')->id,
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'member_type' => 'required|in:student,teacher,staff',
            'status' => 'required|in:active,inactive,suspended',
            'school_class_id' => 'nullable|exists:school_classes,id',
            'major_id' => 'nullable|exists:majors,id',
            'joined_date' => 'nullable|date',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Member name is required.',
            'nisn_nip.unique' => 'This NISN/NIP is already registered.',
            'email.unique' => 'This email is already registered.',
            'email.email' => 'Please provide a valid email address.',
            'member_type.required' => 'Member type is required.',
            'member_type.in' => 'Member type must be student, teacher, or staff.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be active, inactive, or suspended.',
            'school_class_id.exists' => 'Selected class does not exist.',
            'major_id.exists' => 'Selected major does not exist.',
        ];
    }
}
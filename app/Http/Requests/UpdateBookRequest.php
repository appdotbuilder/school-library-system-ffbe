<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn,' . $this->route('book')->id,
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'quantity' => 'required|integer|min:1',
            'book_shelf_id' => 'required|exists:book_shelves,id',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
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
            'title.required' => 'Book title is required.',
            'isbn.unique' => 'This ISBN is already registered.',
            'publication_year.required' => 'Publication year is required.',
            'publication_year.min' => 'Publication year must be at least 1900.',
            'publication_year.max' => 'Publication year cannot be in the future.',
            'quantity.required' => 'Quantity is required.',
            'quantity.min' => 'Quantity must be at least 1.',
            'book_shelf_id.required' => 'Book shelf is required.',
            'book_shelf_id.exists' => 'Selected book shelf does not exist.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'author_id.required' => 'Author is required.',
            'author_id.exists' => 'Selected author does not exist.',
            'publisher_id.required' => 'Publisher is required.',
            'publisher_id.exists' => 'Selected publisher does not exist.',
        ];
    }
}
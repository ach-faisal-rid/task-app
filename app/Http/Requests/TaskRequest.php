<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|unique:tasks',
            'description' => 'required',
            'long_description' => 'required',
            'completed' => 'required|in:0,1',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title harus diisi.',
            'title.string' => 'Title harus berupa string.',
            'title.max' => 'Title tidak boleh lebih dari :max karakter.',
            'title.unique' => 'Title sudah ada.',
            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa string.',
            'long_description.required' => 'Long Deskripsi harus diisi.',
            'long_description.string' => 'Long Deskripsi harus berupa string.',
            'completed.required' => 'Completed harus diisi.',
            'completed.boolean' => 'Completed harus berupa boolean.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'name'           => 'required|string|max:255|unique:tasks,name',
            'description'    => 'nullable|string|max:500',
            'status_id'      => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels'         => 'nullable|array',
            'labels.*'       => 'exists:labels,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
     public function messages(): array
    {
        return [
            'name.unique'     => __('messages.A task with this name already exists'),
            'name.max'        => __('messages.The name must not be greater than 255 characters.'),
            'description.max' => __('messages.The description must not be greater than 500 characters.'),
        ];
    }
}

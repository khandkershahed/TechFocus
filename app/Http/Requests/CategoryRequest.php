<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $categoryId = $this->route('category');
        return [
            'country_id'  => 'nullable|exists:countries,id',
            'parent_id'   => 'nullable|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:categories,slug,' . $categoryId . ',id',
            'is_parent'   => 'nullable|in:0,1',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'country_id.exists'  => 'The selected country Name is invalid.',
            'parent_id.exists'   => 'The selected parent category Name is invalid.',
            'name.required'      => 'The name field is required.',
            'name.string'        => 'The name field must be a string.',
            'name.max'           => 'The name may not be greater than 255 characters.',
            'is_parent.in'       => 'The is parent field must be either 0 or 1.',
            'image.image'        => 'The file must be an image.',
            'image.mimes'        => 'The image must be a file of type:jpeg, png, jpg, gif.',
            'image.max'          => 'The image may not be greater than 2048 kilobytes.',
            'logo.image'         => 'The file must be an image.',
            'logo.mimes'         => 'The logo must be a file of type:jpeg, png, jpg, gif.',
            'logo.max'           => 'The logo may not be greater than 2048 kilobytes.',
            'description.string' => 'The description field must be a string.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'country_id'  => 'Country Name',
            'parent_id'   => 'Parent Category Name',
            'name'        => 'Name',
            'image'       => 'Image',
            'logo'        => 'Logo',
            'description' => 'Description',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $this->recordErrorMessages($validator);
        parent::failedValidation($validator);
    }

    /**
     * Record the error messages displayed to the user.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function recordErrorMessages(Validator $validator)
    {
        $errorMessages = $validator->errors()->all();

        foreach ($errorMessages as $errorMessage) {
            session()->flash('error', $errorMessage);
        }
    }
}

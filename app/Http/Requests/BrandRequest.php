<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BrandRequest extends FormRequest
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
        $brandId = $this->route('brand'); // Directly access the brand ID from the route parameter.

        return [
            'country_id'  => 'nullable|exists:countries,id',
            'title'       => 'required|string|unique:brands,title,' . $brandId . '|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website_url' => 'nullable|url|max:255',
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
            'country_id.exists'  => 'The selected country name is invalid.',
            'title.required'      => 'The name field is required.',
            'title.string'        => 'The name field must be a string.',
            'title.unique'        => 'The name has already been taken.',
            'title.max'           => 'The name may not be greater than 255 characters.',
            'image.image'        => 'The file must be an image.',
            'image.mimes'        => 'The image must be a file of type:jpeg, png, jpg, gif.',
            'image.max'          => 'The image may not be greater than 2048 kilobytes.',
            'logo.image'         => 'The file must be an image.',
            'logo.mimes'         => 'The logo must be a file of type:jpeg, png, jpg, gif.',
            'logo.max'           => 'The logo may not be greater than 2048 kilobytes.',
            'website_url.url'    => 'The website URL must be a valid URL.',
            'website_url.max'    => 'The website URL may not be greater than 255 characters.',
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
            'title'        => 'Name',
            'image'       => 'Image',
            'logo'        => 'Logo',
            'website_url' => 'Website URL',
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

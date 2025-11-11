<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // ✅ Detect product ID correctly (route parameter can be 'product' or 'id')
        $productId = $this->route('product') ?? $this->route('id');

        // ✅ Detect if this is update()
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [

            'ref_code'                  => 'nullable|string|max:50',

            // ✅ Unique except current product on update:
            'name'                      => 'required|string|max:255|unique:products,name,' . $productId,
            'sku_code'                  => 'nullable|string|max:50|unique:products,sku_code,' . $productId,
            'mf_code'                   => 'nullable|string|max:50|unique:products,mf_code,' . $productId,

            'product_code'              => 'nullable|string|max:50',
            'tags'                      => 'nullable',
            'color_id'                  => 'nullable|array',
            'short_desc'                => 'nullable|string',
            'overview'                  => 'nullable|string',
            'specification'             => 'nullable|string',
            'accessories'               => 'nullable|string',
            'warranty'                  => 'nullable|string',

            // ✅ FIXED: Required for CREATE, optional for UPDATE
            'thumbnail'                 => $isUpdate
                                            ? 'nullable|image|mimes:png,jpg,jpeg|max:2024'
                                            : 'required|image|mimes:png,jpg,jpeg|max:2024',

            'qty'                       => 'nullable',
            'stock'                     => 'nullable|string|max:50',
            'price'                     => 'nullable|numeric',
            'sas_price'                 => 'nullable|numeric',
            'discount'                  => 'nullable|numeric',
            'deal'                      => 'nullable|string|max:50',
            'industry'                  => 'nullable|array',
            'solution'                  => 'nullable|array',
            'refurbished'               => 'nullable|in:0,1',
            'price_status'              => 'required|in:rfq,price,offer_price,starting_price',
            'rfq'                       => 'nullable|in:0,1',
            'product_type'              => 'required|string|max:50',
            'category_id'               => 'nullable|exists:categories,id',
            'brand_id'                  => 'nullable|exists:brands,id',

            'source_one_price'          => 'nullable|numeric',
            'source_two_price'          => 'nullable|numeric',
            'source_one_name'           => 'nullable|string|max:255',
            'source_two_name'           => 'nullable|string|max:255',
            'competitor_one_price'      => 'nullable|numeric',
            'competitor_two_price'      => 'nullable|numeric',
            'competitor_one_name'       => 'nullable|string|max:255',
            'competitor_two_name'       => 'nullable|string|max:255',
            'source_one_approval'       => 'nullable|in:0,1',
            'source_two_approval'       => 'nullable|in:0,1',
            'notification_days'         => 'nullable|string|max:50',
            'create_date'               => 'nullable|date',
            'solid_source'              => 'nullable|in:yes,no',
            'direct_principal'          => 'nullable|in:yes,no',
            'agreement'                 => 'nullable|in:yes,no',
            'source_type'               => 'nullable|string|max:50',
            'source_contact'            => 'nullable|string',
            'action_status'             => 'nullable|string|max:50',
            'added_by'                  => 'nullable|string|max:255',

            'source_one_estimate_time'  => 'nullable|string|max:60',
            'source_one_principal_time' => 'nullable|string|max:60',
            'source_one_shipping_time'  => 'nullable|string|max:60',
            'source_one_location'       => 'nullable|string|max:255',
            'source_one_country'        => 'nullable|string|max:255',

            'source_two_estimate_time'  => 'nullable|string|max:60',
            'source_two_principal_time' => 'nullable|string|max:60',
            'source_two_shipping_time'  => 'nullable|string|max:60',
            'source_two_location'       => 'nullable|string|max:255',
            'source_two_country'        => 'nullable|string|max:255',

            'rejection_note'            => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'sku_code.unique'  => 'The :attribute has already been taken.',
            'mf_code.unique'   => 'The :attribute has already been taken.',
            'name.unique'      => 'The product name already exists.',
            'thumbnail.required' => 'Thumbnail is required for new product.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->recordErrorMessages($validator);
        parent::failedValidation($validator);
    }

    protected function recordErrorMessages(Validator $validator)
    {
        $errorMessages = $validator->errors()->all();
        $allErrors = implode(' ', $errorMessages);

        return redirect()->back()->with('error', $allErrors)->withInput();
    }
}

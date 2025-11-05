<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrincipalEmailVerificationRequest extends FormRequest
{
    /**
     * Determine if the principal is authorized.
     * 
     * ✅ Always true because verification should NOT require login
     */
    public function authorize(): bool
    {
        return true; // allow verification without authentication
    }

    /**
     * Validation rules (not needed for email verification)
     */
    public function rules(): array
    {
        return [];
    }
}

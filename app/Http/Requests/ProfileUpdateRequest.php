<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\BusCompany;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'IdNXB' => ['string', 'max:10', DB::table('bus_companies')->where('IdNX', $this->user()->IdNX)->exists()],
            'sdt' => ['string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id), 'regex:/^0[0-9]{9}$/'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class StoreUserInformation extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'name' => [
                'bail',
                'required',
                'string',
                'max:191',
                Rule::unique('users', 'name')->ignore($this->route('user'))
            ],
            'email' => [
                'bail',
                'required',
                'email',
                'max:191',
                Rule::unique('users')->ignore($this->route('user'))
            ],
            'role'  => 'bail|required_if:required_role,true|integer',
            'permissions'  => '',
            'password'        => 'bail|required_if:required_password,true|confirmed|max:191',
        ];

        $rules['language_id'] = 'bail|required';
        $rules['place_id'] = '';
        $rules['floor_id'] = '';
        $rules['category_wise_floor_slot_id'] = '';
        $rules['country_id'] = '';
        $rules['state_id'] = '';
        $rules['city_id'] = '';
        $rules['phone_number'] = '';
        $rules['address'] = '';
        $rules['id_number'] = '';
        $rules['vehicle_no'] = ''; 
        $rules['driver_owner_id'] = ''; 
        $rules['owner_phone_no'] = '';
        $rules['category_id'] = '';

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $userParam = $this->route('user');
            if (gettype($userParam) == 'object')
                $userParam = $userParam->id;
            if (
                $this::user()->id == $userParam
                && !Hash::check($validator->getData()['currentPassword'], $this::user()->makeVisible('password')->password)
            ) {
                $validator->errors()->add('currentPassword', 'Current Password is not matched.');
            } elseif (
                $this::user()
                && Route::currentRouteName() !== 'user.store'
                && !$this::user()->hasAllPermissions(allpermissions())
                && !Hash::check($validator->getData()['currentPassword'], $this::user()->makeVisible('password')->password)
            ) {
                $validator->errors()->add('currentPassword', 'Current Password is not matched.');
            }

            if (isset($validator->getData()['password']) && (! $this::user() || ! $this->route('user')) && ! $validator->getData()['password']) {
                $validator->errors()->add('password', 'Password is required.');
            }
        });
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class UpdateCategoryRequest extends FormRequest
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
        return [
            'place_id'    => 'bail|required',
            'description' => 'bail|required|string',
            'type'        => 'bail|required',
            'status'      => 'bail|required|boolean',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $category = Category::where('place_id', $this->request->get('place_id'))->where('type', $this->request->get('type'))->where('id', '!=', $this->route('category')->id)->count();

            if ($category) {
                $validator->errors()->add('type', 'This category should be unique.');
            }
        });
    }
}

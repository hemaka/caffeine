<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDrinks extends FormRequest
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
            'name' => 'required|string|min:1',
            'description' => '',
            'caffeine' => 'required|integer',
            'unit' => ['required', 'array', function ($attribute, $value, $fail) {
                if($value['type'] == 'serving'){
                    if($value['pack'] != 'none'){
                        if(floor($value['val']) <= 0){
                            return $fail('Unit serving value error ');
                        }
                    }
                }else if($value['type'] == 'fl'){
                    if(floor($value['val']) <= 0){
                        return $fail('Unit fl value error ');
                    }
                }else{
                    return $fail('Unit select value error ');
                }
            }],
        ];
    }
}

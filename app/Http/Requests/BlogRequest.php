<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        if ($this->id){
            $rule = [
                'title' => 'required|string|max:250',
                'content' => 'required|string|max:250',
                'image' => 'required|mimes:jpeg,png,jpg|max:2048'
            ];
        }else{
            $rule = [
                'title' => 'required|string|max:250',
                'content' => 'required|string|max:250',
                'image' => 'required|mimes:jpeg,png,jpg|max:2048'
            ];
        }

        return $rule;
    }
}

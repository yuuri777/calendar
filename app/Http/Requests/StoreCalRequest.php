<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Cal;

class StoreCalRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $myCalStatusRule = Rule::in(array_keys(Cal::CAL_STATUS_STRING));
        return [
            'date' =>"required|date",
            'title' => "required|max:30|string",
            'importance' => ["required",$myCalStatusRule]
    // バリデーションルールについて  https://codelikes.com/laravel-validation-rule/#toc2
        ];
    }
}

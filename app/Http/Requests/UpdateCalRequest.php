<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Cal;

class UpdateCalRequest extends FormRequest
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
        $myCalStatusRule = Rule::in(array_keys(CAL::CAL_STATUS_STRING));

        return [
            'title'=> 'required|max:10|string',
            'date' => 'required|date',
            'importance' => ['required',$myCalStatusRule],
            //
        ];
    }

    public function attributes()
    {
        return [
            'title' => '予定',
            'importance' => '重要度',
            'date' => '日付'
        ];
    }
    public function messages()
    {
        $statuses = implode('、',array_values(Cal::CAL_STATUS_STRING));

        return[
            'cal_status.in' => 'attributeには'.$statuses.'のいずれかを選んでください。',
        ];
    }

}

<?php

namespace Modules\HumanResource\Http\Requests;

use App\Traits\ValidationMessage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttendanceReportFormRequest extends FormRequest
{
    use ValidationMessage;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "year" => 'required',
            "month" => 'required',
            "course_id" => 'nullable',
            "instructor" => 'nullable',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

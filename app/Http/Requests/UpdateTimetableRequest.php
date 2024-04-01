<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTimetableRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if (request()->has('action'))
        {
            return [
                'updateStartDateTime'=>'required',
                'updateEndDateTime'=>'required',
            ];
        }

        return [
            'update_title'=>'required|max:200',
            'current_date'=>'required|date',
            'updateStartDateTime'=>'required|date_format:H:i',
            'updateEndDateTime'=>'required|date_format:H:i|after:updateStartDateTime',
            'updateDescription'=>'nullable|max:2000',
        ];
    }

    public function attributes(): array
    {
        return [
            'update_title'=>'Title',
            'current_date'=>'Current Date',
            'updateStartDateTime'=>'Start Time',
            'updateEndDateTime'=>'End Time',
            'description'=>'Description',
        ];
    }
}

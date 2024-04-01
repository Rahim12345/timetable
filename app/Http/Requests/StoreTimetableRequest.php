<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimetableRequest extends FormRequest
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
        return [
            'title'=>'required|max:200',
            'current_date'=>'required|date',
            'startDateTime'=>'required|date_format:H:i',
            'endDateTime'=>'required|date_format:H:i|after:startDateTime',
            'description'=>'nullable|max:2000',
        ];
    }

    public function attributes(): array
    {
        return [
            'title'=>'Title',
            'current_date'=>'Current Date',
            'startDateTime'=>'Start Time',
            'endDateTime'=>'End Time',
            'description'=>'Description',
        ];
    }
}

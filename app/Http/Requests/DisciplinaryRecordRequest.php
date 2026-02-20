<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisciplinaryRecordRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $id = $this->route('discipline');

        return [
            'student_id' => ['required', 'exists:students,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'month' => [
                'required',
                'integer',
                'min:1',
                'max:12',
                Rule::unique('disciplinary_records')
                    ->where('student_id', $this->student_id)
                    ->where('academic_year_id', $this->academic_year_id)
                    ->where('month', $this->month)
                    ->ignore($id)
            ],
            // Checkboxes are always present if they are part of the request, 
            // but we ensure they are validated as boolean.
            'meeting_participated' => ['sometimes', 'boolean'],
            'bill_submitted' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'month.unique' => 'A record already exists for this student in the selected month and year.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'meeting_participated' => $this->boolean('meeting_participated'),
            'bill_submitted' => $this->boolean('bill_submitted'),
        ]);
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    // Check if the time slot is available
                    $existingAppointment = Appointment::where('staff_id', $this->staff_id)
                        ->where('appointment_date', $this->appointment_date)
                        ->where('appointment_time', $value)
                        ->when($this->route('appointment'), function ($query) {
                            // Exclude current appointment when updating
                            return $query->where('id', '!=', $this->route('appointment')->id);
                        })
                        ->first();

                    if ($existingAppointment) {
                        $fail('This time slot is already booked.');
                    }
                },
            ],
            'notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'service_id' => 'service',
            'staff_id' => 'staff member',
            'appointment_date' => 'appointment date',
            'appointment_time' => 'appointment time',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'appointment_date.after_or_equal' => 'The appointment date must be today or a future date.',
            'appointment_time.date_format' => 'The appointment time must be in HH:MM format.',
        ];
    }
}

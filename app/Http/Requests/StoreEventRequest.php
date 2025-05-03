<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_events');
    }

    public function rules(): array
    {
        return [
            'branch_id'      => 'required|exists:branches,id',
            'event_type'     => 'required|string|max:120',
            'event_title'    => 'required|string|max:255',
            'event_datetime' => 'required|date',
            'location'       => 'required|string|max:255',
            'lecturers'      => 'nullable|string|max:255',
            'attendance'     => 'nullable|integer|min:0',
            'duration'       => 'nullable|integer|min:0',
            'description'    => 'nullable|string',
            'planned'        => 'boolean',
            'attachments.*'  => 'file|mimes:pdf,doc,docx,png,jpg,jpeg|max:4096',
        ];
    }
}

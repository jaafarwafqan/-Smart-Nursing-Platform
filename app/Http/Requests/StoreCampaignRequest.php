<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_campaigns');
    }

    public function rules(): array
    {
        return [
            'branch_id'         => 'required|exists:branches,id',
            'campaign_title'    => 'required|string|max:255',
            'status'            => 'required|in:pending,active,completed',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'organizers'        => 'nullable|string|max:255',
            'participants_count'=> 'nullable|integer|min:0',
            'description'       => 'nullable|string',
            'planned'           => 'boolean',
        ];
    }
}

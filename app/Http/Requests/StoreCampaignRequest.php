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
            'branch_id'        => 'required|exists:branches,id',
            'campaign_type'    => 'required|string|max:120',
            'campaign_title'   => 'required|string|max:255',
            'campaign_datetime'=> 'required|date',
            'location'         => 'required|string|max:255',
            'audience'         => 'nullable|integer|min:0',
            'description'      => 'nullable|string',
            'planned'          => 'boolean',
            'attachments.*'    => 'file|mimes:pdf,doc,docx,png,jpg,jpeg|max:4096',
        ];
    }
}

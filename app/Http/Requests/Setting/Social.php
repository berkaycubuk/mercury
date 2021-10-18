<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class Social extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'facebook_url' => 'string|nullable',
            'instagram_url' => 'string|nullable',
            'twitter_url' => 'string|nullable',
            'youtube_url' => 'string|nullable',
            'linkedin_url' => 'string|nullable',
            'tiktok_url' => 'string|nullable'
        ];
    }
}

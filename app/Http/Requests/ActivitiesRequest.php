<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivitiesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required|string|max:15',
            'content' => 'required|string|max:150',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(){
        return [
            'video.required'   => trans('activities.video_required'),
            'subject.required' => trans('activities.subject_required'),
            'subject.max'      => trans('activities.subject_max'),
            'content.required' => trans('activities.content_required'),
            'content.max'      => trans('activities.content_max'),
        ];
    }

}

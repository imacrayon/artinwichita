<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        return $user->is('admin') || $this->event->user_id === $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();
        $userId = $user->id;
        if ($user->is('admin') && $request->has('user_id')) {
            $userId = $request->user_id;
        }
        $this->merge(['user_id' => $userId]);

        return [
            'name'        => ['required', 'string'],
            'start_time'  => ['required', 'date_format:Y-m-d H:i:s'],
            'end_time'    => ['nullable', 'after:start_time', 'date_format:Y-m-d H:i:s'],
            'place'       => ['nullable', 'string'],
            'description' => ['nullable', 'max:10000'],
            'user_id'     => ['required', 'exists:users']
        ];
    }
}

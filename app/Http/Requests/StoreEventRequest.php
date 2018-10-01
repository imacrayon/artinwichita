<?php

namespace App\Http\Requests;

use App\Place;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
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
        if ($user->is('admin') && $this->has('user_id')) {
            $userId = $this->user_id;
        }
        $this->merge([
            'place_id' => $this->resolvePlaceFromData()->id,
            'user_id' => $userId,
        ]);

        return [
            'name'        => ['required', 'string'],
            'start_time'  => ['required', 'date_format:Y-m-d H:i:s'],
            'end_time'    => ['nullable', 'after:start_time', 'date_format:Y-m-d H:i:s'],
            'place_id'    => ['required', 'exists:places,id'],
            'description' => ['nullable', 'max:10000'],
            'user_id'     => ['required', 'exists:users,id']
        ];
    }

    public function resolvePlaceFromData()
    {
        $place = new Place();
        $place->user_id = $this->user_id;

        return $place
            ->geocode($this->place)
            ->firstOrCreate(
                $place->coordinates(),
                $place->toArray()
            );
    }
}

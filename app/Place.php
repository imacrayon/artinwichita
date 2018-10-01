<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'name', 'slug',
        'address_line_1', 'address_line_2', 'city', 'state', 'postal_code',
        'longitude', 'latitude',
        'profile',
        'user_id',
    ];

    protected $casts = [
        'profile' => 'array',
    ];

    protected $appends = [
        'full_address',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->slug ? 'slug' : 'id';
    }

    /**
     * Events relationship.
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function fullAddress()
    {
        $fullAddress = '';
        $fullAddress .= trim("{$this->address_line_1} {$this->address_line_2}");
        $fullAddress .= $fullAddress ? ', ' : '';
        $fullAddress .= $this->city;
        $fullAddress .= $fullAddress ? ', ' : '';

        return trim("{$fullAddress}{$this->state} {$this->postal_code}");
    }

    public function getFullAddressAttribute()
    {
        return $this->fullAddress();
    }

    public function getMapUrlAttribute()
    {
        $baseUrl = 'http://maps.apple.com/maps?q=';

        if ($this->latitude && $this->longitude) {
            return $baseUrl . rawurlencode("{$this->latitude},{$this->longitude}");
        }

        if ($fullAddress = $this->fullAddress()) {
            return $baseURl . rawurlencode($fullAddress);
        }

        return null;
    }

    public function coordinates()
    {
        return $this->only(['latitude', 'longitude']);
    }

    public function geocode($address = null)
    {
        $location = $address ?: $this->fullAddress() ?: $this->name;

        return $this->fill(app('geocoder')->locate($location));
    }
}

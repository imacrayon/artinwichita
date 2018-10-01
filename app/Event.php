<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use BelongsToUser, Filterable;

    protected $fillable = [
        'name',
        'start_time', 'end_time',
        'place_id',
        'description',
        'user_id', 'approved_by', 'approved_at',
    ];

    /**
     * The attributes that are converted to Carbon instances.
     *
     * @var string
     */
    protected $dates = ['start_time', 'end_time', 'approved_at'];

    protected $with = ['place'];

    protected function filters()
    {
        return [
            new Filters\StartTime,
            new Filters\EndTime,
            new Filters\Limit,
        ];
    }

    /**
     * Place relationship.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * User relationship.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Approve for display.
     *
     * @return
     */
    public function approve(User $user = null)
    {
        return $this->update([
            'approved_by' => $user ? $user->id : auth()->id(),
            'approved_at' => Carbon::now(),
        ]);
    }

    public function setLocation(Place $place)
    {
        return $this->place()->save($location);
    }
}

<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Http\Request;

class StartTime extends Filter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where(
            'end_time',
            '>=',
            Carbon::createFromFormat('Y-m-d H:i:s', $value)
        );
    }
}

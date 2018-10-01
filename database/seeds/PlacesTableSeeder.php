<?php

use App\Event;
use App\Place;
use Illuminate\Database\Seeder;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = 1;
        factory(Place::class, 50)->create(['user_id' => $userId])->each(function ($place) use ($userId) {
            $place->events()->saveMany(
                factory(Event::class, 5)->make([
                    'user_id' => $userId,
                    'approved_by' => $userId,
                    'place_id' => $place->id
                ])
            );
        });
    }
}

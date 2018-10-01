<?php

namespace Tests\Feature;

use App\Event;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticatedUserCanCreateEvent()
    {
        $this->post('/api/events', [])->assertStatus(403);
    }

    /** @test */
    public function authenticatedUserCanCreateEvent()
    {
        $event = make(Event::class);
        $event->place = '650 N Seneca St, Wichita, KS 67203';

        $this->signIn()
            ->withoutExceptionHandling()
            ->post('/api/events', $event->toArray())
            ->assertStatus(200);
        $this->assertDatabaseHas('events', ['name' => $event->name]);
    }

    /** @test */
    public function userCanGetAllEvents()
    {
        $events = create(Event::class, [], 3);
        $this->get('/api/events')->assertJsonCount(3)->assertSee($events[0]->name);
    }

    /** @test */
    public function userCanFilterEventsByStartTime()
    {
        $eventYesterday = create(Event::class, ['start_time' => Carbon::now()->subDay(1)]);
        $eventTomorrow = create(Event::class, ['start_time' => Carbon::now()->addDay(1)]);

        $this->get('/api/events?start_time=' . Carbon::now()->format('Y-m-d H:i:s'))
            ->assertJsonCount(1)->assertSee($eventTomorrow->name);
    }

    /** @test */
    public function userCanFilterEventsByEndTime()
    {
        $eventYesterday = create(Event::class, ['end_time' => Carbon::now()->subDay(1)]);
        $eventTomorrow = create(Event::class, ['end_time' => Carbon::now()->addDay(1)]);

        $this->get('/api/events?end_time=' . Carbon::now()->format('Y-m-d H:i:s'))
            ->assertJsonCount(1)->assertSee($eventYesterday->name);
    }
}

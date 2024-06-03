<?php

namespace Tests\Feature;

use App\Services\Queue\AccountQueueService;
use Faker\Factory;
use Tests\TestCase;

class PostQueueEventsTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_post_queue_events_sent(): void
    {
        $faker = Factory::create();
        $queues = [];
        $events = [];
        for ($i = 0; $i < 5; $i++) {
            $eventId = $faker->numberBetween(1, 100);
            $accountId = $faker->numberBetween(1, 100);
            $events[] = [
                'event_id' => $eventId,
                'account_id' => $accountId,
            ];

            $queues[AccountQueueService::getQueueName($accountId)] = 1;
        }

        $response = $this->post('/api/events/', ['events' => $events]);
        $response->assertStatus(200);
    }
}

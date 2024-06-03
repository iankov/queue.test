<?php

namespace App\Http\Controllers;

use App\Http\Requests\QueueEventsRequest;
use App\Services\Queue\AccountQueueService;

class ApiController extends Controller
{
    public function queueEvents(QueueEventsRequest $request)
    {
        $data = $request->validated();

        foreach ($data['events'] as $event) {
            AccountQueueService::addToQueue($event['account_id'], $event['event_id']);
        }
    }
}

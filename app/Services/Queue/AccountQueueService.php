<?php

namespace App\Services\Queue;

use App\Jobs\ProcessAccountJob;

class AccountQueueService
{
    protected static $shardsNum = 10;
    protected static $queueName = 'accounts_batch_';

    public static function addToQueue(int $accountId, int $eventId)
    {
        ProcessAccountJob::dispatch(
            $accountId,
            $eventId
        )->onQueue(static::getQueueName($accountId));
    }

    public static function getQueueName(int $accountId): string
    {
        return static::$queueName.($accountId % static::$shardsNum);
    }
}
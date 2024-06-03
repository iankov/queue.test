<?php

namespace App\Console\Commands;

use App\Services\Queue\AccountQueueService;
use Faker\Factory;
use Illuminate\Console\Command;

class FillQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-queue {--count=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = intval($this->option('count'));
        if ($count <= 0) {
            $this->error('Count must be greater then zero');
        }

        $faker = Factory::create();
        $queues = [];
        for ($i = 0; $i < $count; $i++) {
            $eventId = $faker->numberBetween(1, 10);
            $accountId = $faker->numberBetween(1, 1000);

            $queues[AccountQueueService::getQueueName($accountId)] ??= 0;
            $queues[AccountQueueService::getQueueName($accountId)]++;

            AccountQueueService::addToQueue($accountId, $eventId);
        }

        foreach ($queues as $queueName => $count) {
            $this->line('Added to '.$queueName.': '.$count);
        }
    }
}

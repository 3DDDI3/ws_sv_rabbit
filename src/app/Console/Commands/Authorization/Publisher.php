<?php

namespace App\Console\Commands\Authorization;

use App\Events\test;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Publisher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publisher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(config('rabbitmq.host'), config('rabbitmq.port'), config('rabbitmq.user'), config('rabbitmq.password'));
        $channel = $connection->channel();

        $msg = new AMQPMessage('Hello World!');
        $channel->basic_publish($msg, 'catalog', 'request');

        echo " [x] Sent 'Hello World!'\n";

        // broadcast(new test('asdasd'));

        return Command::SUCCESS;
    }
}

<?php
declare(strict_types=1);

namespace App\Plugins;

use Phalcon\Di\DiInterface as Di;
use AMQPConnection;
use AMQPChannel;
use AMQPExchange;
use AMQPQueue;

/**
 * Class RabbitMQ
 * @package App\Plugins
 */
class RabbitMQ
{
    /**
     * @var Di
     */
    private $di;

    private $client;

    protected $exchangeName = 'demo';

    protected $routeKey = 'hello';

    protected $message = 'Hello World!';

    public function __construct($di)
    {
        $this->di = $di;
        $this->connect();
    }

    private function connect()
    {
        $config = $this->di->getShared('config');
        $connection = new AMQPConnection(
            [
                'host' => 'rabbitmq',
                'port' => '5672',
                'vhost' => '/',
                'login' => 'guest',
                'password' => 'guest'
            ]
        );
        $connection->connect();
        try {
            $channel = new AMQPChannel($connection);

            $exchange = new AMQPExchange($channel);
            $exchange->setName($this->exchangeName);
            $exchange->setType(AMQP_EX_TYPE_DIRECT);
            $exchange->setFlags(AMQP_DURABLE);
            $exchange->declareExchange();

            $queue = new AMQPQueue($channel);
            $queue->setName('test_queue');
            $queue->setFlags(AMQP_DURABLE);
            $queue->declareQueue();

            $queue->bind($this->exchangeName, $this->routeKey);

//            $queue->consume(function($event,$queue){
//                $body = $event->getBody();
//                var_dump($body);
//
//                $queue->ack($event->getDeliveryTag());
//            });

            $exchange->publish('Hello World!!', $this->routeKey, AMQP_AUTOACK);

            $channel->close();
            $connection->disconnect();
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
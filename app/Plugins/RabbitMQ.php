<?php
declare(strict_types=1);

namespace App\Plugins;

use App\Exceptions\BusinessException;
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

    private $connection = null;
    private $channel = null;

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

        try {
            $this->connection = new AMQPConnection(
                [
                    'host' => $config->rabbitmq->host,
                    'port' => $config->rabbitmq->port,
                    'vhost' => $config->rabbitmq->vhost,
                    'login' => $config->rabbitmq->login,
                    'password' => $config->rabbitmq->password,
                ]
            );
            if (!$this->connection->connect()) {
                throw new BusinessException(BusinessException::MQ_CONNECT_ERROR);
            }

            $channel = $this->getChannel();

            dd($channel);

            $exchange = new AMQPExchange($this->getChannel());
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
            $this->connection->disconnect();
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * @return AMQPChannel
     * @throws \AMQPConnectionException
     */
    private function getChannel(): AMQPChannel
    {
        if (!$this->channel) {
            $this->channel = new AMQPChannel($this->connection);
        }
        return $this->channel;
    }

    public function sendMsg()
    {
        return true;
    }
}
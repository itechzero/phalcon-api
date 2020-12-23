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

    private $config = [];

    private $connection = null;

    private $channel = null;

    private $exchange = null;

    private $queue = null;

    protected $exchangeName = 'demo';

    protected $routeKey = 'hello';

    protected $message = 'Hello World!';

    public function __construct($di)
    {
        $this->di = $di;
        $this->config = $this->di->getShared('config');
        $this->init();
    }

    public function instance()
    {
        dd(666);
    }

    private function init()
    {
        try {
            $this->connection = new AMQPConnection(
                [
                    'host' => $this->config->rabbitmq->host,
                    'port' => $this->config->rabbitmq->port,
                    'vhost' => $this->config->rabbitmq->vhost,
                    'login' => $this->config->rabbitmq->login,
                    'password' => $this->config->rabbitmq->password,
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
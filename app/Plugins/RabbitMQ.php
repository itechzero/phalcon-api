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

    public function __construct($di)
    {
        $this->di = $di;
        $this->config = $this->di->getShared('config');
        $this->init();
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public function __destruct()
    {
        $this->getChannel()->close();
        $this->connection->disconnect();
    }


    public function instance()
    {
        dd(666);
    }

    private function init()
    {
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

    /**
     * @param $exchange
     * @return AMQPExchange
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    private function getExchange($exchange)
    {
        if (!$this->exchange) {
            $this->exchange = new AMQPExchange($this->getChannel());
            $this->exchange->setName($exchange);
            $this->exchange->setType(AMQP_EX_TYPE_DIRECT);
            $this->exchange->setFlags(AMQP_DURABLE);
            $this->exchange->declareExchange();
        }
        return $this->exchange;
    }

    /**
     * @param $exchange
     * @param $routeKey
     * @param $queue
     * @return AMQPQueue
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPQueueException
     */
    private function getQueue($exchange,$routeKey,$queue)
    {
        if (!$this->queue) {
            $this->queue = new AMQPQueue($this->getChannel());
            $this->queue->setName($queue);
            $this->queue->setFlags(AMQP_DURABLE);
            $this->queue->declareQueue();
            $this->queue->bind($exchange, $routeKey);
        }
        return $this->queue;
    }

    /**
     * @param $exchange
     * @param $msg
     * @param $routeKey
     */
    public function sendMsg($exchange,$msg,$routeKey)
    {
        try {
            $this->getExchange($exchange)->publish($msg,$routeKey,AMQP_AUTOACK);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }
}
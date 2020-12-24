<?php
declare(strict_types=1);

namespace App\Plugins;

use App\Exceptions\BusinessException;
use Phalcon\Di\DiInterface as Di;
use AMQPConnection;
use AMQPChannel;
use AMQPExchange;
use AMQPQueue;
use Exception;

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

    /**
     * @var null
     */
    private $connection = null;

    /**
     * @var AMQPChannel
     */
    private $channel = null;

    private $exchange = null;

    /**
     * @var AMQPQueue
     */
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


    public function instance(string $exchange = '', string $routeKey = '', string $queue = '')
    {
        if (!$exchange || !$routeKey || !$queue) {
            throw new BusinessException(BusinessException::MQ_CONNECT_ERROR);
        }

        $this->setExchange($exchange);
        $rs = $this->setQueue($exchange, $routeKey, $queue);
        dd($rs);
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
     * @return AMQPChannel|null
     */
    private function getChannel()
    {
        if (!$this->channel) {
            $this->channel = $this->setChannel();
        }
        return $this->channel;
    }

    /**
     * @return AMQPChannel
     * @throws \AMQPConnectionException
     */
    private function setChannel()
    {
        $this->channel = new AMQPChannel($this->connection);
        return $this->channel;
    }

    /**
     * @return null
     */
    private function getExchange()
    {
        return $this->exchange;
    }

    /**
     * @param $exchange
     * @return AMQPExchange
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    private function setExchange($exchange)
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
     * @return AMQPQueue
     */
    private function getQueue(): AMQPQueue
    {
        return $this->queue;
    }

    /**
     * @param string $exchange
     * @param string $routeKey
     * @param string $queue
     * @return AMQPQueue
     */
    private function setQueue(string $exchange = '', string $routeKey = '', string $queue = '')
    {
        try {
            if (!$this->queue) {
                $this->queue = new AMQPQueue($this->getChannel());
                $this->queue->setName($queue);
                $this->queue->setFlags(AMQP_DURABLE);
                $this->queue->declareQueue();
                $this->queue->bind($exchange, $routeKey);
            }
            return $this->queue;
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * @param $exchange
     * @param $msg
     * @param $routeKey
     */
    public function sendMsg($exchange, $msg, $routeKey)
    {

        try {
            $this->getExchange($exchange)->publish($msg, $routeKey, AMQP_AUTOACK);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
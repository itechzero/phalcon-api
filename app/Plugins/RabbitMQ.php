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
     * @var AMQPConnection
     */
    private $connection = null;

    /**
     * @var AMQPChannel
     */
    private $channel = null;

    /**
     * @var AMQPExchange
     */
    private $exchange = null;

    /**
     * @var AMQPQueue
     */
    private $queue = null;

    private $routeKey = null;

    private static $instance = null;

    public function __construct(Di $di)
    {
        $this->di = $di;
        $this->config = $this->di->getShared('config');
    }

    public function instance(string $exchange = '', string $routeKey = '', string $queue = '')
    {
        if (!$exchange || !$routeKey || !$queue) {
            throw new BusinessException(BusinessException::MQ_CONNECT_ERROR);
        }

        if (!self::$instance instanceof RabbitMQ) {
            $this->setConnection();
            $this->setChannel();
            $this->setExchange($exchange);
            $this->setQueue($exchange, $routeKey, $queue);
            $this->routeKey = $routeKey;
            self::$instance = $this;
        }

        return self::$instance;
    }

    /**
     * @return AMQPConnection|null
     */
    private function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return AMQPConnection
     * @throws BusinessException
     * @throws \AMQPConnectionException
     */
    private function setConnection()
    {
        try {
            if (!$this->getConnection()) {
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
            return $this->connection;
        } catch (Exception $exception) {
            throw new BusinessException(1001, $exception->getMessage());
        }
    }

    /**
     * @return AMQPChannel|null
     */
    private function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return AMQPChannel
     * @throws BusinessException
     */
    private function setChannel()
    {
        try {
            if (!$this->getChannel()) {
                $this->channel = new AMQPChannel($this->getConnection());
            }
            return $this->channel;
        } catch (Exception $exception) {
            throw new BusinessException(1002, $exception->getMessage());
        }
    }

    /**
     * @return AMQPExchange|null
     */
    private function getExchange()
    {
        return $this->exchange;
    }

    /**
     * AMQP_EX_TYPE_DIRECT:直连交换机
     * AMQP_EX_TYPE_FANOUT:扇形交换机
     * AMQP_EX_TYPE_HEADERS:头交换机
     * AMQP_EX_TYPE_TOPIC:主题交换机
     * @param $exchange
     * @return AMQPExchange
     * @throws BusinessException
     */
    private function setExchange(string $exchange = '')
    {
        try {
            if (!$this->getExchange()) {
                $this->exchange = new AMQPExchange($this->getChannel());
                $this->exchange->setName($exchange);
                $this->exchange->setType(AMQP_EX_TYPE_DIRECT);
                $this->exchange->setFlags(AMQP_DURABLE);//交换机持久
                $this->exchange->declareExchange();
            }
            return $this->exchange;
        } catch (Exception $exception) {
            throw new BusinessException(1003, $exception->getMessage());
        }
    }

    /**
     * @return AMQPQueue|null
     */
    private function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param string $exchange
     * @param string $routeKey
     * @param string $queue
     * @return AMQPQueue
     * @throws BusinessException
     */
    private function setQueue(string $exchange = '', string $routeKey = '', string $queue = '')
    {
        try {
            if (!$this->getQueue()) {
                $this->queue = new AMQPQueue($this->getChannel());
                $this->queue->setName($queue);
                $this->queue->setFlags(AMQP_DURABLE);
                $this->queue->declareQueue();
                $this->queue->bind($exchange, $routeKey);
            }
            return $this->queue;
        } catch (Exception $exception) {
            throw new BusinessException(1005, $exception->getMessage());
        }
    }

    public function __clone()
    {
    }

    public function __destruct()
    {
        if (!is_null($this->getChannel())) {
            $this->getChannel()->close();
        }

        if (!is_null($this->getConnection())) {
            $this->getConnection()->disconnect();
        }

    }

    /**
     * 生产者在生产消息时，如果不存在指定队列，并且没有创建队列，或者队列存在但消息路由键和交换机与队列绑定的键(路由规则)不一致（直连交换机必须一致）,则消息会被交换机丢弃
     * @param string $msg
     * @return bool
     * @throws BusinessException
     */
    public function sendMsg(string $msg = '')
    {
        try {
            //$this->getChannel()->startTransaction();
            //delivery_mode:2声明消息持久,持久的队列+持久的消息在RabbitMQ重启后才不会丢失
            return $this->getExchange()->publish($msg, $this->routeKey, AMQP_NOPARAM, ['delivery_mode' => 2]);
            //$this->getChannel()->commitTransaction();
        } catch (Exception $exception) {
            //$this->getChannel()->rollbackTransaction();
            throw new BusinessException(1006, $exception->getMessage());
        }
    }

    public function consumeMsg()
    {
        try {
//            $this->getQueue()->consume(function ($event, $queue){
//                $body = $event->getBody() ? json_decode($event->getBody(),true) : '';
//                var_dump($body);
//                $queue->ack($event->getDeliveryTag());
//            },AMQP_AUTOACK);//隐式确认,不推荐
            $this->getQueue()->consume(function ($event, $queue) {
                $body = $event->getBody() ? json_decode($event->getBody(), true) : '';
                var_dump($body);
                $queue->ack($event->getDeliveryTag());//显式确认，队列收到消费者显式确认后，会删除该消息
            });
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
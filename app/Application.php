<?php
declare(strict_types=1);

namespace App;

use Phalcon\Events\Event;
use Phalcon\Http\Response;
use Phalcon\Mvc\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct($container = null)
    {
        parent::__construct($container);
    }

    public function beforeSendResponse(Event $event, BaseApplication $app, Response $response)
    {
        $content = $this->dispatcher->getReturnedValue();

        if ($content instanceof Response) {
            $content    = json_decode($response->getContent(), true);
        }

        if ($content instanceof \Phalcon\Mvc\Model) {
            $content =  $content->toArray();
        }

        if (NULL === $content || FALSE === $content) {
            $content    = (Object) [];
        }

        if (is_array($content)) {
            if (!isset($content['code'])) {
                $response->setJsonContent(
                    [
                        'code'  => 200,
                        'msg'   => 'success',
                        'data'  => $content,
                    ]
                );
            } else {
                $response->setJsonContent($content);
            }
        }



        if ((Object) [] == $content) {
            $response->setJsonContent(
                [
                    'code'  => 200,
                    'msg'   => 'success',
                    'data'  => (Object) $content,
                ]
            );
        }
        $traceId = $this->request->getHeader('X-Request-Id');
        if (empty($traceId)) {
            $traceId = $this->request->getServer('X-Request-Id');
        }

        $response->setHeader('X-Request-Id', $traceId);

        //$this->getDI()->get('log')->info(sprintf('response：%s', $response->getContent()));
        return $event->isStopped();
    }

}
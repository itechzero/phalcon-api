<?php
declare(strict_types=1);

namespace App;

use App\Struct\ResponseStruct;
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
            $content = json_decode($response->getContent(), true);
        }

        if (NULL === $content || FALSE === $content) {
            $content = (object)[];
        }

        if (is_array($content)) {
            if (!isset($content['code'])) {
                $response->setJsonContent(
                    [
                        'code' => 0,
                        'msg' => 'success',
                        'data' => (object)$content,
                    ]
                );
            } else {
                $response->setJsonContent($content);
            }
        }

        if ($content instanceof ResponseStruct) {
            $msg = $content->getMsg();
            $responseData = [
                'code' => $content->getCode(),
                'msg' => $msg,
                'data' => $content->getData(),
            ];

            $response->setJsonContent($responseData);
        }

        if ((object)[] == $content) {
            $response->setJsonContent(
                [
                    'code' => 0,
                    'msg' => 'success',
                    'data' => (object)$content,
                ]
            );
        }
        $traceId = $this->request->getHeader('X-Request-Id');
        if (empty($traceId)) {
            $traceId = $this->request->getServer('X-Request-Id');
        }

        $response->setHeader('X-Request-Id', $traceId);

        $this->di->getShared('log')->info(sprintf('response：%s', $response->getContent()));

        return $event->isStopped();
    }

}
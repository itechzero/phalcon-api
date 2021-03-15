<?php
declare(strict_types=1);

namespace App\Plugins;

use Phalcon\Http\Response;

class Responder
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var string
     */
    protected $contentType;

    public function __construct(Response $response, string $contentType)
    {
        $this->response    = $response;
        $this->contentType = $contentType;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }
}
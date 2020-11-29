<?php
declare(strict_types=1);

namespace App\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    // Implement common logic
    public function response()
    {
        return $this->response->setJsonContent(['code' => 0,'msg' => 'success','data' => (object)[]]);
    }
}

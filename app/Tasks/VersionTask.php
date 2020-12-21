<?php
declare(strict_types=1);

namespace App\Tasks;

use Phalcon\Cli\Task;

class VersionTask extends Task
{
    public function mainAction()
    {
        $config = $this->getDI()->get('config');
        echo sprintf('Congratulations! You are now flying with Phalcon CLI %s',$config['version']);
    }
}

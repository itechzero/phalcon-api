<?php
declare(strict_types=1);

use Phalcon\Cli\Task;

class VersionTask extends Task
{
    public function mainAction()
    {
        $config = $this->getDI()->get('config');

        echo $config['version'];
    }
}

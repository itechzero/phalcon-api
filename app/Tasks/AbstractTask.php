<?php
declare(strict_types=1);

namespace App\Tasks;

use Phalcon\Cli\Task;

abstract class AbstractTask extends Task
{
    abstract public function mainAction();

    abstract public function runAction();
}
<?php
declare(strict_types=1);

namespace App\Tasks;

use Phalcon\Cli\Console;

/**
 * @property Console $console
 */
class MainTask extends AbstractTask
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
        $this->console->handle(
            [
                'task'   => 'main',
                'action' => 'run',
            ]
        );
    }

    public function runAction()
    {
        echo 'I will get printed too!' . PHP_EOL;
    }
}
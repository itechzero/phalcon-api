<?php
declare(strict_types=1);

namespace App\Tasks;

class VersionTask extends AbstractTask
{
    public function mainAction()
    {
        //$config = $this->di->get('config');
        $config = $this->getDI()->get('config');
        echo sprintf('Congratulations! You are now flying with Phalcon CLI %s', $config['version']) . PHP_EOL;
        echo sprintf('Congratulations! You are now flying with Phalcon CLI %s', $config->get('version')) . PHP_EOL;
        echo sprintf('Congratulations! You are now flying with Phalcon CLI %s', $config->version) . PHP_EOL;
        echo sprintf('Congratulations! You are now flying with Phalcon CLI %s', $config->path('version')) . PHP_EOL;
    }

    public function runAction()
    {
        $this->di->getShared('config');
    }
}

<?php
declare(strict_types=1);

namespace App\Traits;

use Phalcon\Di\DiInterface as Di;

trait DiTrait
{
    /**
     * @var Di
     */
    private $di;

    /**
     * DiTrait constructor.
     */
    public function __construct(Di $di)
    {
        $this->di = $di;
    }

    public function getDI()
    {
        return $this->di;
    }
}
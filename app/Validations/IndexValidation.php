<?php
declare(strict_types=1);

namespace App\Validations;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class IndexValidation extends Validation
{
    public function initialize()
    {
        $this->add(
            'sign',
            new PresenceOf(
                [
                    'message' => 'The sign is required',
                ]
            )
        );
    }
}
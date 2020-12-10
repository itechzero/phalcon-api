<?php
declare(strict_types=1);

namespace App\Validations;

use Phalcon\Validation;
use Phalcon\Messages\Message;
use Phalcon\Validation\Validator\PresenceOf;

class BaseValidation extends Validation
{
    public function beforeValidation($data, $entity, $messages)
    {
//        if ($this->request->getHttpHost() !== 'mydomain.com') {
//            $messages->appendMessage(
//                new Message(
//                    'Only users can log on in the  domain'
//                )
//            );
//
//            return false;
//        }

        return true;
    }

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
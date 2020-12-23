<?php
declare(strict_types=1);

namespace App\Validations;

use Phalcon\Validation\Validator\Callback;
use Phalcon\Validation\Validator\PresenceOf;

class IndexValidation extends BaseValidation
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

//        $this->add(
//            'ext',
//            new Callback(
//                [
//                    'callback' => function ($data) {
//
//                        if (empty($data['ext'])) {
//                            return false;
//                        }
//
//                        $ext = json_decode($data['ext'], true);
//
//                        if (empty($ext['resid'])) {
//                            return false;
//                        }
//
//                        return true;
//                    },
//                    'message' => 'The ext error'
//                ]
//            )
//        );
    }
}
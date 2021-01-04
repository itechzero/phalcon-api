<?php
declare(strict_types=1);

namespace App\Models;

use Phalcon\Mvc\Model\Exception;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class User extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $status;

    /**
     *
     * @var integer
     */
    public $created_at;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
//    public function validation()
//    {
//        $validator = new Validation();
//
//        $validator->add(
//            'username',
//            new EmailValidator(
//                [
//                    'model'   => $this,
//                    'message' => 'Please enter a correct email address',
//                ]
//            )
//        );
//
//        return $this->validate($validator);
//    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("demo");
        $this->setSource("users");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface
     */
    public static function findFirst($parameters = null):?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

    public function beforeSave()
    {
        if (0 === $this->id) {
            throw new Exception('id is not empty');
        }
        return true;
    }

}

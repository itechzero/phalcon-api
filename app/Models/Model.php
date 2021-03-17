<?php
declare(strict_types=1);

namespace App\Models;

use App\Exceptions\BusinessModelException;
use Phalcon\Mvc\Model as EloquentModel;

/**
 * Class Model
 * @package App\Models
 */
class Model extends EloquentModel
{
    public function beforeCreate()
    {
        if (property_exists($this, 'created_at')) {
            $this->created_at = time();
        }

        if (property_exists($this, 'updated_at')) {
            $this->updated_at = time();
        }
    }

    public function beforeUpdate()
    {
        if (property_exists($this, 'updated_at')) {
            $this->updated_at = time();
        }
    }

    public function beforeValidation()
    {

    }

    public function beforeSave()
    {

    }

    public function afterFetch()
    {
        //return true;
    }

    public function afterSave()
    {
        //return true;
    }

    public function notSaved()
    {
        // Show messages
    }

//    public function selectReadConnection(
//        $intermediate,
//        $bindParams,
//        $bindTypes
//    ) {
//        if (true === isset($intermediate['where'])) {
//            $conditions = $intermediate['where'];
//
//            if ($conditions['left']['name'] === 'id') {
//                $id = $conditions['right']['value'];
//
//                if ($id > 0 && $id < 10000) {
//                    return $this->getDI()->get('dbShard1');
//                }
//
//                if ($id > 10000) {
//                    return $this->getDI()->get('dbShard2');
//                }
//            }
//        }
//
//        return $this->getDI()->get('dbShard0');
//    }
}
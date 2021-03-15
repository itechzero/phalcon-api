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
        $this->created_at = time();
    }

    public function beforeUpdate()
    {
        $this->updated_at = time();
    }

    public function beforeSave()
    {
        if (0 === $this->id) {
            throw new BusinessModelException(2000);
        }
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
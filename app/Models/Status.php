<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const STATUS_AVAILABLE = 2;
    const STATUS_ONLOAN = 3;
    const STATUS_ONHOLD = 4;
    const STATUS_INTEST = 5;
    const STATUS_INREPAIR = 6;
    const STATUS_MIA = 7;
    const STATUS_SCRAPPED = 8;
    const STATUS_GIVENAWAY = 9;

    public $table = 'Status';

    /**
     * Get the status name
     *
     * @param $statusId
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public static function getName($statusId)
    {
        $constants = new \ReflectionClass(__CLASS__);

        $constantNames = array_flip($constants->getConstants());

        return array_get($constantNames, $statusId, 'Unknown');
    }

}
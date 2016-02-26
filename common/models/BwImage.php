<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 26.02.2016
 * Time: 15:58
 */

namespace common\models;

use yii\imagine\Image;

class BwImage extends Image
{
    public static $driver = [parent::DRIVER_GD2];
}
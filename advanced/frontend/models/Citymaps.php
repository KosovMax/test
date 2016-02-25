<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "citymaps".
 *
 * @property integer $cityid
 * @property string $address
 * @property string $coorYX
 * @property string $color
 * @property string $date
 */
class Citymaps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'citymaps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'coorYX', 'color', 'date'], 'required'],
            [['address'], 'string', 'max' => 500],
            [['coorYX', 'color', 'date'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cityid' => 'Cityid',
            'address' => 'Адрес',
            'coorYX' => 'Координат',
            'color' => 'Колір',
            'date' => 'Дата',
            'search' => ''
        ];
    }
}

<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "upload".
 *
 * @property integer $upid
 * @property string $name
 */
class Upload extends Model
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'upload';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'],'file', 'extensions'=>['png', 'jpg', 'gif'],'skipOnEmpty' => true]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => '',
        ];
    }
}

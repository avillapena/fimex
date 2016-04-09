<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "v_NumClienteCerty".
 *
 * @property integer $Certy
 * @property string $Cliente
 */
class VNumClienteCerty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_NumClienteCerty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Certy'], 'integer'],
            [['Cliente'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Certy' => 'Certy',
            'Cliente' => 'Cliente',
        ];
    }
}

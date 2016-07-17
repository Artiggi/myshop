<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "attributes".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 *
 * @property AttrProd[] $attrProds
 */
class Attributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['name', 'value'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrProds()
    {
        return $this->hasMany(AttrProd::className(), ['attr_id' => 'id']);
    }
}

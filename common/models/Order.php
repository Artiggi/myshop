<?php
namespace common\models;
use Yii;


class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function rules()
    {
        return [
            [['price'], 'number'],
            [['count', 'product_id'], 'integer'],
            [['status'], 'string', 'max' => 80],
            [['count'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'product_id' => 'Product ID',
            'count' => 'Введите количество:',
            'status' => 'Status',
            'customer_id' => 'Customer'
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    public function getProductName()
    {
        return $this->product->name;
    }

    public function getProductCount()
    {
        return $this->product->count;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
}
<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property double $price
 * @property integer $count
 * @property integer $cat_id
 *
 * @property AttrProd[] $attrProds
 * @property Category $cat
 */
class Products extends \yii\db\ActiveRecord 
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['count', 'cat_id'], 'integer'],
            [['name'], 'string', 'max' => 80],
            [['cat_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'price' => 'Цена',
            'count' => 'Количество',
            'cat_id' => 'Cat ID',
            'catName' => 'Категория',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrs()
    {
        return $this->hasMany(Attributes::className(), ['prod_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }

    public function getCatName()
    {
        return $this->cat->name;
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['product_id' => 'id']);
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getId()
    {
        return $this->id;
    }


}

<?php
namespace frontend\controllers;
use common\models\Category;
use common\models\Products;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class CatalogController extends \yii\web\Controller
{
    
/*
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            Url::remember();
            return true;
        } else {
            return false;
        }
    }
*/

    public function actionList($id = null)
    {

        $category = null;
        $categories = Category::find()->indexBy('id')->orderBy('id')->all();
        $productsQuery = Products::find()->where(['>', 'count', 0]);
        if ($id !== null && isset($categories[$id])) {
            $category = $categories[$id];
            $productsQuery->where(['id' => $this->getCategoryIds($categories, $id)]);
        }
        $productsDataProvider = new ActiveDataProvider([
            'query' => $productsQuery,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $this->render('list', [
            'category' => $category,
            'productsDataProvider' => $productsDataProvider,
        ]);
    }

}

<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\Products;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class ProductController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
    	$model = new Products;
    	return $this->render('add', [
    		'model' => $model
    		]);
    }

}

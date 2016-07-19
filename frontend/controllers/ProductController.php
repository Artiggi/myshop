<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\Products;
use frontend\models\Attributes;
use frontend\models\Model;
//use yii\base\Model;
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
        $modelAttr = [new Attributes];

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $modelAttr = Model::createMultiple(Attributes::classname());
            Model::loadMultiple($modelAttr, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelAttr) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelAttr as $modelAttr) {
                            $modelAttr->prod_id = $model->id;
                            if (! ($flag = $modelAttr->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['create']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            return $this->redirect(['create']);
        } 
        else {
    	return $this->render('add', [
    		'model' => $model,
            'modelAttr' => (empty($modelAttr)) ? [new Attributes] : $modelAttr,
    		]);
        }
    }

}

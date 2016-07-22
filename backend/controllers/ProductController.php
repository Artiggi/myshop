<?php
namespace backend\controllers;
use Yii;
use common\models\User;
use common\models\Products;
use backend\models\ProductsSearch;
use common\models\Attributes;
use common\models\Category;
use backend\models\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;




class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products;
        $modelAttr = [new Attributes];
        $cat = Category::find()->all();
        $catItems = ArrayHelper::map($cat,'id','name');
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
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else {
        return $this->render('add', [
            'model' => $model,
            'modelAttr' => (empty($modelAttr)) ? [new Attributes] : $modelAttr,
            'catItems' => $catItems,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)

    {
        $model = $this->findModel($id);
        $modelAttr = $model->attrs;
        $cat = Category::find()->all();
        $catItems = ArrayHelper::map($cat,'id','name');
        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelAttr, 'id', 'id');
            $modelAttr = Model::createMultiple(Attributes::classname(), $modelAttr);
            Model::loadMultiple($modelAttr, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelAttr, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelAttr) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Attributes::deleteAll(['id' => $deletedIDs]);
                        }
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
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelAttr' => (empty($modelAttr)) ? [new Attributes] : $modelAttr,
            'catItems' => $catItems,
        ]);

    }
    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
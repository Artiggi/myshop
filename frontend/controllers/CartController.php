<?php
namespace frontend\controllers;
use Yii;
use common\models\Order;
use common\models\OrderItem;
use common\models\Products;


class CartController extends \yii\web\Controller
{
    public function actionAdd($id)
    {
        $product = Products::findOne($id);
        $order = new Order();
        $order->price = $product->price;
        $order->product_id = $product->id;
        $order->count = 0;
        $order->status = 'new';
        $order->customer_id = Yii::$app->user->id;
        $order->save();
        return $this->redirect(['cart/list', 'id' => $order->id]);
    }

    public function actionList($id)
    {
        $model = $this->findOrder($id);
        $model->status = 'confirmed';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $product = Products::findOne($model->product);
            if($product->count < $model->count || $model->count == 0) {
                Yii::$app->getSession()->setFlash('danger', 'Количество товара превышено не может быть 0 или больше доступного');
                $model->status = 'failed';
                $model->save();
                return $this->redirect(['cart/list', 'id' => $model->id]);
            }
            else {
                $product->count = $product->count - $model->count;
                $product->save();
                return $this->redirect(['catalog/list']);
            }          
        } else {
            return $this->render('list', [
                'model' => $model,
            ]);
        }
    }

    public function actionRemove($id)
    {
        $this->findOrder($id)->delete();
        return $this->redirect(['catalog/list']);
    }

    public function actionOrder()
    {
        $order = new Order();
        /* @var $cart ShoppingCart */
        $cart = \Yii::$app->cart;
        /* @var $products Product[] */
        $products = $cart->getPositions();
        $total = $cart->getCost();
        if ($order->load(\Yii::$app->request->post()) && $order->validate()) {
            $transaction = $order->getDb()->beginTransaction();
            $order->save(false);
            foreach($products as $product) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->title = $product->title;
                $orderItem->price = $product->getPrice();
                $orderItem->product_id = $product->id;
                $orderItem->quantity = $product->getQuantity();
                if (!$orderItem->save(false)) {
                    $transaction->rollBack();
                    \Yii::$app->session->addFlash('error', 'Cannot place your order. Please contact us.');
                    return $this->redirect('catalog/list');
                }
            }
            $transaction->commit();
            \Yii::$app->cart->removeAll();
            \Yii::$app->session->addFlash('success', 'Thanks for your order. We\'ll contact you soon.');
            $order->sendEmail();
            return $this->redirect('catalog/list');
        }
        return $this->render('order', [
            'order' => $order,
            'products' => $products,
            'total' => $total,
        ]);
    }

    protected function findOrder($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
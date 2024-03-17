<?php

namespace frontend\controllers;

use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class CartController extends Controller
{
    public function actionShow()
    {
        //создаем модель заказа и пользователя туда если он есть
        $order = new Order();
        if (!Yii::$app->user->isGuest) {
            $order->user_id = Yii::$app->user->getId();
            $load['Order'] = ArrayHelper::toArray(Yii::$app->user->identity);
            $order->load($load);
        }
        $order->status = Order::STATUS_WAITING;
        $order->total = 0;

        //переобразуем масив корзины с куков с товарам
        $cart = [];
        if (isset($_COOKIE['cart'])) $cart = Json::decode($_COOKIE['cart']);
        foreach ($cart as &$item) {
            $product = Product::find()->joinWith('category')->one();
            $item['product'] = $product;
            if ($product) {
                $order->total = $order->total + $item['count'] * $item['product']['price'];
            }
        }

        //если пост, то оформление заказа
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            if ($order->load($post) && $order->save()) {
                foreach ($cart as $item) {
                    if($item['product']){
                        $order_item = new OrderItem();
                        $order_item->order_id = $order->id;
                        $order_item->product_id = $item['id'];
                        $order_item->count = $item['count'];
                        $order_item->price = $item['product']['price'];
                        if(!$order_item->save()){
                            $order->addError('id', Yii::t('app', 'Помилка створення замовленн. Щось не так! Очистити кошик і спробуйте знову.'));
                        }
                    }
                }

                if (!$order->hasErrors()) {
                    $transaction->commit();
                    return $this->redirect('success?id='.$order->id);
                }
            }

            $transaction->rollback();
        }

        return $this->render('show', [
            'cart' => $cart,
            'order' => $order
        ]);
    }

    public function actionSuccess($id)
    {
        unset($_COOKIE['cart']);
        setcookie('cart', null, -1, '/');
        Yii::$app->session->setFlash('success', Yii::t('app', 'Замовлення було успішно створений.'));

        $order = Order::findOne($id);
        if(!$order) throw new NotFoundHttpException('Запитувана сторінка не існує.');

        return $this->render('success', [
            'order' => $order
        ]);
    }

    public function actionClear()
    {
        unset($_COOKIE['cart']);
        setcookie('cart', null, -1, '/');

        Yii::$app->session->setFlash('success', Yii::t('app', 'Кошик успішно очищен.'));
        $this->redirect(['site/index']);
    }
}


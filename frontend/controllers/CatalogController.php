<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\CategoryField;
use common\models\forms\FilterForm;
use common\models\Product;
use common\models\ProductField;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    public function actionIndex($alias)
    {
        $model = Category::findOne(['alias' => 'catalog/' . $alias]);
        if (!$model) throw new NotFoundHttpException('Запитувана сторінка не існує.');

        Yii::$app->view->registerMetaTag([
            'title' => 'keywords',
            'content' => $model->seo_keywords
        ]);

        Yii::$app->view->registerMetaTag([
            'title' => 'description',
            'content' => $model->seo_description
        ]);

        //ищу все поля данной категории
        $fields = CategoryField::find()->select([
            'field.id',
            'field.name',
            'field.type',
            'field.prefix',
            'field.suffix',
            'field.number_after_point',
            'field.options',
            'category_field.list',
            'category_field.filter'
        ])->joinWith(['field'])->where([
            'category_id' => $model->id
        ])->orderBy(['depth' => SORT_ASC])->createCommand()->queryAll();

        //ищем все вложеные категории
        $categories_ids = Category::getChildCategoriesIds($model->id);

        //применяю фильтры - ищу индитификаторы обьектов
        $products_ids = ProductField::find()->select(['product_id'])->joinWith('product');

        $get = null;
        $use_filter = 0;
        if (Yii::$app->request->isGet) $get = Yii::$app->request->get();
        $search = [];
        foreach ($fields as $field) {
            if ($field['filter']) {
                //создаю модели для фильтра
                $search[$field['id']] = new FilterForm();
                if (isset($get['FilterForm']['value'][$field['id']])) $search[$field['id']]->value = $get['FilterForm']['value'][$field['id']];
                if (isset($get['FilterForm']['from'][$field['id']])) $search[$field['id']]->from = $get['FilterForm']['from'][$field['id']];
                if (isset($get['FilterForm']['to'][$field['id']])) $search[$field['id']]->to = $get['FilterForm']['to'][$field['id']];

                if ($search[$field['id']]->value) {
                    $use_filter++;
                    $products_ids->orWhere([
                        'and',
                        ['in', 'product.category_id', $categories_ids],
                        ['product_field.field_id' => $field['id']],
                        ['like', 'product_field.value', $search[$field['id']]->value],
                    ]);
                } elseif ($search[$field['id']]->from and $search[$field['id']]->to) {
                    $use_filter++;
                    $products_ids->orWhere([
                        'and',
                        ['in', 'product.category_id', $categories_ids],
                        ['product_field.field_id' => $field['id']],
                        ['>=', 'product_field.value', $search[$field['id']]->from],
                        ['<=', 'product_field.value', $search[$field['id']]->to],
                    ]);
                }
            }
        }

        $products_ids = $products_ids->groupBy(['product_id'])->having(['count(*)' => $use_filter])->column();

        //запрос на поиск товаров
        $products = Product::find()->with([
            'productFields'
        ])->where([
            'in', 'category_id', $categories_ids
        ]);

        //если заюзан ходь один раз фильтр
        if ($use_filter) {
            $products_ids[] = 0;
            $products->where(['in', 'id', $products_ids]);
        }

        // делаем пагинацию
        $countQuery = clone $products;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $pages->pageSizeParam = false;

        $products = $products->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        foreach ($products as &$product) {
            $product['fields'] = [];
            foreach ($fields as $key => $value) {
                $product['fields'][$key] = $value;
                foreach ($product['productFields'] as $value2) {
                    if ($value['id'] == $value2['field_id']) {
                        $product['fields'][$key]['value'] = $value2['value'];
                        break;
                    }
                }
            }

            unset($product['productFields']);
        }

        return $this->render('index', [
            'model' => $model,
            'products' => $products,
            'fields' => $fields,
            'search' => $search,
            'pages' => $pages,
        ]);
    }

    public function actionProduct($alias, $slug)
    {
        //запрос на поиск обьектов
        $product = Product::find()->with([
            'productFields', 'category'
        ])->where(['=', 'slug', $slug])->asArray()->one();

        if (!$product) {
            throw new NotFoundHttpException('Запитувана сторінка не існує.');
        }

        $category = Category::findOne($product['category_id']);
        if (!$category) {
            throw new NotFoundHttpException('Запитувана сторінка не існує.');
        }

        Yii::$app->view->registerMetaTag([
            'title' => 'keywords',
            'content' => $product['seo_keywords']
        ]);

        Yii::$app->view->registerMetaTag([
            'title' => 'description',
            'content' => $product['seo_description']
        ]);

        //ищу все поля данной категории
        $fields = CategoryField::find()->select([
            'field.id',
            'field.name',
            'field.type',
            'field.prefix',
            'field.suffix',
            'field.number_after_point',
            'field.options',
            'category_field.list',
            'category_field.filter'
        ])->joinWith(['field'])->where([
            'category_id' => $product['category_id']
        ])->orderBy(['depth' => SORT_ASC])->createCommand()->queryAll();

        $product['fields'] = [];
        foreach ($fields as $key => $value) {
            $product['fields'][$key] = $value;
            foreach ($product['productFields'] as $value2) {
                if ($value['id'] == $value2['field_id']) {
                    $product['fields'][$key]['value'] = $value2['value'];
                    break;
                }
            }
        }
        unset($product['productFields']);

        return $this->render('product', [
            'product' => $product,
        ]);
    }
}


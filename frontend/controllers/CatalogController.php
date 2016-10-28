<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class CatalogController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            Url::remember();
            return true;
        } else {
            return false;
        }
    }

    public function actionList($id = null)
    {
        /** @var Category $category */
        $category = null;

        $categories = Category::find()->indexBy('id')->orderBy('id')->all();

        $productsQuery = Product::find();
        if ($id !== null && isset($categories[$id])) {
            $category = $categories[$id];
            $productsQuery->where(['category_id' => $this->getCategoryIds($categories, $id)]);
        }

        $productsDataProvider = new ActiveDataProvider([
            'query' => $productsQuery,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $breadcrumbs = [];
        if ($category) {
            $parent = $category->parent_id;
            while ($parent) {
                $breadcrumb = [
                    'label' => $categories[$parent]->title,
                    'url' => ['catalog/list', 'id' => $parent],
                ];
                array_unshift($breadcrumbs, $breadcrumb);
                $parent = $categories[$parent]->parent_id;
            }
        }

        return $this->render('list', [
            'category' => $category,
            'menuItems' => $this->getMenuItems($categories, isset($category->id) ? $category->id : null),
            'productsDataProvider' => $productsDataProvider,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function actionView()
    {
        return $this->render('view');
    }

    /**
     * @param Category[] $categories
     * @param int $activeId
     * @param int $parent
     * @return array
     */
    private function getMenuItems($categories, $activeId = null, $parent = null)
    {
        $menuItems = [];
        foreach ($categories as $category) {
            if ($category->parent_id === $parent) {
                $childItems =  $this->getMenuItems($categories, $activeId, $category->id);
                $menuItems[$category->id] = [
                    'active' => $activeId === $category->id,
                    'label' => $category->title,
                    'url' => ['catalog/list', 'id' => $category->id],
//                    'url' => '#',
                    'items' => $childItems/*$this->getMenuItems($categories, $activeId, $category->id)*/,
                    'template' => '<a class="tree-toggle" href="{url}">{label}' . (empty($childItems) ? '' : '<b class="caret"></b>') . '</a>',
                ];
            }
        }
        return $menuItems;
    }


    /**
     * Returns IDs of category and all its sub-categories
     *
     * @param Category[] $categories all categories
     * @param int $categoryId id of category to start search with
     * @param array $categoryIds
     * @return array $categoryIds
     */
    private function getCategoryIds($categories, $categoryId, &$categoryIds = [])
    {
        foreach ($categories as $category) {
            if ($category->id == $categoryId) {
                $categoryIds[] = $category->id;
            } elseif ($category->parent_id == $categoryId) {
                $this->getCategoryIds($categories, $category->id, $categoryIds);
            }
        }
        return $categoryIds;
    }
}

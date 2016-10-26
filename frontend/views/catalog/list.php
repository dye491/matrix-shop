<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Menu;

/* @var $this yii\web\View */
$title = $category === null ? 'Matrix - каталог товаров' : $category->title;
$this->title = Html::encode($title);
foreach ($breadcrumbs as $breadcrumb) {
    $this->params['breadcrumbs'][] = $breadcrumb;
}
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($title) ?></h1>

<div class="container-fluid">
  <div class="row">
      <div class="col-xs-4">
          <?= Menu::widget([
              'items' => $menuItems,
              'options' => [
                  'class' => 'menu',
              ],
          ]) ?>
      </div>
      <div class="col-xs-8">
          <?= ListView::widget([
              'dataProvider' => $productsDataProvider,
              'itemView' => '_product',
          ]) ?>
      </div>
  </div>
</div>
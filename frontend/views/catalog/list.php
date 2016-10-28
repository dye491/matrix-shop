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
                    'class' => 'nav',
                ],
//                'itemOptions' => [
//                  'class' => 'nav tree-toggle',
//                ],
                'submenuTemplate' => "\n<ul class=\"tree collapse\">\n{items}\n</ul>\n",
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
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
//    $(document).ready(function () {
        $('.tree-toggle').click(function () {
            $(this).parent().children('ul.tree').toggle();
        });
//        $('.tree-toggle').parent().children('ul.tree').toggle(1000);
//    }
</script>
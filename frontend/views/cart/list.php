<?php
use \yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $products common\models\Product[] */
?>
<h1>Ваша корзина</h1>

<?php if(empty($products)): ?>
<p>Ваша корзина пуста.</p>
<?php else: ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-4">

        </div>
        <div class="col-xs-2">
            Цена
        </div>
        <div class="col-xs-2">
            Количество
        </div>
        <div class="col-xs-2">
            Сумма
        </div>
        <div class="col-xs-2">

        </div>
    </div>
    <?php foreach ($products as $product):?>
    <div class="row">
        <div class="col-xs-4">
            <?= Html::encode($product->title) ?>
        </div>
        <div class="col-xs-2">
            <?= $product->price ?> р.
        </div>
        <div class="col-xs-2">
            <?= $quantity = $product->getQuantity()?>

            <?= Html::a('-', ['cart/update', 'id' => $product->getId(), 'quantity' => $quantity - 1], ['class' => 'btn btn-danger', 'disabled' => ($quantity - 1) < 1])?>
            <?= Html::a('+', ['cart/update', 'id' => $product->getId(), 'quantity' => $quantity + 1], ['class' => 'btn btn-success'])?>
        </div>
        <div class="col-xs-2">
            <?= $product->getCost() ?> р.
        </div>
        <div class="col-xs-2">
            <?= Html::a('×', ['cart/remove', 'id' => $product->getId()], ['class' => 'btn btn-danger'/*, 'style' => 'width: 100%'*/])?>
        </div>
    </div>
    <?php endforeach ?>
    <div class="row">
        <div class="col-xs-8">

        </div>
        <div class="col-xs-2">
            Итого: <?= $total ?> р.
        </div>
        <div class="col-xs-2">
            <?= Html::a('Оформить заказ', ['cart/order'], ['class' => 'btn btn-success'/*, 'style' => 'width: 100%'*/])?>
        </div>
    </div>
</div>
<?php endif; ?>
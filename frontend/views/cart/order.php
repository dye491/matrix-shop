<?php
use \yii\helpers\Html;
use \yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $products common\models\Product[] */
?>
<h1>Ваш заказ</h1>

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
        </div>
        <div class="col-xs-2">
            <?= $product->getCost() ?> р.
        </div>
    </div>
    <?php endforeach ?>
    <div class="row">
        <div class="col-xs-8">

        </div>
        <div class="col-xs-2">
            Итого: <?= $total ?> р.
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            /* @var $form ActiveForm */
            $form = ActiveForm::begin([
                'id' => 'order-form',
            ]) ?>

            <?= $form->field($order, 'name' ) ?>
            <?= $form->field($order, 'phone') ?>
            <?= $form->field($order, 'email') ?>
            <?= $form->field($order, 'address') ?>
            <?= $form->field($order, 'notes')->textarea() ?>

            <div class="form-group row">
                <div class="col-xs-12">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
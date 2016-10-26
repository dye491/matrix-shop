<?php
/* @var $order common\models\Order */
use yii\helpers\Html;
?>

<h1>Новый заказ №<?= $order->id ?></h1>

<h2>Заказчик:</h2>

<ul>
    <li>Имя:<?= Html::encode($order->name) ?></li>
    <li>Телефон: <?= Html::encode($order->phone) ?></li>
    <li>Email: <?= Html::encode($order->email) ?></li>
</ul>

<h2>Адрес доставки</h2>
<?= Html::encode($order->address) ?>

<h2>Примечания к заказу</h2>

<?= Html::encode($order->notes) ?>

<h2>Товары</h2>

<ul>
<?php
$sum = 0;
foreach ($order->orderItems as $item): ?>
    <?php $sum += $item->quantity * $item->price ?>
    <li><?= Html::encode($item->title . ' x ' . $item->quantity . ' x ' . $item->price . ' р.') ?></li>
<?php endforeach ?>
</ul>

<p><string>Итого: </string> <?php echo $sum?> р.</p>


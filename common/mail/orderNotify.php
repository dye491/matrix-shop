<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 10.08.2016
 * Time: 17:25
 */

/* @var $order common\models\Order
 * @var string $title
 * @var string $text
 */
use yii\helpers\Html;
use yii\helpers\Markdown;
?>

<h1><?= Html::encode($title) ?><?= $order->id ?></h1>

<p><?= Markdown::process($text) ?></p>

<h2>Информация по Вашему заказу</h2>

<ul>
    <li>Номер заказа: <?= Html::encode($order->id) ?></li>
    <li><strong>Статус: <?= Html::encode($order->getStatuses()[$order->status]) ?></strong></li>
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


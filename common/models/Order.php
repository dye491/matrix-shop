<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $email
 * @property string $notes
 * @property string $status
 *
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 'New';
    const STATUS_IN_PROGRESS = 'In progress';
    const STATUS_DONE = 'Done';

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'phone'], 'required'],
            [['notes'], 'string'],
            [['phone', 'email', 'name', 'address'], 'string', 'max' => 255],
            [['email'], 'email',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
            'name' => 'Ваше имя',
            'phone' => 'Телефон',
            'address' => 'Адрес доставки',
            'email' => 'Эл. почта',
            'notes' => 'Примечание к заказу',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->status = self::STATUS_NEW;
            }
            return true;
        } else {
            return false;
        }
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_DONE => 'Done',
            self::STATUS_IN_PROGRESS => 'In progress',
            self::STATUS_NEW => 'Новый',
        ];
    }

    public function sendEmail()
    {
        return Yii::$app->mailer->compose('order', ['order' => $this])
            ->setTo(Yii::$app->params['shopperEmail'])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject('Новый заказ №' . $this->id)
            ->send();
    }

    public function notify($subject, array $params)
    {
        return Yii::$app->mailer->compose('orderNotify', $params)
            ->setTo($this->email)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject($subject)
            ->send();
    }
}

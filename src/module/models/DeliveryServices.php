<?php

namespace uranum\delivery\module\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%deliveryServices}}".
 * @property integer $id
 * @property string  $name
 * @property string  $code
 * @property string  $info
 * @property string  $terms
 * @property string  $fixedCost
 * @property integer $isActive
 * @property integer $serviceShownFor
 * @property string  $dateDb
 * @property integer $created_at
 * @property mixed   $serviceShownValue
 * @property string  $isActiveText
 * @property integer $updated_at
 */
class DeliveryServices extends ActiveRecord
{
	const SHOWN_FOR_ALL        = 1;
	const SHOWN_LOCALLY        = 2;
	const SHOWN_EXCEPT_LOCALLY = 3;
	
	const SHOWN_FOR_ALL_TEXT            = 'показывать везде';
	const SHOWN_FOR_LOCALLY_TEXT        = 'только для своего города';
	const SHOWN_FOR_EXCEPT_LOCALLY_TEXT = 'показывать везде, кроме своего города';
	const YES                           = 'Да';
	const NOT                           = 'Нет';
	
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%deliveryServices}}';
	}
	
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name', 'code', 'serviceShownFor'], 'required'],
			[['isActive', 'fixedCost', 'serviceShownFor', 'created_at', 'updated_at'], 'integer'],
			[['name', 'code', 'terms', 'info'], 'string', 'max' => 100],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'              => 'ID',
			'name'            => 'Название',
			'code'            => 'Кодовое обозначение',
			'isActive'        => 'Активно',
			'fixedCost'       => 'Фиксированая стоимость',
			'info'            => 'Пояснения',
			'terms'           => 'Сроки доставки',
			'serviceShownFor' => 'Для какого пункта назначения показывать эту доставку',
		];
	}
	
	public function serviceShownForRadioList()
	{
		return [
			self::SHOWN_FOR_ALL        => self::SHOWN_FOR_ALL_TEXT,
			self::SHOWN_LOCALLY        => self::SHOWN_FOR_LOCALLY_TEXT,
			self::SHOWN_EXCEPT_LOCALLY => self::SHOWN_FOR_EXCEPT_LOCALLY_TEXT,
		];
	}
	
	public function getServiceShownValue()
	{
		return $this->serviceShownForRadioList()[ $this->serviceShownFor ];
	}
	
	public function getIsActiveText()
	{
		return $this->isActive ? self::YES : self::NOT;
	}
}

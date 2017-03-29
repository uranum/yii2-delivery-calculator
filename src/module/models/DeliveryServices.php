<?php

namespace uranum\delivery\module\models;

use uranum\delivery\module\Module;
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
	
	const SHOWN_FOR_ALL_TEXT            = 'show everywhere';
	const SHOWN_FOR_LOCALLY_TEXT        = 'show only for the city of departure';
	const SHOWN_FOR_EXCEPT_LOCALLY_TEXT = 'show everywhere except the city of departure';
	const YES                           = 'Yes';
	const NOT                           = 'No';
	
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
			[['name', 'code', 'terms', 'info', 'isActive', 'fixedCost', 'serviceShownFor', 'created_at', 'updated_at'], 'safe'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'              => 'ID',
			'name'            => Module::t('module', 'Name'),
			'code'            => Module::t('module', 'Code'),
			'isActive'        => Module::t('module', 'Is active'),
			'fixedCost'       => Module::t('module', 'Fixed cost'),
			'info'            => Module::t('module', 'Notes'),
			'terms'           => Module::t('module', 'Term of delivery'),
			'serviceShownFor' => Module::t('module', 'For what destination city this service is shown'),
			'created_at'      => Module::t('module', 'Created at'),
			'updated_at'      => Module::t('module', 'Updated at'),
		];
	}
	
	public function serviceShownForRadioList()
	{
		return [
			self::SHOWN_FOR_ALL        => Module::t('module', self::SHOWN_FOR_ALL_TEXT),
			self::SHOWN_LOCALLY        => Module::t('module', self::SHOWN_FOR_LOCALLY_TEXT),
			self::SHOWN_EXCEPT_LOCALLY => Module::t('module', self::SHOWN_FOR_EXCEPT_LOCALLY_TEXT),
		];
	}
	
	public function getServiceShownValue()
	{
		return $this->serviceShownForRadioList()[ $this->serviceShownFor ];
	}
	
	public function getIsActiveText()
	{
		return $this->isActive ? Module::t('module', self::YES) : Module::t('module', self::NOT);
	}
}

<?php

use yii\db\Migration;

class m170323_074600_TableDeliveries extends Migration
{
	private $tableName = '{{%delivery_services}}';
	
	private $indexPrefix = 'idx-profile-';
	
	public function up()
	{
		$tableOptions = null;
        $dateExpression = $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP()')->append('on update CURRENT_TIMESTAMP()');
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		} elseif ($this->db->driverName === 'pgsql') {
            $dateExpression = $this->dateTime()->defaultExpression('NOW()');
        }
		
		$this->createTable($this->tableName, [
			'id'              => $this->primaryKey(),
			'name'            => $this->string(100)->notNull()->comment('Название'),
			'code'            => $this->string(100)->notNull()->comment('Кодовое обозначение'),
			'isActive'        => $this->boolean()->notNull()->defaultValue(true)->comment('Активно'),
			'fixedCost'       => $this->integer()->comment('Фиксированная стоимость'),
			'info'            => $this->string()->comment('Пояснительная информация'),
			'terms'           => $this->string()->comment('Сроки доставки'),
			'serviceShownFor' => $this->integer(10)->notNull()->comment('Доставка показывается для (регионов, города отправки, везде)'),
			'dateDb'          => $dateExpression,
			'created_at'      => $this->integer()->notNull(),
			'updated_at'      => $this->integer()->notNull(),
		], $tableOptions);
		
		$this->createIndex($this->indexPrefix . 'name', $this->tableName, 'name');
		$this->createIndex($this->indexPrefix . 'code', $this->tableName, 'code');
		$this->createIndex($this->indexPrefix . 'created_at', $this->tableName, 'created_at');
		$this->createIndex($this->indexPrefix . 'updated_at', $this->tableName, 'updated_at');
	}
	
	public function down()
	{
		$this->dropTable($this->tableName);
	}
}

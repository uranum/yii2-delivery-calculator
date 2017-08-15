<?php

use yii\db\Migration;

class m170815_170201_AddOnChoiceDeliveryService extends Migration
{
    private $tableName = '{{%delivery_services}}';
    private $code = uranum\delivery\module\Module::DELIVERY_CODE;

    public function up()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->insert($this->tableName, [
            'name'            => 'Доставка на выбор',
            'code'            => $this->code['ON_CHOICE'],
            'isActive'        => 1,
            'fixedCost'       => NULL,
            'info'            => 'В примечании к заказу укажите предпочтительный способ доставки',
            'terms'           => null,
            'serviceShownFor' => 2,
            'dateDb'          => '',
            'created_at'      => time(),
            'updated_at'      => time(),
        ]);
    }

    public function down()
    {
        $this->delete($this->tableName, ['code' => $this->code['ON_CHOICE']]);
    }
}

<?php

use yii\db\Migration;
use uranum\delivery\module\Module;

class m170804_095504_InitialDeliveryServices extends Migration
{
    private $tableName = '{{%delivery_services}}';

    public function up()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->batchInsert($this->tableName, [
            'name',
            'code',
            'isActive',
            'fixedCost',
            'info',
            'terms',
            'serviceShownFor',
            'dateDb',
            'created_at',
            'updated_at',
        ], [
            [
                'Курьер',
                Module::DELIVERY_CODE['COURIER'],
                1,
                200,
                NULL,
                '1 день',
                2,
                '',
                time(),
                time(),
            ],
            [
                'Почта России',
                Module::DELIVERY_CODE['POST'],
                1,
                NULL,
                NULL,
                NULL,
                3,
                '',
                time(),
                time(),
            ],
            [
                'Почта России наложенным',
                Module::DELIVERY_CODE['NALOJ'],
                1,
                NULL,
                NULL,
                NULL,
                3,
                '',
                time(),
                time(),
            ],
            [
                'Самовывоз',
                Module::DELIVERY_CODE['PICKUP'],
                1,
                0,
                'Самостоятельно забираете в офисе.',
                NULL,
                1,
                '',
                time(),
                time(),
            ],
            [
                'СДЭК-склад',
                Module::DELIVERY_CODE['CDEK_STORE'],
                1,
                NULL,
                'Тариф "Доставка до склада" - Вам нужно будет забирать посылку в отделении СДЭК',
                NULL,
                3,
                '',
                time(),
                time(),
            ],
            [
                'СДЭК-дверь',
                Module::DELIVERY_CODE['CDEK_DOOR'],
                1,
                NULL,
                'Тариф "Доставка до двери" - Вам принесут посылку до указанного адреса',
                NULL,
                3,
                '',
                time(),
                time(),
            ],
            [
                'Энергия',
                Module::DELIVERY_CODE['ENERGY'],
                1,
                NULL,
                '',
                NULL,
                3,
                '',
                time(),
                time(),
            ]
        ]);
    }

    public function down()
    {
        $this->truncateTable($this->tableName);
    }
}

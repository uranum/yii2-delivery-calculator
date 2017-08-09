<?php

use yii\db\Migration;

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
                'courier',
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
                'post',
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
                'post_naloj',
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
                'pickup',
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
                'cdek-store',
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
                'cdek-door',
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
                'energy',
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

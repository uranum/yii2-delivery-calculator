<?php

use yii\db\Migration;

class m170804_095504_InitialDeliveryServices extends Migration
{
    private $tableName = '{{%delivery_services}}';
    private $code = uranum\delivery\module\Module::DELIVERY_CODE;

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
                $this->code['COURIER'],
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
                $this->code['POST'],
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
                $this->code['NALOJ'],
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
                $this->code['PICKUP'],
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
                $this->code['CDEK_STORE'],
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
                $this->code['CDEK_DOOR'],
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
                $this->code['ENERGY'],
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

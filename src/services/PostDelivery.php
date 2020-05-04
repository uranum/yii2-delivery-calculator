<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;


use uranum\delivery\services\calculators\PostCalc;

class PostDelivery extends YiiModuleDelivery
{
	public function calculate()
	{
		$calculator = new PostCalc(
			$this->getLocationTo(),
			$this->locationFrom,
			$this->weight,
			$this->cartCost,
			$this->moduleParams
		);
        \Yii::warning($this->getLocationTo());
		$result = $calculator->getResult();
		
		$this->id = $this->serviceParams->id;
		$this->name = $this->serviceParams->name;
		$this->handleResult($result);
	}
	
	protected function handleResult($result)
	{
		if ($result instanceof \stdClass) {
			$this->resultCost = $result->Отправления->ЦеннаяПосылка->Доставка;
			$this->terms      = $result->Отправления->ЦеннаяПосылка->СрокДоставки . ' дн.';
		} else {
			$this->info = $result;
		}
	}
	
	protected function getLocationTo()
	{
		return (empty($this->zip) || $this->isStubZip()) ? $this->locationTo : $this->zip;
	}

    /**
     * @return bool
     *
     * индексы, которых нет в базе часто передаются как 000001
     * их тоже отсекаем, чтобы искать по городу
     */
    protected function isStubZip(): bool
    {
        return strpos($this->zip, '0') === 0;
    }
}
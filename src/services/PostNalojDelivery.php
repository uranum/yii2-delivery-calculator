<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\services;


class PostNalojDelivery extends PostDelivery
{
	
	protected function handleResult($result)
	{
		if ($result instanceof \stdClass) {
			$parcel           = $result->Отправления->ЦеннаяПосылка;
			$tarif            = $parcel->Доставка;
			$naloj            = $parcel->НаложенныйПлатеж;
			$naloj            = ($parcel->НаложенныйПлатеж2 > 0) ? $parcel->НаложенныйПлатеж2 : $naloj;
			$naloj            = ($parcel->НаложенныйПлатеж3 > 0) ? $parcel->НаложенныйПлатеж3 : $naloj;
			$this->resultCost = $tarif + $naloj;
			$this->terms      = $parcel->СрокДоставки . ' дн.';
		} else {
			$this->info = $result;
		}
	}
}
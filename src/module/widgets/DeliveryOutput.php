<?php
/**
 * Created by PhpStorm.
 * User:    Евгений Емельянов <e9139905539@gmail.com>
 */

namespace uranum\delivery\module\widgets;


use uranum\delivery\module\Module;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * @property string $infoWrapper
 * @property string $headerWrapper
 * @property string $termsWrapper
 * @property mixed  $buttonWrapper
 * @property string $costWrapper
 */
class DeliveryOutput extends Widget
{
	/**
	 * Входные данные для отображения параметров доставки:
	 * ```php
	 * [
	 *      [name] => СДЭК-склад
	 *      [terms] => 1-3 дн.
	 *      [cost] => 175
	 *      [info] => Тариф "Доставка до склада"
	 * ]
	 * ```
	 * @var array
	 */
	public    $data              = [];
	public    $containerCssClass = 'small-12 columns';
	public    $buttonWrapperCssClass;
	public    $headerWrapperCssClass;
	public    $termsWrapperCssClass;
	public    $infoWrapperCssClass;
	public    $costWrapperCssClass;
	public    $headerCssClass;
	public    $buttonCssClass    = 'button success';
	public    $costCssClass;
	public    $termsCssClass;
	public    $infoCssClass;
	public    $costFormatFunc;
	public    $buttonName;
	public    $url;
	
	protected $cost;
	
	
	public function init()
	{
		parent::init();
		$this->setCost();
		$this->buttonName = Module::t('module', 'Choose');
	}

    public function run()
    {
        $this->renderContainer();
	}
	
	protected function renderContainer(): string
	{
		return Html::tag('div', $this->renderContent(), ['class' => $this->containerCssClass]);
	}
	
	/**
	 *
	 */
	protected function renderContent(): string
	{
		$HTML = '';
		$HTML .= Html::tag('h3', $this->getHeaderWrapper(), ['class' => $this->headerWrapperCssClass]);
		$HTML .= Html::tag('div', $this->getCostWrapper(), ['class' => $this->costWrapperCssClass]);
		$HTML .= Html::tag('div', $this->getTermsWrapper(), ['class' => $this->termsWrapperCssClass]);
		$HTML .= Html::tag('div', $this->getInfoWrapper(), ['class' => $this->infoWrapperCssClass]);
		$HTML .= Html::tag('div', $this->getButtonWrapper(), ['class' => $this->buttonWrapperCssClass]);
		
		return $HTML;
	}
	
	/**
	 * @return string
	 */
	protected function getHeaderWrapper(): string
	{
		return Html::tag('div', $this->data['name'], ['class' => $this->headerCssClass]);
	}
	
	/**
	 * @return string
	 */
	protected function getCostWrapper(): string
	{
		return Html::tag('div', $this->cost, ['class' => $this->costCssClass]);
	}
	
	/**
	 * @return string
	 */
	protected function getTermsWrapper(): string
	{
		return empty($this->data['terms']) ? '' : Html::tag('div', $this->data['terms'], ['class' => $this->termsCssClass]);
	}
	
	/**
	 * @return string
	 */
	protected function getInfoWrapper(): string
	{
		return empty($this->data['info']) ? '' : Html::tag('div', $this->data['info'], ['class' => $this->infoCssClass]);
	}
	
	protected function setCost()
	{
		if (is_callable($this->costFormatFunc)) {
			$this->cost = call_user_func($this->costFormatFunc, $this->data['cost']);
		} elseif (is_string($this->costFormatFunc) || is_numeric($this->costFormatFunc)) {
			$this->cost = $this->costFormatFunc;
		} else {
			$this->cost = $this->data['cost'];
		}
	}
	
	protected function getButtonWrapper()
	{
		return Html::a($this->buttonName, $this->url, ['class' => $this->buttonCssClass]);
	}
	
}
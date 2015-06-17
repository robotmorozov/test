<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

CBitrixComponent::includeComponentClass("project:base.component");

class BaseElementsListComponent extends BaseComponent
{
    protected $sort = array();
	protected $groupBy = false;

    public function onPrepareComponentParams($params)
    {
		$parentResult = parent::onPrepareComponentParams($params);
        $result = array(
			'PREVIEW_HEIGHT' => intval($params['PREVIEW_HEIGHT']),
			'PREVIEW_WIDTH' => intval($params['PREVIEW_WIDTH']),
            'COUNT' => intval($params['COUNT']),
            'SORT_FIELD1' => strlen($params['SORT_FIELD1']) ? $params['SORT_FIELD1'] : 'ID',
            'SORT_DIRECTION1' => $params['SORT_DIRECTION1'] == 'ASC' ? 'ASC' : 'DESC',
            'SORT_FIELD2' => strlen($params['SORT_FIELD2']) ? $params['SORT_FIELD2'] : 'ID',
            'SORT_DIRECTION2' => $params['SORT_DIRECTION2'] == 'ASC' ? 'ASC' : 'DESC',
        );
		if(!empty($params['ID']))
		{
			$result['ID'] = intval($params['ID']);
		}
		
		$result = array_merge($parentResult, $result);
        return $result;
    }

	/**
	 * выполяет действия перед кешированием
	 */
	protected function executeProlog()
	{
		if ($this -> arParams['COUNT'] > 0)
		{
			$this -> navParams = array(
				'nTopCount' => $this -> arParams['COUNT']
			);
		}
	}

    /**
     * Выборка элементов
     * @param array $settings
     * @return array
     */
    protected function getItems($settings = array())
{

		$rsItems = CIBlockElement::GetList($this->sort, $this->filter, $this->groupBy, $this->navParams, $this->select);
		
		$resultItems = array();
		$resultIBlock = array();
		
		while ($ob = $rsItems->GetNextElement())
		{
			$item = $ob->GetFields();
			$item['PROPERTIES'] = $ob->GetProperties();
			
			$resultItems[] = $this->prepareItem($item);
		}

		return $resultItems;
	}

    protected function prepareSort()
    {
        $this->sort = array(
            $this->arParams['SORT_FIELD1'] => $this->arParams['SORT_DIRECTION1'],
            $this->arParams['SORT_FIELD2'] => $this->arParams['SORT_DIRECTION2'],
        );
    }

	protected function prepareFilter()
	{
		parent::prepareFilter();

		if ($this->arParams['SECTION_ID'] > 0)
			$this->filter['SECTION_ID'] = $this->arParams['SECTION_ID'];
	}

	protected function getResult($settings = array())
	{
		$this->arResult['ITEMS'] = $this->getItems($settings);
	}
}
?>
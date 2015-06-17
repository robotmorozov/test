<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

CBitrixComponent::includeComponentClass("project:base.elements.list");

class ElementListComponent extends \BaseElementsListComponent
{

    public function onPrepareComponentParams($params)
    {
        $prepared = parent::onPrepareComponentParams($params);
		$prepared['TYPE'] = trim($params['TYPE']);
		
		
        return $prepared;
    }
	
    protected function prepareItem($fields)
    {	
		if($this -> arParams['TYPE'] == 'BANNER'){
			
			$item = array(
				'ID' => $fields['ID'],
				'BANNER' => $this -> preparePicture($fields['PREVIEW_PICTURE'], $this -> arParams['PREVIEW_WIDTH'], $this -> arParams['PREVIEW_HEIGHT']), 		
			);
			
		}elseif($this -> arParams['TYPE'] == 'SLIDER'){
			$item = array(
				'ID' => $fields['ID'],		
			);
			
			foreach($fields['PROPERTIES']['SLIDER']['VALUE'] as $value){
			
				$item['SLIDER'][] = $this -> preparePicture($value, $this -> arParams['PREVIEW_WIDTH'], $this -> arParams['PREVIEW_HEIGHT']);
			}
			
		}elseif($this -> arParams['TYPE'] == 'HTML'){
			$item = array(
				'ID' => $fields['ID'],
				'VALUE' => $fields['~PREVIEW_TEXT']		
			);
		}elseif($this -> arParams['TYPE'] == 'PHP'){
			$item = array(
				'ID' => $fields['ID'],
				'VALUE' => $fields['~DETAIL_TEXT']		
			);
		}
        
		return $item;
    }

}
?>
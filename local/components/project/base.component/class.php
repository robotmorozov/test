<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

class BaseComponent extends \CBitrixComponent
{
	protected $modules = array('iblock');
	protected $filter = array();

	/**
	 * кешируемые ключи arResult
	 * @var array()
	 */
	protected $cacheKeys = array();
	
	/**
	 * дополнительные параметры, от которых должен зависеть кеш
	 * @var array
	 */
	protected $cacheAddon = array();
	
	/**
	 * парамтеры постраничной навигации
	 * @var array
	 */
	protected $navParams = false;

	/**
	 * подключает языковые файлы
	 */
	public function onIncludeComponentLang()
	{
		$this -> includeComponentLang(basename(__FILE__));
		Loc::loadMessages(__FILE__);
	}
	
    /**
     * подготавливает входные параметры
     * @param array $arParams
     * @return array
     */
    public function onPrepareComponentParams($params)
    {
        $result = array(
            'IBLOCK_TYPE' => trim($params['IBLOCK_TYPE']),
            'IBLOCK_ID' => intval($params['IBLOCK_ID']),
            'PREVIEW_PICTURE' => trim($params['PREVIEW_PICTURE']),
            'CACHE_TYPE' => (empty($params['CACHE_TYPE'])) ? 'A' : trim($params['CACHE_TYPE']),
            'CACHE_TIME' => intval($params['CACHE_TIME']) > 0 ? intval($params['CACHE_TIME']) : 3600
        );

        return $result;
    }
	
	/**
	 * определяет читать данные из кеша или нет
	 * @return bool
	 */
	protected function readDataFromCache()
	{
		if ($this -> arParams['CACHE_TYPE'] == 'N')
			return false;

		return !($this -> StartResultCache(false, $this -> cacheAddon));
	}

	/**
	 * кеширует ключи массива arResult
	 */
	protected function putDataToCache()
	{
		if (is_array($this -> cacheKeys) && sizeof($this -> cacheKeys) > 0)
		{
			$this -> SetResultCacheKeys($this -> cacheKeys);
		}
	}

	/**
	 * прерывает кеширование
	 */
	protected function abortDataCache()
	{
		$this -> AbortResultCache();
	}
	
	/**
	 * проверяет подключение необходиимых модулей
	 * @throws LoaderException
	 */
	protected function checkModules()
	{
	    foreach ($this->modules as $module)
	    {
			if(!Main\Loader::includeModule($module))
			{
				throw new Main\LoaderException(Loc::getMessage("BASE_MODULE_NOT_INSTALLED", array("#MODULE#" => $module)));
			}
	    }
	}
	
	/**
	 * проверяет заполнение обязательных параметров
	 * @throws SystemException
	 */
	protected function checkParams()
	{
		if ($this -> arParams['IBLOCK_ID'] <= 0)
			throw new Main\ArgumentNullException('IBLOCK_ID');
	}

	protected function prepareFilter()
	{	
						
		if (!empty($this->arParams['IBLOCK_TYPE']))
			$this->filter['IBLOCK_TYPE'] = $this->arParams['IBLOCK_TYPE'];
		
		if (!empty($this->arParams['IBLOCK_ID']))
			$this->filter['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];

		if (!empty($this->arParams['ID']))
			$this->filter['ID'] = $this->arParams['ID'];
		elseif (!empty($this->arParams['CODE']))
			$this->filter['CODE'] = $this->arParams['CODE'];

        if ($this->arParams['PREVIEW_PICTURE'] == 'Y')
            $this->filter['>PREVIEW_PICTURE'] = 0;

        $this->filter['ACTIVE'] = 'Y';
	}

	protected function prepareNavigation()
	{
	
	}
	
	/**
	 * Подготовка полей элемента ИБ
	 */
	protected function prepareItem($item)
	{
	}
	
	/**
	 * получение результатов
	 */
	protected function getResult()
	{
	}
	
	/**
	 * выполяет действия перед кешированием 
	 */
	protected function executeProlog()
	{
	}
	
	/**
	* Prepares picture or resize
	* @return array
	*/
	public function preparePicture($id, $width = false, $height = false, $type = BX_RESIZE_IMAGE_EXACT)
  	{
    	if($id)
    	{
	      	if($width && $height)
		        $picture = CFile::ResizeImageGet($id, array("width" => $width, "height" => $height), $type, true);
	      	else
	        	$picture = CFile::GetFileArray($id);
			if(isset($picture['src']))
				$picture['SRC'] = $picture['src'];

			return $picture;
    	}
    	else
    	{
      		return false;
    	}
  	}
	
    protected function prepareSort()
    {
	
    }
	
	/**
	 * выполняет логику работы компонента
	 */
	public function executeComponent()
	{
		global $APPLICATION;

		try
		{
			$this -> checkModules();
			$this -> checkParams();

			$this->prepareSort();
			$this->prepareFilter();
			$this->prepareNavigation();
			$this -> executeProlog();
				
			if (!$this -> readDataFromCache())
			{
				$this -> getResult();
				$this -> putDataToCache();
				$this->includeComponentTemplate();
			}
		}
		catch (Exception $e)
		{
			$this -> abortDataCache();
			ShowError($e -> getMessage());
		}
	}
}
?>
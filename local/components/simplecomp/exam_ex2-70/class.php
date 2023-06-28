<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


class SimpleComp_70 extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['IBLOCK_CATALOG_ID'] = (int) $arParams['IBLOCK_CATALOG_ID'];
        $arParams['IBLOCK_NEWS_ID'] = (int) $arParams['IBLOCK_NEWS_ID'];
        if(!$arParams['CACHE_TIME']) $arParams['CACHE_TIME'] = 36000;

        return $arParams;
    }

    private function setResult()
    {
        //sections
        $sections = [];
        $arFilter = ['IBLOCK_ID' => $this->arParams['IBLOCK_CATALOG_ID'], '!PROPERTY_'.$this->arParams['USER_PROPERTY'] => false, 'ACTIVE' => 'Y'];
        $arSelect = ['IBLOCK_ID', 'ID', 'NAME', $this->arParams['USER_PROPERTY']];
        $r = CIBlockSection::getList(false, $arFilter, false, $arSelect);
        while($res = $r->Fetch()){
            $sections[$res['ID']] = $res;
        }

        //items
        $sectionsId = array_keys($sections);
        $cnt = 0;
        $prices = [];
        if($_REQUEST['F']){
            $arFilter = [
                'IBLOCK_ID' => $this->arParams['IBLOCK_CATALOG_ID'],
                'IBLOCK_SECTION_ID' => $sectionsId, 'ACTIVE' => 'Y',
                [
                    'LOGIC' => 'OR',
                    ['>=PROPERTY_PRICE' => 1700, '=PROPERTY_MATERIAL' => 'Дерево, ткань'],
                    ['<PROPERTY_PRICE' => 1500, '=PROPERTY_MATERIAL' => 'Металл, пластик'],
                ]
            ];
        }else{
            $arFilter = [
                'IBLOCK_ID' => $this->arParams['IBLOCK_CATALOG_ID'],
                'IBLOCK_SECTION_ID' => $sectionsId, 'ACTIVE' => 'Y'
            ];
        }
        $arSelect = ['IBLOCK_ID', 'ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_PRICE', 'PROPERTY_ARTNUMBER', 'PROPERTY_MATERIAL'];
        $r = CIBlockElement::getList(false, $arFilter, false, false, $arSelect);
        while($res = $r->Fetch()){
            if($sections[$res['IBLOCK_SECTION_ID']]){

                $arButtons = CIBlock::GetPanelButtons(
                    $this->arParams['IBLOCK_SECTION_ID'],
                    $res['ID'],
                    0,
                    array("SECTION_BUTTONS"=>false, "SESSID"=>false)
                );
                $res["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
                $res["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

                $prices[] = $res['PROPERTY_PRICE_VALUE'];
                $sections[$res['IBLOCK_SECTION_ID']]['PRODS'][$res['ID']] = $res;
            }
            $cnt++;
        }
        $this->arResult['COUNT'] = $cnt;
        $this->arResult['MIN_PRICE'] = min($prices);
        $this->arResult['MAX_PRICE'] = max($prices);

        //news
        $news = [];
        $arFilter = ['IBLOCK_ID' => $this->arParams['IBLOCK_NEWS_ID'], 'ACTIVE' => 'Y'];
        $arSelect = ['IBLOCK_ID', 'ID', 'NAME', 'DATE_ACTIVE_FROM'];
        $r = CIBlockElement::getList(false, $arFilter, false, false, $arSelect);
        while($res = $r->Fetch()){
            $news[$res['ID']] = $res;
        }
        foreach($sections as $idSection => $arSection){

            foreach($arSection[$this->arParams['USER_PROPERTY']] as $idNew){

                if($news[$idNew]){
                    $news[$idNew]['SECTIONS'][$arSection['ID']] = $arSection['NAME'];

                    foreach($arSection['PRODS'] as $product){

                        $news[$idNew]['PRODS'][$product['ID']] = $product;
                    }
                }
            }
        }

        foreach($news as $new){
            if($new['SECTIONS']){
                $this->arResult['ITEMS'][] = $new;
            }
        }
    }

    public function executeComponent()
    {
        if(!Bitrix\Main\Loader::includeModule('iblock')) return;
        global $APPLICATION;

        if($this->startResultCache(false, $_REQUEST['F'])){
            $this->setResult();
            $this->setResultCacheKeys([
                "COUNT",
                "MIN_PRICE",
                "MAX_PRICE"
            ]);

            if($_REQUEST['F']) $this->AbortResultCache();

            $this->includeComponentTemplate();
        }

        $arButtons = CIBlock::GetPanelButtons(
            $this->arParams['IBLOCK_CATALOG_ID'],
            0,
            false,
            array("SECTION_BUTTONS"=>false)
        );
        if($APPLICATION->GetShowIncludeAreas()) $this->addIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));

        $APPLICATION->setTitle(GetMessage('COUNT_PRODS', ['#COUNT#' => $this->arResult['COUNT']]));
    }
}
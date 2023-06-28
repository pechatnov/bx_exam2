<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


class SimpleComp_97 extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['IBLOCK_NEWS_ID'] = (int) $arParams['IBLOCK_NEWS_ID'];
        $arParams['AUTHOR_PROP_CODE'] = (string) $arParams['AUTHOR_PROP_CODE'];
        $arParams['USER_TYPE_PROP_CODE'] = (string) $arParams['USER_TYPE_PROP_CODE'];

        return $arParams;
    }

    private function setResult()
    {
        //itemsList usersId
        $usersId = [];
        $itemsList = [];
        $filter = ['IBLOCK_ID' => $this->arParams['IBLOCK_NEWS_ID'], '!PROPERTY_'.$this->arParams['AUTHOR_PROP_CODE'] => false];
        $select = ['ID', 'NAME', 'DATE_ACTIVE_FROM', 'PROPERTY_'.$this->arParams['AUTHOR_PROP_CODE']];
        $ob = CIBlockElement::getList(false, $filter, false, false, $select);
        while($res = $ob->Fetch()){

            $itemsList[] = $res;

            foreach($res['PROPERTY_AUTHOR_VALUE'] as $val){

                $usersId[$val] = $val;
            }
        }

        //users
        global $USER;
        $curUserId = $USER->GetID();
        $curUserType = false;
        $usersTemp = [];
        $filter = ['ID' => implode(' | ', $usersId)];
        $params['SELECT'] = ['UF_AUTHOR_TYPE'];
        $ob = CUser::getList($by = "ID", $order = "asc", $filter, $params);
        while($res = $ob->Fetch()){

            if($res['ID'] != $curUserId){
                $usersTemp[$res['ID']]['ID'] = $res['ID'];
                $usersTemp[$res['ID']]['LOGIN'] = $res['LOGIN'];
                $usersTemp[$res['ID']]['UF_AUTHOR_TYPE'] = $res['UF_AUTHOR_TYPE'];
            }else{
                $curUserType = $res['UF_AUTHOR_TYPE'];
            }
        }
        $users =[];
        foreach($usersTemp as $key => $user){

            if($user['UF_AUTHOR_TYPE'] == $curUserType){
                $users[$key] = $user;
            }
        }

        //items
        $itemsOnly = [];
        foreach($itemsList as $res){

            foreach($res['PROPERTY_AUTHOR_VALUE'] as $val){

                if($users[$val] && !in_array($curUserId, $res['PROPERTY_AUTHOR_VALUE'])){

                    $users[$val]['NEWS'][] = $res;
                    $itemsOnly[$res['ID']] = $res['NAME'];
                }
            }
        }

        $this->arResult['COUNT'] = count($itemsOnly);
        $this->arResult['ITEMS'] = array_values($users);
    }

    public function executeComponent()
    {
        if(!Bitrix\Main\Loader::includeModule('iblock')) return;

        global $USER;
        if($USER->IsAuthorized()){

            if($this->startResultCache(false, $USER->GetID())){
                $this->setResult();
                $this->setResultCacheKeys(['COUNT']);
                $this->includeComponentTemplate();
            }

            global $APPLICATION;
            $APPLICATION->setTitle(GetMessage('COUNT', ['#COUNT#' => $this->arResult['COUNT']]));

        }else{
            echo GetMessage('ERROR_AUTH');
        }
    }
}
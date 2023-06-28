<?
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("EventHandler", "OnBeforeIBlockElementUpdateHandler"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("EventHandler", "OnAfterIBlockElementUpdateHandler"));
AddEventHandler("main", "OnBeforeEventAdd", array("EventHandler", "OnBeforeEventAddHandler"));
AddEventHandler("main", "OnBuildGlobalMenu", array("EventHandler", "OnBuildGlobalMenuHandler"));
AddEventHandler("main", "OnBeforeProlog", array("EventHandler", "OnBeforePrologHandler"));

class EventHandler
{
    function OnBeforePrologHandler()
    {
        Bitrix\Main\Loader::includeModule('iblock');

        global $APPLICATION;
        $curPage = $APPLICATION->GetCurPage();

        $arFilter = ['IBLOCK_ID' => IBLOCK_META, 'NAME' => $curPage];
        $arSelect = ['PROPERTY_TITLE', 'PROPERTY_DESCR'];
        $r = CIBlockElement::GetList(false, $arFilter, false, false, $arSelect);
        $res = $r->Fetch();

        if($res){
            $APPLICATION->SetPageProperty('title', $res['PROPERTY_TITLE_VALUE']);
            $APPLICATION->SetPageProperty('description', $res['PROPERTY_DESCR_VALUE']);
        }
    }

    function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        if($arFields['IBLOCK_ID'] == IBLOCK_PROD && $arFields['ACTIVE'] != 'Y'){

            $r = CIBlockElement::GetList(false, ['IBLOCK_ID' => IBLOCK_PROD, 'ID' => $arFields['ID']], false, false, ['SHOW_COUNTER']);
            $res = $r->Fetch();

            if($res['SHOW_COUNTER'] > 2){
                global $APPLICATION;
                $APPLICATION->throwException(Loc::getMessage('SHOW_COUNTER_ERROR', ['#COUNT#' => $res['SHOW_COUNTER']]));
                return false;
            }
        }
    }

    function OnAfterIBlockElementUpdateHandler(&$arFields)
    {
        if($arFields['IBLOCK_ID'] == IBLOCK_SERV){

            //CBitrixComponent::clearComponentCache('simplecomp:exam_ex2-71');
            global $CACHE_MANAGER;
            $CACHE_MANAGER->ClearByTag("SimpleComp_71");
        }
    }

    function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
    {
        if($event == 'FEEDBACK_FORM'){

            global $USER;
            if($USER->isAuthorized()){
                $arFields['AUTHOR'] = Loc::getMessage(
                    'FEEDBACK_FORM_AUTHORIZE', [
                    '#USER_ID#' => $USER->GetID(),
                    '#USER_LOGIN#' => $USER->GetLogin(),
                    '#USER_NAME#' => $USER->GetFullName(),
                    '#AUTHOR#' => $arFields['AUTHOR']
                ]);
            }
            else{
                $arFields['AUTHOR'] = Loc::getMessage('FEEDBACK_FORM_AUTHORIZE_NO', ['#AUTHOR#' => $arFields['AUTHOR']]);
            }

            CEventLog::Add([
                "SEVERITY" => "SECURITY",
                "AUDIT_TYPE_ID" => Loc::getMessage('FEEDBACK_FORM_CHANGE_TITLE'),
                "MODULE_ID" => "main",
                "DESCRIPTION" => Loc::getMessage('FEEDBACK_FORM_CHANGE', ['#AUTHOR#' => $arFields['AUTHOR']])
            ]);
        }
    }

    function OnBuildGlobalMenuHandler(&$aGlobalMenu, &$aModuleMenu){

        global $USER;
        if(in_array("5", $USER->GetUserGroupArray()) && !in_array("1", $USER->GetUserGroupArray())){
            unset($aGlobalMenu['global_menu_desktop']);
            foreach($aModuleMenu as $k => $v){
                if(
                    $v['parent_menu'] == 'global_menu_settings'
                    || $v['parent_menu'] == 'global_menu_services'
                    || $v['parent_menu'] == 'global_menu_marketplace'
                    || $v['items_id'] == 'menu_iblock'
                ){
                    unset($aModuleMenu[$k]);
                }
            }
        }
    }
}
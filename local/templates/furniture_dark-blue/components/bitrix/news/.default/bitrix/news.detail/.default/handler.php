<?
require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/prolog_before.php');


$oElement = new CIBlockElement();
if($res = $oElement->Add($_POST['DATA'])){
    echo 'Ваше мнение учтено, №'.$res;
}else{
    echo 'Ошибка!'.$oElement->LAST_ERROR;
}


require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/epilog_after.php');
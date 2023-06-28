<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CJSCore::Init(array("jquery"));


function getData($id){
    global $USER;
    $userData = false;

    if($USER->isAuthorized()){

        $userData[] = $USER->GetID();
        $userData[] = $USER->GetLogin();
        $userData[] = $USER->GetFullName();
        $userData = implode(', ', $userData);
    }else{
        $userData = "Не авторизован";
    }

    $prop['USER'] = $userData;
    $prop['NEW'] = $id;
    $arFields = [
        "ACTIVE" => "Y",
        "IBLOCK_ID" => IBLOCK_NOTES,
        "NAME" => "NAME",
        "DATE_ACTIVE_FROM" => date('d.m.Y H:i:s'),
        "PROPERTY_VALUES" => $prop
    ];

    return $arFields;
}



if($arParams['AJAX_COLLECT_NOTES'] == 'Y'){

    $arFields = getData($arResult['ID']);
    ?>
    <script>
        $('#ajax_collect_notes').on('click', function(){

            $.ajax({
                type: "POST",
                url: "<?=$templateFolder?>/handler.php",
                data: ({
                    "DATA": <?=json_encode($arFields, JSON_UNESCAPED_UNICODE)?>,
                }),
                success: function(res){
                    $('#answer_note').text(res);
                    console.log(res);
                }
            });

            return false;
        });
    </script>
    <?
}else{
    if($_GET['noteNew']){
        $arFields = getData($arResult['ID']);

        $oElement = new CIBlockElement();
        $oElement->Add($arFields);
    }
}
//print_arr($arFields);
if($arParams['CANONICAL']){
    $APPLICATION->SetPageProperty("Canonical", $arResult['CANONICAL']['NAME']);
}
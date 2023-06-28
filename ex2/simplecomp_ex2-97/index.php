<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент (ex2-97)");
?><?$APPLICATION->IncludeComponent(
	"simplecomp:exam_ex2-97", 
	".default", 
	array(
		"AUTHOR_PROP_CODE" => "AUTHOR",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000",
		"CACHE_TYPE" => "A",
		"IBLOCK_NEWS_ID" => "1",
		"USER_TYPE_PROP_CODE" => "UF_AUTHOR_TYPE",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
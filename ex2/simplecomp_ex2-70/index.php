<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент (ex2-70)");
?><?$APPLICATION->IncludeComponent(
	"simplecomp:exam_ex2-70", 
	".default", 
	array(
		"CACHE_TIME" => "36000",
		"CACHE_TYPE" => "A",
		"IBLOCK_CATALOG_ID" => "2",
		"IBLOCK_NEWS_ID" => "1",
		"USER_PROPERTY" => "UF_NEWS_LINK",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
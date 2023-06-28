<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент (ex2-71)");
?><?$APPLICATION->IncludeComponent(
	"simplecomp:exam_ex2-71", 
	".default", 
	array(
		"CACHE_TIME" => "36000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_CATALOG_ID" => "2",
		"IBLOCK_SIZER_ID" => "7",
		"USER_PROP" => "FIRM",
		"DETAIL_URL" => "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#",
		"ELEMENTS_COUNT" => "2"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
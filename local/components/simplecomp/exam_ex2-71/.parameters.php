<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"IBLOCK_CATALOG_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_CATALOG_ID"),
		),
		"IBLOCK_SIZER_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_SIZER_ID"),
		),
		"DETAIL_URL" => CIBlockParameters::GetPathTemplateParam(
			"DETAIL",
			"DETAIL_URL",
			GetMessage("DETAIL_URL"),
			"",
			"URL_TEMPLATES"
		),
		"USER_PROP" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("USER_PROP"),
		),
		"ELEMENTS_COUNT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ELEMENTS_COUNT")
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000),
	),
);
?>

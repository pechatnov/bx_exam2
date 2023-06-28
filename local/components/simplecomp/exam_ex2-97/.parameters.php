<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"IBLOCK_NEWS_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_NEWS_ID")
		),
		"AUTHOR_PROP_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("AUTHOR_PROP_CODE")
		),
		"USER_TYPE_PROP_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("USER_TYPE_PROP_CODE")
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000),
	),
);
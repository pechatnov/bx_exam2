<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<select id="site_select">
	<?foreach ($arResult["SITES"] as $key => $arSite):?>

		<option <?if ($arSite["CURRENT"] == "Y"){?>selected<?}?> value="<?=$arSite["DIR"]?>"><?=$arSite["LANG"]?></option>

	<?endforeach;?>
</select>




<?/*foreach ($arResult["SITES"] as $key => $arSite):*/?><!--

	<?/*if ($arSite["CURRENT"] == "Y"):*/?>
		<span title="<?/*=$arSite["NAME"]*/?>"><?/*=$arSite["NAME"]*/?></span>&nbsp;
	<?/*else:*/?>
		<a href="<?/*if(is_array($arSite['DOMAINS']) && strlen($arSite['DOMAINS'][0]) > 0 || strlen($arSite['DOMAINS']) > 0):*/?>http://<?/*endif*/?><?/*=(is_array($arSite["DOMAINS"]) ? $arSite["DOMAINS"][0] : $arSite["DOMAINS"])*/?><?/*=$arSite["DIR"]*/?>" title="<?/*=$arSite["NAME"]*/?>"><?/*=$arSite["NAME"]*/?></a>&nbsp;
	<?/*endif*/?>

--><?/*endforeach;*/?>
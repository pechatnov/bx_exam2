<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<div class="news-list">

	<?foreach($arResult["ITEMS"] as $arItem):?>

		<p class="news-item">

			<span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
			<b><?echo $arItem["PROPERTIES"]['NAME_EN']['VALUE']?></b>
			<?echo $arItem["PROPERTIES"]['PREV_EN']['VALUE']['TEXT'];?>
		</p>

	<?endforeach;?>
</div>
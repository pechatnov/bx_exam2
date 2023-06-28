<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CJSCore::Init(array("jquery"));
?>


<script>
    $('#site_select').on('change', function(){

        document.location.href = $('#site_select').val();
    });
</script>

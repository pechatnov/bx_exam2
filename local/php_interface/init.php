<?
function print_arr($arr){
    echo '<div style="overflow-y: scroll; height: 650px;">';
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    echo '</div>';
}

if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/constants.php'))
    require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/constants.php');

if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/events.php'))
    require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/events.php');

if(file_exists($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/agent.php'))
    require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/agent.php');
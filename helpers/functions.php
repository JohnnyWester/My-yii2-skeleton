<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\ArrayHelper;

/**
 * Print array
 * @param $arr : array
 */
function debug($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

function vd($arr)
{
    var_dump($arr);
}


/**
 * Получить строку заданной длины
 * @param string $str
 * @param int $len
 * @return string
 */
function cutStr($str, $len = 140){

    if (strlen($str) >= $len) {
        return substr($str, 0, strpos($str, ' ', $len)).'...';
    }
    return $str;
}


function url($url = '', $scheme = false)
{
    return Url::to($url, $scheme);
}


function h($text)
{
    return Html::encode($text);
}


function ph($text)
{
    return HtmlPurifier::process($text);
}


function t($message, $category = 'app', $params = [], $language = null)
{
    return Yii::t($category, $message, $params, $language);
}


function param($name, $default = null)
{
    return ArrayHelper::getValue(Yii::$app->params, $name, $default);
}


function dayTimeFromTimeStamp($timestamp)
{
    echo date('d.m.Y H:i:s', $timestamp);
}

/**
 * IP клиента
 * @return mixed
 */
function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


function trimArray($arr) {
    foreach ($arr as &$item) {
        $item = trim($item);
    }
    return $arr;
}


function execCommandSendPush($senderName, $uid, $settingId, $eventId) {
    $cmd = 'php ' . \Yii::$app->basePath . DIRECTORY_SEPARATOR . 'yii push ' . $senderName . ' '. $uid . ' ' . $settingId . ' ' . $eventId;

    if (substr(php_uname(), 0, 7) == "Windows") {
        pclose(popen("start /B " . $cmd, "r"));
    }
    else {
        exec($cmd . " > /dev/null &");
    }
}//execCommandSendPush


######################################################################
function xprint( $param, $title = 'Отладочная информация' )
{
    ini_set( 'xdebug.var_display_max_depth', 50 );
    ini_set( 'xdebug.var_display_max_children', 25600 );
    ini_set( 'xdebug.var_display_max_data', 9999999999 );
    if ( PHP_SAPI == 'cli' )
    {
        echo "\n---------------[ $title ]---------------\n";
        echo print_r( $param, true );
        echo "\n-------------------------------------------\n";
    }
    else
    {
        ?>
        <style>
            .xprint-wrapper {
                padding: 10px;
                margin-bottom: 25px;
                color: black;
                background: #f6f6f6;
                position: relative;
                top: 18px;
                border: 1px solid gray;
                font-size: 11px;
                font-family: InputMono, Monospace;
                width: 80%;
            }
            .xprint-title {
                padding-top: 1px;
                color: #000;
                background: #ddd;
                position: relative;
                top: -18px;
                width: 170px;
                height: 15px;
                text-align: center;
                border: 1px solid gray;
                font-family: InputMono, Monospace;
            }
        </style>
        <div class="xprint-wrapper">
        <div class="xprint-title"><?= $title ?></div>
        <pre style="color:#000;"><?= htmlspecialchars( print_r( $param, true ) ) ?></pre>
        </div><?php
    }
}
function xd( $val, $title = null )
{
    xprint( $val, $title );
    //die();
}
######################################################################
function round_up($number, $precision = 2)
{
    $fig = (int) str_pad('1', $precision, '0');
    return (ceil($number * $fig) / $fig);
}

function round_down($number, $precision = 2)
{
    $fig = (int) str_pad('1', $precision, '0');
    return (floor($number * $fig) / $fig);
}
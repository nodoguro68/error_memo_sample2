<?php

$debug_flg = true;

/**
 * デバッグ
 * 
 */
function debug($str, $debug_flg)
{
    if (!empty($debug_flg)) {
        error_log('デバッグ：' . $str);
    }
}
<?php

$debug_flg = true;

/**
 * デバッグ
 * 
 * @param string $str
 * @param bool $debug_flg
 */
function debug($str, $debug_flg)
{
    if (!empty($debug_flg)) {
        error_log('デバッグ：' . $str);
    }
}
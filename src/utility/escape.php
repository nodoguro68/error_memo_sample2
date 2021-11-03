<?php 

/**
 * エスケープ処理
 * 
 * @param string $str
 * @return string
 */
function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

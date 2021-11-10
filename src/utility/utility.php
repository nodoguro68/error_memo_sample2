<?php 

require_once 'log_config.php';
require_once 'debug.php';
require_once 'escape.php';
require_once 'dbConnect.php';
require_once 'db.php';
require_once 'session.php';
require_once 'message.php';
require_once 'validation.php';

/**
 * エラーメッセージ表示
 * 
 * @param array $err_msg
 * @param string $key
 * @return array
 */
function getErrMsg(&$err_msg, $key)
{
    if (!empty($err_msg[$key])) {
        return $err_msg[$key];
    }
}

/**
 * フォームの入力保持
 * 
 * @param string $key
 * @param array $dbFormData
 * @param bool $flag
 */
function getFormData($str, $dbFormData = null, $flag = false)
{
    if ($flag) {
        $method = $_GET;
    } else {
        $method = $_POST;
    }
    if (!empty($dbFormData)) {
        if (!empty($err_msg[$str])) {
            if (isset($method[$str])) {
                return escape($method[$str]);
            } else {
                return escape($dbFormData[$str]);
            }
        } else {
            if (isset($method[$str]) && $method[$str] !== $dbFormData[$str]) {
                return escape($method[$str]);
            } else {
                return escape($dbFormData[$str]);
            }
        }
    } else {
        if (isset($method[$str])) {
            return escape($method[$str]);
        }
    }
}

/**
 * 文字列切り出し
 * @param string $str
 * @param int $start
 * @param int $length
 */
function formatStr($str, $start, $length) {
    return $formatedStr = mb_substr($str, $start, $length);
}
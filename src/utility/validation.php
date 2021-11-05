<?php

require_once 'message.php';

/**
 * 必須入力チェック
 * 
 * @param array $err_msg
 * @param string $str
 * @param string $key
 */
function validRequired(&$err_msg, $str, $key)
{
    if (empty(trim($str))) {
        $err_msg[$key] = ERR_MSG_REQUIER;
    }
}
/**
 * 最大文字数チェック
 * 
 * @param array $err_msg
 * @param string $str
 * @param string $key
 * @param int $max
 */
function validMaxLen(&$err_msg, $str, $key, $max = 256)
{
    if (mb_strlen($str) > $max) {
        $err_msg[$key] = $max . ERR_MSG_MAX_LEN;
    }
}
/**
 * 最小文字数チェック
 * 
 * @param array $err_msg
 * @param string $str
 * @param string $key
 * @param int $min
 */
function validMinLen(&$err_msg, $str, $key, $min = 8)
{
    if (mb_strlen($str) < $min) {
        $err_msg[$key] = $min . ERR_MSG_MIN_LEN;
    }
}
/**
 * 半角英数字チェック
 * 
 * @param array $err_msg
 * @param string $str
 * @param string $key
 */
function validHalf(&$err_msg, $str, $key)
{
    if (!preg_match("/^[a-zA-Z0-9]+$/", $str)) {
        $err_msg[$key] = ERR_MSG_HALF;
    }
}
/**
 * メールアドレス形式チェック
 * 
 * @param array $err_msg
 * @param string $mail
 */
function validMail(&$err_msg, $mail)
{
    if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)) {
        $err_msg['mail_address'] = ERR_MSG_MAIL;
    }
}
/**
 * メールアドレス重複チェック
 * 
 * @param array $err_msg
 * @param string $mail
 */
function validMailDup(&$err_msg, $mail_address)
{

    $dbh = dbConnect();
    $sql = 'SELECT count(*) FROM users WHERE mail_address = :mail_address AND is_deleted = 0';
    $data = array(':mail_address' => $mail_address);

    $result = fetch($dbh, $sql, $data);

    if (!empty(array_shift($result))) {
        $err_msg['mail_address'] = ERR_MSG_MAIL_DUP;
    }
}
/**
 * パスワード再入力チェック
 * 
 * @param array $err_msg
 * @param string $pass
 * @param string $pass_re
 * @param string $key
 */
function validPassRe(&$err_msg, $pass, $pass_re, $key)
{
    if ($pass !== $pass_re) {
        $err_msg[$key] = ERR_MSG_PASS_RE;
    }
}

/**
 * パスワードチェック
 * 
 * @param array $err_msg
 * @param string $pass
 * @param string $key
 */
function validPass(&$err_msg, $pass, $key)
{
    validHalf($err_msg, $pass, $key);
    validMinLen($err_msg, $pass, $key);
    validMaxLen($err_msg, $pass, $key);
}

/**
 * パスワード認証
 * 
 * @param array $err_msg
 * @param int $user_id
 * @param string $pass
 * @param string $key
 */
function validPassVerify(&$err_msg, $user_id, $pass, $key)
{
    $user_data = getPassword($err_msg, $user_id);
    if (!password_verify($pass, $user_data['password'])) {
        $err_msg[$key] = ERR_MSG_PASS_OLD;
    }
}

/**
 * 古いパスワードと新しいパスワードが違うものかチェック
 * 
 * @param array $err_msg
 * @param string $pass_old
 * @param string $pass_new
 */
function validNewPass(&$err_msg, $pass_old, $pass_new)
{
    if ($pass_old === $pass_new) {
        $err_msg['password_new'] = ERR_MSG_PASS_OLD_DUP;
    }
}

/**
 * 認証キーの制限チェック
 * 
 * @param array $err_msg
 * @param $auth_key_limit
 */
function validAuthKeyLimit(&$err_msg, $auth_key_limit)
{
    if (time() > $auth_key_limit) {
        $err_msg['common'] = ERR_MSG_EXPIRE;
    }
}
/**
 * 文字列があっているかどうか
 * 
 * @param array $err_msg
 * @param string $str1
 * @param string $str2
 */
function validMatch(&$err_msg, $str1, $str2)
{
    if ($str1 !== $str2) {
        $err_msg['common'] = ERR_MSG_MATCH;
    }
}

/**
 * 固定長チェック
 * 
 * @param array $err_msg
 * @param string $str
 * @param string $key
 * @param int $len
 */
function validLength(&$err_msg, $str, $key, $len = 8)
{
    if (mb_strlen($str) !== $len) {
        $err_msg[$key] = $len . ERR_MSG_LENGTH;
    }
}


/**
 * カテゴリー重複チェック
 * @param array $err_msg
 * @param int $user_id
 * @param string $category
 */
function validCategoryDup(&$err_msg, $user_id, $category){

    $dbh = dbConnect();
    $sql = 'SELECT count(*) FROM categories WHERE user_id = :user_id AND title = :title AND is_deleted = 0';
    $data = array(
        ':title' => $category,
        ':user_id' => $user_id
    );

    $result = fetch($dbh, $sql, $data);

    if (!empty(array_shift($result))) {
        $err_msg['common'] = ERR_MSG_CATEGORY_DUP;
    }
}

/**
 * 空白文字チェック
 */
function validWhiteSpace(&$err_msg, $str) {
    if ($str === '' || $str === '　') {
        $err_msg['common'] = ERR_MSG_WHITE_SPACE;
    }
}
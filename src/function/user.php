<?php

/**
 * ユーザー登録
 * 
 * @param array $err_msg
 * @param string $mail_address
 * @param string $password
 * @param bool $admin_flag
 */
function createUser(&$err_msg, $mail_address, $password, $admin_flag)
{

    try {
        $dbh = dbConnect();

        if($admin_flag) {
            
            $authority = 100;
            $sql = 'INSERT INTO users (authority, mail_address, password, login_time, created_at) VALUES(:authority, :mail_address, :password, :login_time, :created_at)';


        } else {

            $authority = 1;
            $sql = 'INSERT INTO users (mail_address, password, login_time, created_at) VALUES(:mail_address, :password, :login_time, :created_at)';
        }
        
        $data = array(
            ':authority' => $authority,
            ':mail_address' => $mail_address,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':login_time' => date('Y-m-d H:i:s'),
            ':created_at' => date('Y-m-d H:i:s'),
        );

        if (execute($dbh, $sql, $data)) {

            $session_limit = 60 * 60;
            $_SESSION['login_date'] = time();
            $_SESSION['login_limit'] = $session_limit;

            if($admin_flag) {
                $_SESSION['admin_user_id'] = $dbh->lastInsertId();
            } else {
                $_SESSION['user_id'] = $dbh->lastInsertId();
            }
        }
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}


/**
 * メールアドレスを使ってユーザーのデータを取得
 * 
 * @param array $err_msg
 * @param string $column
 * @param string $mail_address
 * @param bool $admin_flag
 * @return mixed
 */
function fetchUserDataByMailAddress(&$err_msg, $column, $mail_address, $admin_flag)
{

    try {

        $dbh = dbConnect();

        if($admin_flag) {
            $sql = 'SELECT ' . $column . ' FROM users WHERE authority = 100 AND mail_address = :mail_address AND is_deleted = 0';

        } else {
            $sql = 'SELECT ' . $column . ' FROM users WHERE authority = 1 AND mail_address = :mail_address AND is_deleted = 0';
        }
        $data = array(':mail_address' => $mail_address);

        $user_data = fetch($dbh, $sql, $data);
        return $user_data;

    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}

/**
 * ログイン
 * 
 * @param array $err_msg
 * @param string $mail_address
 * @param string $password
 * @param bool $pass_save
 * @param bool $admin_flag
 */

function login(&$err_msg, $mail_address, $password, $pass_save, $admin_flag)
{

    $user_data = fetchUserDataByMailAddress($err_msg, 'user_id,password', $mail_address, $admin_flag);


    if (!empty($user_data) && password_verify($password, $user_data['password'])) {

        $session_limit = 60 * 60;
        $_SESSION['login_date'] = time();

        if($admin_flag) {
            $_SESSION['admin_user_id'] = (int)$user_data['user_id'];
        } else {
            $_SESSION['user_id'] = (int)$user_data['user_id'];
        }
        
        if ($pass_save) {
            $_SESSION['login_limit'] = $session_limit * 24 * 30;
        } else {
            $_SESSION['login_limit'] = $session_limit;

        }

        return true;

    } else {
        $err_msg['common'] = ERR_MSG_LOGIN;
    }
}
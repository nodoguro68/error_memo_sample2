<?php

/**
 * ユーザー登録
 * 
 * @param array $err_msg
 * @param string $mail_address
 * @param string $password
 */
function createUser(&$err_msg, $mail_address, $password)
{

    try {
        $dbh = dbConnect();

        $sql = 'INSERT INTO users (mail_address, password, login_time, created_at) VALUES(:mail_address, :password, :login_time, :created_at)';

        $data = array(
            ':mail_address' => $mail_address,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':login_time' => date('Y-m-d H:i:s'),
            ':created_at' => date('Y-m-d H:i:s'),
        );

        if (execute($dbh, $sql, $data)) {

            // セッション
            $session_limit = 60 * 60;
            $_SESSION['login_date'] = time();
            $_SESSION['login_limit'] = $session_limit;

            // ユーザーIDを格納
            $_SESSION['user_id'] = $dbh->lastInsertId();
        }
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}
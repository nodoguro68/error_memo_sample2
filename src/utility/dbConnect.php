<?php 

/**
 * DB接続
 * 
 * @return object
 */
function dbConnect(){
    try{
        $dsn = 'mysql:dbname=error_memo;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';
        $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        PDO::ATTR_EMULATE_PREPARES => false
    );

    $dbh = new PDO($dsn, $user, $password, $options);

    return $dbh;

    } catch(PDOException $e){
        $err_msg['common'] = ERR_MSG_DB_CONNECT;
        exit('DB接続エラー'.$e->getMessage());

    }
}

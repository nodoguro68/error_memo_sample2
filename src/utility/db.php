<?php

/**
 * プリペアードステートメント
 * 
 * @param string $sql
 * @param array $params
 * @return object
 */
function execute($dbh, $sql, $params)
{

    $stmt = $dbh->prepare($sql);

    if ($stmt->execute($params)) {
        return $stmt;
    } else {
        return false;
    }
}

/**
 * レコードを一行取得
 * 
 * @param string $sql
 * @param array $params
 * @return mixed
 */
function fetch($dbh, $sql, $params)
{
    return execute($dbh, $sql, $params)->fetch(PDO::FETCH_ASSOC);
}

/**
 * 全レコードを取得
 * 
 * @param string $sql
 * @param array $params
 * @return mixed
 */
function fetchAll($dbh, $sql, $params)
{
    return execute($dbh, $sql, $params)->fetchAll(PDO::FETCH_ASSOC);
}

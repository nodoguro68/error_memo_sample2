<?php

/**
 * カテゴリー追加
 * @param array $err_msg
 * @param int $user_id
 * @param int $folder_id
 * @param int $category_id
 * @param string $title
 * @param string $ideal
 * @param string $solution
 * @param string $attenmp
 * @param string $reference
 * @param string $etc
 * @param $is_published
 */
function createMemo(&$err_msg, $user_id, $folder_id, $category_id, $title, $ideal, $solution, $attempt, $reference, $etc, $is_published)
{

    try {
        $dbh = dbConnect();
        $sql = 'INSERT INTO memos (user_id, folder_id, category_id, title, ideal, solution, attempt, reference, etc, created_at, is_published) VALUES(:user_id, :folder_id, :category_id, :title, :ideal, :solution, :attempt, :reference, :etc, :created_at, :is_published)';

        $data = array(
            ':user_id' => $user_id,
            ':folder_id' => $folder_id,
            ':category_id' => $category_id,
            ':title' => $title,
            ':ideal' => $ideal,
            ':solution' => $solution,
            ':attempt' => $attempt,
            ':reference' => $reference,
            ':etc' => $etc,
            ':created_at' => date('Y-m-d H:i:s'),
            ':is_published' => $is_published,
        );

        if (execute($dbh, $sql, $data)) {

            return;
        }
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}


/**
 * フォルダ内のメモ全件取得
 * @param array $err_msg
 * @param int $user_id
 * @param int $folder_id
 * @return mixed
 */
function fetchMemos(&$err_msg, $user_id, $folder_id) {
    try {

        $dbh = dbConnect();

        $sql = 'SELECT memo_id, title, is_published FROM memos WHERE user_id = :user_id AND folder_id = :folder_id AND is_deleted = 0';
        $data = array(
            ':user_id' => $user_id,
            ':folder_id' => $folder_id,
        );

        $memos = fetchAll($dbh, $sql, $data);
        return $memos;
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}
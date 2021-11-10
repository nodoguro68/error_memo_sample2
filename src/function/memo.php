<?php

/**
 * メモ新規登録
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
 * @param $is_solved
 * @param $is_published
 */
function createMemo(&$err_msg, $user_id, $folder_id, $category_id, $title, $ideal, $solution, $attempt, $reference,$etc, $is_solved, $is_published)
{

    try {
        $dbh = dbConnect();
        $sql = 'INSERT INTO memos (user_id, folder_id, category_id, title, ideal, solution, attempt, reference, etc, created_at, is_solved , is_published) VALUES(:user_id, :folder_id, :category_id, :title, :ideal, :solution, :attempt, :reference, :etc, :created_at, :is_solved, :is_published)';

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
            ':is_solved' => $is_solved,
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

/**
 * メモ詳細取得
 * @param array $err_msg
 * @param int $memo_id
 * @return mixed
 */
function fetchMemo(&$err_msg, $memo_id)
{
    try {

        $dbh = dbConnect();

        $sql = 'SELECT memo_id, m.category_id, m.title, ideal, solution, attempt, reference, etc, m.created_at, is_solved, is_published, c.title AS category_title FROM memos AS m INNER JOIN categories AS c ON m.category_id = c.category_id WHERE memo_id = :memo_id AND m.is_deleted = 0';
        $data = array(
            ':memo_id' => $memo_id,
        );

        $memo = fetch($dbh, $sql, $data);
        return $memo;

    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}


/**
 * メモ編集
 * @param array $err_msg
 * @param int $user_id
 * @param int $category_id
 * @param string $title
 * @param string $ideal
 * @param string $solution
 * @param string $attenmp
 * @param string $reference
 * @param string $etc
 * @param $is_solved
 * @param $is_published
 */
function editMemo(&$err_msg, $memo_id, $category_id, $title, $ideal, $solution, $attempt, $reference, $etc, $is_solved, $is_published) {
    try {
        $dbh = dbConnect();
        $sql = 'UPDATE memos SET category_id = :category_id, title = :title, ideal = :ideal, solution = :solution, attempt = :attempt, reference = :reference, etc = :etc, is_solved = :is_solved, is_published = :is_published WHERE memo_id = :memo_id AND is_deleted = 0';

        $data = array(
            ':memo_id' => $memo_id,
            ':category_id' => $category_id,
            ':title' => $title,
            ':ideal' => $ideal,
            ':solution' => $solution,
            ':attempt' => $attempt,
            ':reference' => $reference,
            ':etc' => $etc,
            ':is_solved' => $is_solved,
            ':is_published' => $is_published,
        );

        if (execute($dbh, $sql, $data)) {

            return;
        }

    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG.'編集';
    }
}


/**
 * メモ1件削除
 * @param array $err_msg
 * @param int $memo_id
 */
function deleteMemo(&$err_msg, $memo_id) {

    try {

        $dbh = dbConnect();

        $sql = 'UPDATE memos SET is_deleted = 1 WHERE memo_id = :memo_id AND is_deleted = 0';
        $data = array(
            ':memo_id' => $memo_id
        );

        if (execute($dbh, $sql, $data)) {
            return true;
        }
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}
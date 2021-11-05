<?php 

/**
 * フォルダ新規作成
 * @param array $err_msg
 * @param int $user_id
 * @param string $folder
 */
function createFolder(&$err_msg, $user_id, $folder) {

    try {
        $dbh = dbConnect();
        $sql = 'INSERT INTO folders (user_id, title, created_at) VALUES(:user_id, :title, :created_at)';

        $data = array(
            ':user_id' => $user_id,
            ':title' => $folder,
            ':created_at' => date('Y-m-d H:i:s'),
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
 * フォルダ一覧取得
 * @param array $err_msg
 * @param int $user_id
 * @return
 */
function fetchFolders(&$err_msg, $user_id)
{

    try {

        $dbh = dbConnect();

        $sql = 'SELECT folder_id, title FROM folders WHERE user_id = :user_id AND is_deleted = 0';
        $data = array(':user_id' => $user_id);

        $folders = fetchAll($dbh, $sql, $data);
        return $folders;
        
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}

/**
 * フォルダ取得
 * @param array $err_msg
 * @param int $folder_id
 * @param int $user_id
 * @return
 */
function fetchFolder(&$err_msg, $folder_id, $user_id)
{

    try {

        $dbh = dbConnect();

        $sql = 'SELECT folder_id, title FROM folders WHERE folder_id = :folder_id AND user_id = :user_id AND is_deleted = 0';
        $data = array(
            ':folder_id' => $folder_id,
            ':user_id' => $user_id,
        );

        $folder = fetch($dbh, $sql, $data);
        return $folder;

    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}


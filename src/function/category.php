<?php 

/**
 * カテゴリー追加
 * @param array $err_msg
 * @param int $user_id
 * @param string $category
 */
function createCategory(&$err_msg, $user_id, $category) {

    try {
        $dbh = dbConnect();
        $sql = 'INSERT INTO categories (user_id, title, created_at) VALUES(:user_id, :title, :created_at)';

        $data = array(
            ':user_id' => $user_id,
            ':title' => $category,
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
 * カテゴリー一覧リスト取得
 * @param array $err_msg
 * @return
 */
function fetchCategories(&$err_msg){

    try {

        $dbh = dbConnect();

        $sql = 'SELECT category_id, title FROM categories WHERE is_deleted = 0';
        $stmt = $dbh->query($sql);

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;

    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}


/**
 * カテゴリー削除
 * @param array $err_msg
 * @param int $category_id
 */
function deleteCategory(&$err_msg, $category_id) {

    try {

        $dbh = dbConnect();

        $sql = 'UPDATE categories SET is_deleted = 1 WHERE category_id = :category_id AND is_deleted = 0';
        $data = array(
            ':category_id' => $category_id,
        );

        if (execute($dbh, $sql, $data)) {
            return true;
        }

    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = ERR_MSG;
    }
}
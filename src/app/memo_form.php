<?php

require_once '../utility/utility.php';
require_once '../function/category.php';
require_once '../function/memo.php';

$user_id = (int)$_SESSION['user_id'];
$memo_id = (!empty($_GET['memo_id'])) ? $_GET['memo_id'] : '';
$memo = (!empty($memo_id)) ? fetchMemo($err_msg, $memo_id) : '';
$editFlag = (!empty($memo)) ? true : false;

$categories = fetchCategories($err_msg);

if (!empty($_POST)) {

    if (!empty($_POST['create_memo'])) {

        $folder_id = (int)$_SESSION['folder_id'];
        $category_id = (int)filter_input(INPUT_POST, 'category_id');
        $title = filter_input(INPUT_POST, 'title');
        $is_published = filter_input(INPUT_POST, 'is_published');
        $ideal = filter_input(INPUT_POST, 'ideal');
        $solution = filter_input(INPUT_POST, 'solution');
        $attempt = filter_input(INPUT_POST, 'attempt');
        $reference = filter_input(INPUT_POST, 'reference');
        $etc = filter_input(INPUT_POST, 'etc');

        validRequired($err_msg, $title, 'title');

        if (empty($err_msg)) {

            if (empty($err_msg)) {

                // メモ登録
                createMemo($err_msg, $user_id, $folder_id, $category_id, $title, $ideal, $solution, $attempt, $reference, $etc, $is_published);

                header('Location: mypage.php?folder_id=' . $folder_id);
            }
        }
    }

    if (!empty($_POST['edit_memo'])) {

        // post送信の値を変数に格納
        $category_id = (int)filter_input(INPUT_POST, 'category_id');
        $title = filter_input(INPUT_POST, 'title');
        $is_published = filter_input(INPUT_POST, 'is_published');
        $ideal = filter_input(INPUT_POST, 'ideal');
        $solution = filter_input(INPUT_POST, 'solution');
        $attempt = filter_input(INPUT_POST, 'attempt');
        $reference = filter_input(INPUT_POST, 'reference');
        $etc = filter_input(INPUT_POST, 'etc');

        validRequired($err_msg, $title, 'title');

        // DBのデータとpostの値が同じかどうかチェック
        // バリデーション
        if ((int)$memo['category_id'] !== $category_id) {
            validInt($err_msg, $category_id);
        }
        if ($memo['title'] !== $title) {
            validMaxLen($err_msg, $title, 'title');
        }

        if (empty($err_msg)) {

            editMemo($err_msg, $memo_id, $category_id, $title, $ideal, $solution, $attempt, $reference, $etc, $is_published);

            header('Location: memo_form.php?memo_id=' . $memo_id);
        }
    }
}

$page_title = ($editFlag) ? 'メモ編集' : 'メモ新規登録';
require_once '../template/head.php';
require_once '../template/header.php';
?>

<main class="main">
    <div class="container">

        <form method="post" action="" class="memo-form">
            <div class="form__header">
                <h2 class="form__title"><?= ($editFlag) ? 'メモ編集' : 'メモ新規登録'; ?></h2>
                <?php include_once '../template/err-msg_area.php'; ?>
                <?php if ($editFlag) : ?>
                    <span class="date"><?= formatStr(escape($memo['created_at']), 0, 10); ?></span>
                    <input type="submit" name="delete_memo" value="削除">
                <?php endif; ?>
            </div>
            <div class="form__body">
                <!-- エラータイトル -->
                <div class="form__item">
                    <label for="title" class="form__label">エラータイトル</label>
                    <input type="text" name="title" class="form__input" id="title" value="<?= getFormData('title', $memo); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'title'); ?></span>
                </div>
                <!-- 公開するかどうか -->
                <div class="form__item">
                    <label for="private" class="form__label">非公開</label><input type="radio" name="is_published" value="0" id="private" <?php if ((int)$memo['is_published'] === 0) echo 'checked'; ?>>
                    <label for="public" class="form__label">公開</label><input type="radio" name="is_published" value="1" id="public" <?php if ((int)$memo['is_published'] === 1) echo 'checked'; ?>>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'is_published'); ?></span>
                </div>
                <!-- カテゴリー -->
                <div class="form__item">
                    <label for="category" class="form__label">カテゴリー</label>
                    <select name="category_id" id="category" class="form__select">
                        <?php if (!empty($categories)) : ?>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= escape($category['category_id']); ?>" <?php if ($memo['category_id'] === $category['category_id']) echo 'selected'; ?>><?= escape($category['title']); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'category'); ?></span>
                </div>
                <!-- やりたいこと -->
                <div class="form__item">
                    <label for="ideal" class="form__label">やりたいこと</label>
                    <textarea name="ideal" id="ideal" class="form__textarea"><?= getFormData('ideal', $memo); ?></textarea>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'ideal'); ?></span>
                </div>
                <!-- 解決方法 -->
                <div class="form__item">
                    <label for="solution" class="form__label">解決方法</label>
                    <textarea name="solution" id="solution" class="form__textarea"><?= getFormData('solution', $memo); ?></textarea>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'solution'); ?></span>
                </div>
                <!-- 試したこと -->
                <div class="form__item">
                    <label for="attempt" class="form__label">試したこと</label>
                    <textarea name="attempt" id="attempt" class="form__textarea"><?= getFormData('attempt', $memo); ?></textarea>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'attempt'); ?></span>
                </div>
                <!-- 参考 -->
                <div class="form__item">
                    <label for="reference" class="form__label">参考</label>
                    <input type="text" name="reference" class="form__input" id="reference" value="<?= getFormData('reference', $memo); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'reference'); ?></span>
                </div>
                <!-- その他 -->
                <div class="form__item">
                    <label for="etc" class="form__label">その他</label>
                    <textarea name="etc" id="etc" class="form__textarea"><?= getFormData('etc', $memo); ?></textarea>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'etc'); ?></span>
                </div>
                <div class="form__footer">
                    <div class="btn-container">
                        <input type="submit" name="<?= ($editFlag) ? 'edit_memo' : 'create_memo'; ?>" value="<?= ($editFlag) ? '編集' : '保存'; ?>" class="btn btn--form">
                    </div>
                </div>
        </form>
    </div>

</main>
</body>

</html>
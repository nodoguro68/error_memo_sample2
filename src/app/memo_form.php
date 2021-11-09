<?php

require_once '../utility/utility.php';
require_once '../function/category.php';
require_once '../function/memo.php';

$user_id = (int)$_SESSION['user_id'];
$categories = fetchCategories($err_msg);

if (!empty($_POST)) {

    
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

            header('Location: mypage.php?folder_id='.$folder_id);
        }
    }
}

$page_title = 'メモ新規登録';
require_once '../template/head.php';
require_once '../template/header.php';
?>

<main class="main">
    <div class="container">

        <form method="post" action="" class="memo-form">
            <div class="form__header">
                <h2 class="form__title">メモ新規登録</h2>
                <?php include_once '../template/err-msg_area.php'; ?>
            </div>
            <div class="form__body">
                <!-- エラータイトル -->
                <div class="form__item">
                    <label for="title" class="form__label">エラータイトル</label>
                    <input type="text" name="title" class="form__input" id="title" value="<?= getFormData('title'); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'title'); ?></span>
                </div>
                <!-- 公開するかどうか -->
                <div class="form__item">
                    <label for="private" class="form__label">非公開</label><input type="radio" name="is_published" value="0" id="private" checked>
                    <label for="public" class="form__label">公開</label><input type="radio" name="is_published" value="1" id="public">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'is_published'); ?></span>
                </div>
                <!-- カテゴリー -->
                <div class="form__item">
                    <label for="category" class="form__label">カテゴリー</label>
                    <select name="category_id" id="category" class="form__select">
                        <?php if (!empty($categories)) : ?>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= escape($category['category_id']); ?>"><?= escape($category['title']); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'category'); ?></span>
                </div>
                <!-- やりたいこと -->
                <div class="form__item">
                    <label for="ideal" class="form__label">やりたいこと</label>
                    <textarea name="etc" id="etc" class="form__textarea"><?= getFormData('ideal'); ?></textarea>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'ideal'); ?></span>
                </div>
                <!-- 解決方法 -->
                <div class="form__item">
                    <label for="solution" class="form__label">解決方法</label>
                    <textarea name="etc" id="etc" class="form__textarea"><?= getFormData('solution'); ?></textarea>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'solution'); ?></span>
                </div>
                <!-- 試したこと -->
                <div class="form__item">
                    <label for="attempt" class="form__label">試したこと</label>
                    <textarea name="etc" id="etc" class="form__textarea"><?= getFormData('attempt'); ?></textarea>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'attempt'); ?></span>
                </div>
                <!-- 参考 -->
                <div class="form__item">
                    <label for="reference" class="form__label">参考</label>
                    <input type="text" name="reference" class="form__input" id="reference" value="<?= getFormData('reference'); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'reference'); ?></span>
                </div>
                <!-- その他 -->
                <div class="form__item">
                    <label for="etc" class="form__label">その他</label>
                    <textarea name="etc" id="etc" class="form__textarea"><?= getFormData('etc'); ?></textarea>
                    <span class="err-msg"><?= getErrMsg($err_msg, 'etc'); ?></span>
                </div>
                <div class="form__footer">
                    <div class="btn-container">
                        <input type="submit" value="登録" class="btn btn--form">
                    </div>
                </div>
        </form>
    </div>

</main>
</body>

</html>
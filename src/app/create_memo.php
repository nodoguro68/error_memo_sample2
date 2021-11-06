<?php

require_once '../utility/utility.php';
require_once '../function/memo.php';


if (!empty($_POST)) {

    $mail_address = filter_input(INPUT_POST, 'mail_address');
    $password = filter_input(INPUT_POST, 'password');
    $pass_save = (!empty($_POST['pass_save'])) ? true : false;
    $admin_flag = false;

    validRequired($err_msg, $mail_address, 'mail_address');
    validRequired($err_msg, $password, 'password');

    if (empty($err_msg)) {
        validMaxLen($err_msg, $mail_address, 'mail_address');
        validMail($err_msg, $mail_address);
        validPass($err_msg, $password, 'password');

        if (empty($err_msg)) {


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
                <div class="err-msg__area"><?= getErrMsg($err_msg, 'common'); ?></div>
            </div>
            <div class="form__body">
                <div class="form__item">
                    <label for="mail_address" class="form__label">メールアドレス</label>
                    <input type="text" name="mail_address" class="form__input" id="mail_address" value="<?= getFormData('mail_address'); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'mail_address'); ?></span>
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
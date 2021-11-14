<?php

require_once '../utility/utility.php';
require_once '../function/user.php';


if (!empty($_POST)) {

    $admin_user_id = $_SESSION['admin_user_id'];
    $mail_address = filter_input(INPUT_POST, 'mail_address');
    $password = filter_input(INPUT_POST, 'password');
    $admin_flag = true;

    validRequired($err_msg, $mail_address, 'mail_address');
    validRequired($err_msg, $password, 'password');


    if (empty($err_msg)) {
        validMaxLen($err_msg, $mail_address, 'mail_address');
        validMail($err_msg, $mail_address);
        validPass($err_msg, $password, 'password');
        validPassVerify($err_msg, $admin_user_id, $password, 'password');

        if (empty($err_msg)) {

            $tables = [
                'users'
            ];

            signout($err_msg, $tables, $admin_user_id, $admin_flag);

            header('Location: login.php');
        }
    }
}

$page_title = '管理ユーザー退会ページ';
require_once '../template/head.php';
require_once '../template/header.php';
?>

<main class="main">
    <div class="container">

        <form method="post" action="" class="form">
            <div class="form__header">
                <h2 class="form__title">管理ユーザー退会</h2>
                <?php include_once '../template/err-msg_area.php'; ?>
            </div>
            <div class="form__body">
                <div class="form__item">
                    <label for="mail_address" class="form__label">メールアドレス</label>
                    <input type="text" name="mail_address" class="form__input" id="mail_address" value="<?= getFormData('mail_address'); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'mail_address'); ?></span>
                </div>
                <div class="form__item">
                    <label for="password" class="form__label">パスワード<span class="form__note">半角英数字8文字以上</span></label>
                    <input type="password" name="password" class="form__input" id="password" value="<?= getFormData('password'); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'password'); ?></span>
                </div>
            </div>
            <div class="form__footer">
                <div class="btn-container">
                    <input type="submit" value="退会" class="btn btn--form">
                </div>
            </div>
        </form>
    </div>

</main>
</body>

</html>
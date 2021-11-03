<?php

require_once '../utility/utility.php';
require_once '../function/user.php';


if (!empty($_POST)) {

    $mail_address = filter_input(INPUT_POST, 'mail_address');
    $password = filter_input(INPUT_POST, 'password');
    $pass_save = (!empty($_POST['pass_save'])) ? true : false;

    validRequired($err_msg, $mail_address, 'mail_address');
    validRequired($err_msg, $password, 'password');

    if (empty($err_msg)) {
        validMaxLen($err_msg, $mail_address, 'mail_address');
        validMail($err_msg, $mail_address);
        validPass($err_msg, $password, 'password');
    
        if (empty($err_msg)) {
            
            login($err_msg, $mail_address, $password, $pass_save);
    
            header('Location: mypage.php');
        }
    }
}
    
$page_title = 'ログインページ';
require_once '../template/head.php';
require_once '../template/header.php';
?>

<main class="main">
    <div class="container">

        <form method="post" action="" class="form">
            <div class="form__header">
                <h2 class="form__title">ログイン</h2>
                <div class="err-msg__area"><?= getErrMsg($err_msg, 'common'); ?></div>
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
                <div class="form__footer">
                    <label>
                        <input type="checkbox" name="pass_save">自動でログイン
                    </label>
                    <div class="btn-container">
                        <input type="submit" value="ログイン" class="btn btn--form">
                    </div>
                    <div class="link-container">
                        <a href="pass_remind_send.php" class="form__link">パスワードを忘れた場合はこちら</a>
                        <a href="signup.php" class="form__link">新規登録はこちら</a>
                    </div>
                </div>
        </form>
    </div>

</main>
</body>

</html>
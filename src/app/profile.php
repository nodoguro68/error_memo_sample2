<?php

require_once '../utility/utility.php';
require_once '../utility/upload.php';
require_once '../function/user.php';

$user_id = (int)$_SESSION['user_id'];
$profile_data = fetchProfileData($err_msg, $user_id);

if (!empty($_POST)) {

    $user_name = filter_input(INPUT_POST, 'user_name');
    $mail_address = filter_input(INPUT_POST, 'mail_address');
    $profile_img = (!empty($_FILES['profile_img']['name'])) ? uploadImg($err_msg, $_FILES['profile_img'], 'profile_img') : '';
    $profile_img = (empty($profile_img) && !empty($profile_data['profile_img'])) ? $profile_data['profile_img'] : $profile_img;
    $github = filter_input(INPUT_POST, 'github');
    $facebook = filter_input(INPUT_POST, 'facebook');
    $twitter = filter_input(INPUT_POST, 'twitter');

    if ($profile_data['user_name'] !== $user_name) {
        validMaxLen($err_msg, $user_name, 'user_name');
    }
    if ($profile_data['mail_address'] !== $mail_address) {
        validRequired($err_msg, $mail_address, 'mail_address');
        validMaxLen($err_msg, $mail_address, 'mail_address');
        validMail($err_msg, $mail_address);
        validMailDup($err_msg, $mail_address);
    }
    if ($profile_data['github'] !== $github) {
        validMaxLen($err_msg, $github, 'github');
    }
    if ($profile_data['facebook'] !== $facebook) {
        validMaxLen($err_msg, $facebook, 'facebook');
    }
    if ($profile_data['twitter'] !== $twitter) {
        validMaxLen($err_msg, $twitter, 'twitter');
    }

    if (empty($err_msg)) {

        editProfile($err_msg, $user_id, $mail_address, $user_name, $profile_img, $github, $facebook, $twitter);
        header('Location: mypage.php');
    }
}

$page_title = 'プロフィール';
require_once '../template/head.php';
require_once '../template/header.php';
?>

<main class="main">
    <div class="container">

        <form method="post" action="" class="form" enctype="multipart/form-data">
            <div class="form__header">
                <h2 class="form__title">プロフィール</h2>
                <?php include_once '../template/err-msg_area.php'; ?>
            </div>
            <div class="form__body">
                <div class="form__item-img">
                    <input type="file" name="profile_img" class="form__file">
                    <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                    <img src="<?= (!empty($profile_data['profile_img']) ? getFormData('profile_img', $profile_data): '../resource/img/no-image.png');?>" alt="プロフィール画像" class="">
                </div>
                <div class="form__item">
                    <label for="user_name" class="form__label">ユーザーネーム</label>
                    <input type="text" name="user_name" class="form__input" id="user_name" value="<?= getFormData('user_name', $profile_data); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'user_name'); ?></span>
                </div>
                <div class="form__item">
                    <label for="mail_address" class="form__label">メールアドレス</label>
                    <input type="text" name="mail_address" class="form__input" id="mail_address" value="<?= getFormData('mail_address', $profile_data); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'mail_address'); ?></span>
                </div>
                <div class="form__item">
                    <label for="github" class="form__label">Github</label>
                    <input type="text" name="github" class="form__input" id="github" value="<?= getFormData('github', $profile_data); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'github'); ?></span>
                </div>
                <div class="form__item">
                    <label for="facebook" class="form__label">Facebook</label>
                    <input type="text" name="facebook" class="form__input" id="facebook" value="<?= getFormData('facebook', $profile_data); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'facebook'); ?></span>
                </div>
                <div class="form__item">
                    <label for="twitter" class="form__label">twitter</label>
                    <input type="text" name="twitter" class="form__input" id="twitter" value="<?= getFormData('twitter', $profile_data); ?>">
                    <span class="err-msg"><?= getErrMsg($err_msg, 'twitter'); ?></span>
                </div>
                <div class="form__footer">
                    <div class="btn-container">
                        <input type="submit" value="保存" class="btn btn--form">
                    </div>
                </div>
        </form>
    </div>

</main>
</body>

</html>
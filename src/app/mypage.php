<?php

require_once '../utility/utility.php';
require_once '../function/user.php';
require_once '../function/folder.php';

$user_id = $_SESSION['user_id'];
$folders = fetchFolders($err_msg, $user_id);

if(!empty($_GET)) {

    if (!empty($_GET['folder_id'])) {
        $folder_id = filter_input(INPUT_GET, 'folder_id');
        $folder = fetchFolder($err_msg, $folder_id, $user_id);
        $folder_id = $folder['folder_id'];
        $folder_title = $folder['title'];
    }

}


if (!empty($_POST)) {

    if (!empty($_POST['create_folder'])) {

        $folder = trim(filter_input(INPUT_POST, 'create_folder'));

        validWhiteSpace($err_msg, $folder);
        validMaxLen($err_msg, $folder, 'common');
        validFolderDup($err_msg, $user_id, $folder);

        if (empty($err_msg)) {

            createFolder($err_msg, $user_id, $folder);

            header('Location: mypage.php');
        }
    }
}


$page_title = 'マイページ';
require_once '../template/head.php';
require_once '../template/header.php';
?>

<main class="main">
    <div class="container">
        <ul class="link-list">
            <li class="link-list__item"><a href="admin.php" class="link-list__link">管理画面</a></li>
            <li class="link-list__item"><a href="profile.php" class="link-list__link">プロフィール</a></li>
            <li class="link-list__item"><a href="pass_edit.php" class="link-list__link">パスワード変更</a></li>
            <li class="link-list__item"><a href="signout.php" class="link-list__link">退会</a></li>
        </ul>

        <!-- メモ検索バー -->
        <form action="" method="post" class="search-form">
            <input type="text" name="search_memo" class="form__input" placeholder="メモを検索">
            <input type="submit" value="検索">
        </form>

        <!-- 検索件数表示エリア -->
        <div class="search-memo__count-area">
            <span class="count"></span>件
        </div>

        <!-- フォルダといいねの切り替えのタブ -->
        <ul class="tab-menu">
            <li class="tab-menu__item">マイフォルダ</li>
            <li class="tab-menu__item">いいね</li>
        </ul>

        <!-- フォルダリスト -->
        <ul class="folder-list">
            <?php if (!empty($folders)) : ?>
                <?php foreach ($folders as $folder) : ?>
                    <li class="folder-list__item"><a href="mypage.php?delete_folder=<?= escape($folder['folder_id']); ?>" class="folder-list__link"><?= escape($folder['title']); ?><span class="memo-count">1</span></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <!-- 自分のメモリスト -->
        <section class="section">
            <div class="section__header">
                <h2 class="folder-title">
                    <?php if(!empty($folder_title)): ?>
                        <?= escape($folder_title); ?>
                    <?php endif; ?>
                </h2>
                <div class="btn-container">
                    <a href="mypage.php?folder_id=<?= escape($folder_id); ?>">削除</a>
                </div>
            </div>
            <ul class="memo-list">
                <li class="memo-list__item"><a href="" class="memo-list__link">メモ</a></li>
            </ul>
        </section>

        <!-- いいね蘭のメモリスト -->
        <ul class="memo-list">
            <li class="memo-list__item"><a href="" class="memo-list__link">いいね</a></li>
        </ul>

        <?php include_once '../template/err-msg_area.php'; ?>

        <!-- フォルダ追加フォーム -->
        <form action="" method="post" class="folder-form">
            <input type="text" name="create_folder" class="form__input" placeholder="フォルダを作成">
            <input type="submit" value="＋">
        </form>

    </div>

</main>
</body>

</html>
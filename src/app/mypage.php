<?php

require_once '../utility/utility.php';
require_once '../function/user.php';
require_once '../function/folder.php';
require_once '../function/memo.php';

$user_id = $_SESSION['user_id'];
$folders = fetchFolders($err_msg, $user_id);
$unsolved_memos = fetchUnsolvedMemos($err_msg, $user_id);
$solved_memos = fetchSolvedMemos($err_msg, $user_id);

if (!empty($_GET)) {

    if (!empty($_GET['folder_id'])) {
        $folder_id = (int)filter_input(INPUT_GET, 'folder_id');
        $db_folder_data = fetchFolder($err_msg, $folder_id, $user_id);
        $memos = fetchMemosInFolder($err_msg, $user_id, $folder_id);
        $_SESSION['folder_id'] = $folder_id;
    }

    if (!empty($_GET['delete_folder_id'])) {
        $folder_id = (int)filter_input(INPUT_GET, 'delete_folder_id');

        validInt($err_msg, $folder_id);

        if (empty($err_msg)) {

            deleteFolder($err_msg, $folder_id, $user_id);
            deleteMemosInFolder($err_msg, $folder_id);

            header('Location: mypage.php');
        }
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
            $db_folder_data = fetchFolderId($err_msg, $user_id, $folder);

            header('Location: mypage.php?folder_id=' . $db_folder_data['folder_id']);
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
            <li class="tab-menu__item">未解決</li>
            <li class="tab-menu__item">解決済み</li>
            <li class="tab-menu__item">いいね</li>
        </ul>

        <!-- フォルダリスト -->
        <ul class="folder-list">
            <?php if (!empty($folders)) : ?>
                <?php foreach ($folders as $folder) : ?>
                    <li class="folder-list__item"><a href="mypage.php?folder_id=<?= escape($folder['folder_id']); ?>" class="folder-list__link"><?= escape($folder['title']); ?><span class="memo-count"></span></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <!-- 自分のメモリスト -->
        <section class="section">
            <div class="section__header">
                <?php if (!empty($db_folder_data['title'])) : ?>
                    <h2 class="folder-title">
                        <?= escape($db_folder_data['title']); ?>
                    </h2>
                    <div class="btn-container">
                        <a href="mypage.php?delete_folder_id=<?= escape($db_folder_data['folder_id']); ?>">削除</a>
                    </div>
                <?php else : ?>
                    <h2>フォルダが選択されていません</h2>
                <?php endif; ?>
            </div>
            <ul class="memo-list">
                <?php if (!empty($memos)) : ?>
                    <?php foreach ($memos as $memo) : ?>
                        <li class="memo-list__item"><a href="memo_form.php?memo_id=<?= escape($memo['memo_id']); ?>" class="memo-list__link"><?= escape($memo['title']); ?></a></li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li>メモがありません</li>
                <?php endif; ?>
            </ul>
        </section>

        <!-- 未解決のメモリスト -->
        <ul class="memo-list">
            <?php if (!empty($unsolved_memos)) : ?>
                <?php foreach ($unsolved_memos as $memo) : ?>
                    <li class="memo-list__item"><a href="memo_form.php?memo_id=<?= escape($memo['memo_id']); ?>" class="memo-list__link"><?= escape($memo['title']); ?></a></li>
                <?php endforeach; ?>
            <?php else : ?>
                <li>メモがありません</li>
            <?php endif; ?>
        </ul>

        <!-- 解決済みのメモリスト -->
        <ul class="memo-list">
            <?php if (!empty($solved_memos)) : ?>
                <?php foreach ($solved_memos as $memo) : ?>
                    <li class="memo-list__item"><a href="memo_form.php?memo_id=<?= escape($memo['memo_id']); ?>" class="memo-list__link"><?= escape($memo['title']); ?></a></li>
                <?php endforeach; ?>
            <?php else : ?>
                <li>メモがありません</li>
            <?php endif; ?>
        </ul>

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

        <a href="memo_form.php" class="">メモを追加する</a>

    </div>

</main>
</body>

</html>
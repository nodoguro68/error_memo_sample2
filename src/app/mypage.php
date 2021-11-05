<?php

require_once '../utility/utility.php';
require_once '../function/user.php';

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
            <li class="folder-list__item"><a href="" class="folder-list__link">フォルダ<span class="memo-count"></span></a></li>
        </ul>

        <!-- 自分のメモリスト -->
        <ul class="memo-list">
            <li class="memo-list__item"><a href="" class="memo-list__link">メモ</a></li>
        </ul>

        <!-- いいね蘭のメモリスト -->
        <ul class="memo-list">
            <li class="memo-list__item"><a href="" class="memo-list__link">いいね</a></li>
        </ul>

        <!-- フォルダ追加フォーム -->
        <form action="" method="post" class="folder-form">
            <input type="text" name="create_folder" class="form__input" placeholder="フォルダを作成">
            <input type="submit" value="＋">
        </form>

    </div>

</main>
</body>

</html>
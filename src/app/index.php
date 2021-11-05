<?php

require_once '../utility/utility.php';
require_once '../function/user.php';

$page_title = 'マイページ';
require_once '../template/head.php';
require_once '../template/header.php';
?>

<main class="main">
    <div class="container">

        <!-- メモ検索バー -->
        <form action="" method="post" class="search-form">
            <input type="text" name="search_memo" class="form__input" placeholder="メモを検索">
            <input type="submit" value="検索">
        </form>

        <!-- 検索件数表示エリア -->
        <div class="search-memo__count-area">
            <span class="count"></span>件
        </div>

        <!-- 自分のメモリスト -->
        <ul class="memo-list">
            <li class="memo-list__item"><a href="" class="memo-list__link">メモ</a></li>
        </ul>

        <!-- ページネーション -->
        <ul class="pagenation">
            <li class="pagenation__item"><a href="" class="pagenation__link">1</a></li>
            <li class="pagenation__item"><a href="" class="pagenation__link">2</a></li>
            <li class="pagenation__item"><a href="" class="pagenation__link">3</a></li>
            <li class="pagenation__item"><a href="" class="pagenation__link">4</a></li>
            <li class="pagenation__item"><a href="" class="pagenation__link">5</a></li>
        </ul>

    </div>

</main>
</body>

</html>
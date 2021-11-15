<?php

require_once '../utility/utility.php';
require_once '../function/user.php';
require_once '../function/memo.php';

$memos = fetchMemos($err_msg);

$page_title = 'トップページ';
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

        <!-- メモリスト -->
        <ul class="memo-list">
            <?php if (!empty($memos)) : ?>
                <?php foreach ($memos as $memo) : ?>
                    <li class="memo-list__item"><a href="memo_detail.php?memo_id=<?= escape($memo['memo_id']); ?>" class="memo-list__link"><?= escape($memo['category_title']); ?> / <?= escape($memo['memo_title']); ?></a></li>
                <?php endforeach; ?>
            <?php else : ?>
                <li>メモがありません</li>
            <?php endif; ?>
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
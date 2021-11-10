<?php

require_once '../utility/utility.php';
require_once '../function/memo.php';

if (!empty($_GET['memo_id'])) {

    $memo_id = (int)filter_input(INPUT_GET, 'memo_id');
    $memo = fetchMemo($err_msg, $memo_id);
}


$page_title = 'メモ詳細ページ';
require_once '../template/head.php';
require_once '../template/header.php';
?>

<main class="main">
    <div class="container">
        <div class="link__container">
            <a href="index.php" class="link">戻る</a>
        </div>

        <section class="section">
            <div class="section__header">
                <h2><?= escape($memo['title']); ?></h2>
                <span class="date"><?= formatStr(escape($memo['created_at']), 0, 10); ?></span>
                <span class="favorite">いいね</span>
                <span class="category"><?= escape($memo['category_title']); ?></span>
            </div>
            <div class="section_body">
                <p><?= escape($memo['ideal']); ?></p>
                <p><?= escape($memo['solution']); ?></p>
                <p><?= escape($memo['attempt']); ?></p>
                <p><?= escape($memo['reference']); ?></p>
                <p><?= escape($memo['etc']); ?></p>
            </div>
            <div class="section_footer">

            </div>
        </section>
    </div>

</main>
</body>

</html>
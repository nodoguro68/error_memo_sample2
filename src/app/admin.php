<?php

require_once '../utility/utility.php';
require_once '../function/category.php';

$user_id = $_SESSION['admin_user_id'];
$categories = fetchCategories($err_msg);


if (!empty($_POST)) {

    if (!empty($_POST['create_category'])) {

        $category = trim(filter_input(INPUT_POST, 'create_category'));

        validMaxLen($err_msg, $category, 'common');
        validCategoryDup($err_msg, $user_id, $category);

        if (empty($err_msg)) {

            createCategory($err_msg, $user_id, $category);

            header('Location: admin.php');
        }
    }

    if (!empty($_POST['delete_category'])) {

        $category_id = filter_input(INPUT_POST, 'delete_category');

        if (empty($err_msg)) {

            deleteCategory($err_msg, $category_id);

            header('Location: admin.php');
        }
    }
}



$page_title = '管理画面';
require_once '../template/head.php';
require_once '../template/header.php';
?>

<main class="main">
    <div class="container">
        <aside class="sidebar">
            <ul class="sidebar-list">
                <li class="sidebar-list__item"><a href="admin_category_list.php" class="sidebar-list__link">カテゴリー一覧</a></li>
                <li class="sidebar-list__item"><a href=".php" class="sidebar-list__link">CSV</a></li>
            </ul>
        </aside>

        <?php include_once '../template/err-msg_area.php'; ?>

        <form method="post" action="" class="category-form">
            <input type="text" name="create_category" class="form__input" placeholder="カテゴリーを入力">
            <input type="submit" value="＋" class="btn-submit">
        </form>

        <form action="" method="post" class="category-list__form">
            <ul class="category-list">
                <?php if (!empty($categories)) : ?>
                    <?php foreach ($categories as $category) : ?>
                        <li class="category-list__item">
                            <span><?= escape($category['title']); ?></span>
                            <span><button type="submit" name="delete_category" value="<?= escape($category['category_id']); ?>">削除</button></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </form>
    </div>

</main>
</body>

</html>
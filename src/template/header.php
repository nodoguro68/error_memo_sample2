<header class="header">
    <div class="header__inner">
        <h1 class="header__title"><a href="index.php"></a></h1>
        <nav class="nav">
            <ul class="nav__menu">
                <li class="nav__item"><a href="index.php" class="nav__link">HOME</a></li>
                <?php if (!empty($_SESSION['admin_user_id'])) : ?>
                    <li class="nav__item"><a href="logout.php" class="nav__link">ログアウト</a></li>
                    <li class="nav__item"><a href="mypage.php" class="nav__link">管理画面</a></li>
                <?php elseif (!empty($_SESSION['user_id'])) : ?>
                    <li class="nav__item"><a href="logout.php" class="nav__link">ログアウト</a></li>
                    <li class="nav__item"><a href="mypage.php" class="nav__link">マイページ</a></li>
                <?php else : ?>
                    <li class="nav__item"><a href="signup.php" class="nav__link">ユーザー登録</a></li>
                    <li class="nav__item"><a href="login.php" class="nav__link">ログイン</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<!-- 常に表示 -->
    <!-- HOME -->

<!-- ログインしている場合 -->
    <!-- ログアウト -->

    <!-- 管理ユーザーの場合 -->
        <!-- 管理画面 -->

    <!-- 一般ユーザーの場合 -->
        <!-- マイページ -->

<!-- ログインしていない場合 -->
    <!-- ユーザー登録 -->
    <!-- ログイン -->
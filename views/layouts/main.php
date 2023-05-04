<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= $webroots ?? '' ?>
    <title>Main site</title>
</head>
<body>

<header>
    <div class="container">
        <div class="header-line">
            <span>В поликлинике</span>
            <nav>
                <?php if(app()->auth::check()) { ?>
                    <a class="link" href="<?= app()->route->getUrl('/list') ?>">Списки</a>
                    <a class="link" href="<?= app()->route->getUrl('/logout') ?>">Выход</a>
                <?php } else { ?>
                    <a class="link" href="<?= app()->route->getUrl('/login') ?>">Вход</a>
                <?php } ?>
            </nav>
        </div>
    </div>
</header>

<div>
    <?= $content ?? ''; ?>
</div>

</body>
</html>

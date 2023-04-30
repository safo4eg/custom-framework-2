<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<?= var_dump($_SESSION) ?>
<main class="index">
    <div class="form-wrapper">
        <div class="title">Вход</div>
        <form id="login_form" action="/" method="POST">
            <input type="text" name="login" placeholder="login">
            <input type="password" name="password" placeholder="password">
            <input id="login_btn" class="btn" type="submit" value="Войти">
        </form>
    </div>
</main>
</body>
</html>
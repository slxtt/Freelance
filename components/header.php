<?php
include "core.php";

if(isset($_POST['reg'])){
    $password = md5($_POST['password']);

    $users =$core->query("SELECT * FROM `users` WHERE `login` = '{$_POST['login']}' OR `email` = '{$_POST['email']}'");

    if($users->num_rows > 0){
        echo "<script>alert('Логин или электронная почта уже используется')</script>";
    } else {
        $result = $core->query("INSERT INTO users(`name`, `login`, `email`, `password`, `id_role`) VALUES ('{$_POST['name']}', '{$_POST['login']}', '{$_POST['email']}', '$password', '{$_POST['role']}')");
        header("Location: ../index.php");
    }
}

if(isset($_POST['log'])){
    $password = md5($_POST['password']);

    $users = $core->query("SELECT * FROM `users` WHERE `login` = '{$_POST['login']}' OR `email` = '{$_POST['login']}' AND `password` = '$password'");

    if($users->num_rows >0){
        $user = $users -> fetch_assoc();
        $_SESSION['user']['id'] = $user['id'];
        header("Location: /user.php");
    
    }
     
    else {
        echo "<script>alert('Логин или пароль не совпадают')</script>";
    }
}

if(isset($_GET['delete'])){
    $result= $core->query("UPDATE `response` SET `id_status` = '4' WHERE `id` = '{$_GET['id']}'");
    header("Location: /user.php");
}

if(isset($_GET['call'])){
    $result = $core->query("UPDATE `response` SET `id_status` = '2' WHERE `id` = '{$_GET['id']}'");
    header("Location: /order.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500;700;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>Chaiwork</title>
</head>
<body>
    <header>
        <div class="top">
            <a href="/index.php" class="logo">
                <img src="/img/chaiwork.svg" alt="">
            </a>
            <a href="/howitwork.php">Как это работает?</a>
            <a href="/vacancy.php">Просмотр вакансий</a>
            <?php
            if(!isset($_SESSION['user'])){
            ?>
                <button class="auth" onclick="openModal1()">Вход</button>
                <button onclick="openModal2()">Регистрация</button>
            <?php } else {?> 
                <button class="noti" onclick="openNotification()"><img src="/icons/notification.svg" alt=""></button>
                <a href="/order.php">Заказы</a>
                <a href="/user.php">Профиль</a>
                <a href="/components/logout.php">Выход</a>
                <?php } ?>
        </div>
        <div class="bottom">
            <a href="/works.php">Найти работу</a>
            <a href="/freelancer.php">Найти фрилансера</a>
        </div>
    </header>

    <div class="modal1" id="modal1">
        <div class="modal1-content">
            <div class="header">
                <p>Вход</p>
                <button onclick ="closeModal1()"><img src="/icons/group.svg"></button>
            </div>
            <form action="index.php" method="POST">
                <input type="text" placeholder="Электронная почта или логин" name="login" required>
                <input type="password" placeholder="Пароль" name="password" required>
                <button name="log" class="log">Войти</button>
            </form>
            <div class="footer">
                <p>Нет аккаунта? <button onclick ="closeModal1(); openModal2()">Зарегистрируйтесь</button></p>
            </div>
        </div>
    </div>

    <div class="modal2" id="modal2">
        <div class="modal2-content">
            <div class="header">
                <p>Регистрация</p>
                <button onclick ="closeModal2()"><img src="/icons/group.svg"></button>
            </div>
        <form action="index.php" method="POST">
            <select name="role" id="">
                <?php 
                $roles = $core->query("SELECT * FROM `roles`");
                while($role = mysqli_fetch_array($roles)){
                ?>
                <option value="<?= $role['id']?>"><?= $role['role']?></option>
                <?php } ?>
            </select>
            <input type="text" placeholder="Имя" name="name" required>
            <input type="text" placeholder="Логин" name="login" required>
            <input type="text" placeholder="Электронная почта" name="email" required>
            <input type="password" placeholder="Пароль" name="password" required>
            <button name="reg" class="reg">Регистрация</button>
        </form>
            <div class="footer">
                <p>Уже есть аккаунт? <button onclick ="closeModal2(); openModal1()">Войдите</button></p>
            </div>
        </div>
    </div>

    <div class="notification" id="notification">
        <div class="notification-content">
            <div class="header">
                <p>Уведомления</p>
                <button onclick ="closeNotification()"><img src="/icons/group.svg"></button>
            </div>
            <div class="block">
            <?php
                    $responses = $core->query("SELECT * FROM `response` WHERE `id_user_recipient` = '{$_SESSION['user']['id']}' AND `id_status` = '1' ");
                    if($responses->num_rows > 0){
                        while($response = $responses->fetch_assoc()){
                    $vacancys = $core->query("SELECT * FROM `vacancy` WHERE `id` = '{$response['id_vacancy']}'");
                    $vacancy = $vacancys->fetch_assoc(); 
                    $senders = $core->query("SELECT * FROM `users` WHERE `id` = '{$response['id_user_sender']}'");
                    $sender = $senders->fetch_assoc();
                        ?>
                    <form action="/components/header.php" class="response" method="get">
                        <input type="hidden" name="id" value="<?= $response['id']?>">
                        <p>У вас новый отклик от <?= $sender['fullName']?> по вакансий "<?= $vacancy['name']?>"</p>
                        <button name="call">Принять</button>
                        <button name="delete"><img src="/icons/trash.svg"></button>
                    </form>
                <?php }} else {?>
                    <p>У вас нет уведомлений</p>
                    <?php }?>
            </div>
        </div>
    </div>

    
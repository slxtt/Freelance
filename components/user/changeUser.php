<?php
include "../header.php";

if(!isset($_SESSION['user'])){
    header("Location: index.php");
}

if(isset($_GET['changeUser'])){
    $users = $core->query("SELECT * FROM `users` WHERE `id` = '{$_GET['id']}'");
    $user = $users->fetch_assoc();
}

if(isset($_POST['goUser'])){
    $update = $core->query("UPDATE `users` SET `name` = '{$_POST['name']}', `login` = '{$_POST['login']}', `email` = '{$_POST['email']}', `fullName` = '{$_POST['fullName']}', `about` = '{$_POST['about']}', `specialization` = '{$_POST['specialization']}', `country` = '{$_POST['country']}', `city` = '{$_POST['city']}' WHERE `id` = '{$_POST['id']}'");
    header("Location: ../../user.php");
}

if(isset($_POST['changeAvatar'])){
    $img = uniqid().'.'.substr($_FILES['avatar']['type'], 6);
    $update = $core->query("UPDATE `users` SET `avatar` = '$img' WHERE `id` = '{$_POST['id']}'");
    move_uploaded_file($_FILES['avatar']['tmp_name'],"../../img/avatar/".$img);
    header("Location: ../../user.php");
}

if(isset($_POST['changeHeader'])){
    $head = uniqid().'.'.substr($_FILES['header']['type'], 6);
    $update = $core->query("UPDATE `users` SET `header` = '$head' WHERE `id` = '{$_POST['id']}'");
    move_uploaded_file($_FILES['header']['tmp_name'],"../../img/header/".$head);
    header("Location: ../../user.php");
}

if(isset($_POST['deleteAvatar'])){
    $update = $core->query("UPDATE `users` SET `avatar` = '' WHERE `id` = '{$_POST['id']}'");
    header("Location: ../../user.php");
}

if(isset($_POST['deleteHeader'])){
    $update = $core->query("UPDATE `users` SET `header` = '' WHERE `id` = '{$_POST['id']}'");
    header("Location: ../../user.php");
}
?>

<main>
<h1 style="text-align: center; margin-top: 20px ">Изменение фото</h1>
<a href="../../user.php" class="back" style="margin-right: 700px"> < Вернуться</a>

<div class="formImg">
    <div class="left">
    <h3>Изменить аватар</h3>
            <p>Текущее фото профиля</p>
        <form action="changeUser.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $user['id']?>">
                <div class="avatar">
                    <?php if($user['avatar'] == ""){
                        ?>
                            <p><?php echo (substr($user['name'], 0, 1))?></p>
                            </div>
                        <?php
                    } else {?>
                    <img src="../../img/avatar/<?=$user['avatar']?>" alt="">
                    </div>
                    <button name="deleteAvatar" style="background-color: rgba(0, 0, 0, 0); position:absolute; margin-top: -135px; margin-left: 60px;"><img src="../../icons/group.svg" style="height: 50px; filter:drop-shadow(1px 1px 3px #e07f00);"></button>
                    <?php }?>
            <p>Максимально допустимый размер фотографии 300х300</p>
            <input type="file" name="avatar">
            <button name="changeAvatar">Изменить фото профиля</button>
        </form>
    </div>
    <div class="left">
    <h3>Изменить шапку профиля</h3>
            <p style="margin-bottom: 100px; margin-right: 200px;">Текущая шапка профиля</p>
        <form action="changeUser.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $user['id']?>">
                <div class="header">
                    <?php if($user['header'] == ""){ ?>
                    <img src="../../img/header/default.jpg">
                    </div>
                    <?php } else {?>
                    <img src="../../img/header/<?=$user['header']?>">
                    </div>
                    <button name="deleteHeader" style="background-color: rgba(0, 0, 0, 0); position:absolute; margin-top: -85px; margin-left: 310px;"><img src="../../icons/group.svg" style="height: 50px; filter:drop-shadow(1px 1px 3px #e07f00);"></button>
                    <?php }?>
            <p>Максимально допустимый размер фотографии 1920х300</p>
            <input type="file" name="header">
            <button name="changeHeader">Изменить шапку профиля</button>

        </form>

    </div>
</div>

    <h1 style="text-align: center; margin-top: 20px ">Изменение профиля</h1>
    <a href="../../user.php" class="back" style="margin-right: 240px"> < Вернуться</a>
    <form action="changeUser.php" method="post" class="createUser" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $user['id']?>">
        <input type="text" name="name" value="<?= $user['name']?>" placeholder="Ник">
        <input type="text" name="login" value="<?= $user['login']?>" placeholder="Логин">
        <input type="email" name="email" value="<?= $user['email']?>" placeholder="Email">
        <input type="text" name="fullName" value="<?= $user['fullName']?>" placeholder="Имя">
        <textarea name="about" cols="30" rows="10" placeholder="О себе"><?= $user['about']?></textarea>
        <input type="text" name="specialization" placeholder="Специализация" value="<?= $user['specialization']?>">
        <input type="text" name="country" placeholder="Страна" value="<?= $user['country']?>">
        <input type="text" name="city" placeholder="Город" value="<?= $user['city']?>">
        <button name="goUser">Изменить профиль</button>
    </form>

</main>


<?php
include "../footer.php"
?>
<?php
include "../header.php";

if(!isset($_SESSION['user'])){
    header("Location: index.php");
}

if(isset($_POST['changePass'])){
    $oldPass = md5($_POST['oldPass']);
    $newPass = md5($_POST['newPass']);
    $newPass2 = md5($_POST['newPass2']);
    $user = $core->query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']['id']}'");
    $pass = $user->fetch_assoc();
    
    if($oldPass != $pass['password']){
        echo "<script>alert('Старый пароль неверный!')</script>";
    } elseif($oldPass == $newPass){
        echo "<script>alert('Старый и новый пароль совпадают')</script>";
    } elseif($newPass != $newPass2){
        echo "<script>alert('Неправильно введен повторный пароль')</script>";
    } else{
        $result = $core->query("UPDATE `users` SET `password` = '$newPass' WHERE `id` = '{$_SESSION['user']['id']}'");
        header("Location: ../../user.php ");
    }
}

?>

<main>
<h1 style="text-align: center; margin-top: 20px ">Изменение пароля</h1>
    <a href="../../user.php" class="back" style="margin-right: 240px"> < Вернуться</a>
    <form action="changePassword.php" method="post" class="createUser" style="height: 300px;">
        <input type="password" name="oldPass" placeholder="Старый пароль">
        <input type="password" name="newPass" placeholder="Новый пароль">
        <input type="password" name="newPass2" placeholder="Повторите новый пароль">
        <button name="changePass">Изменить профиль</button>
    </form>
</main>

<?php
include "../footer.php"
?>
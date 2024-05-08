<?php
include "components/header.php";

if(!isset($_SESSION['user'])){
    header("Location: /index.php");
}
else{
    $users = $core->query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['user']['id']}'");
    $user = $users->fetch_assoc();

    $roles = $core->query("SELECT * FROM `roles` WHERE `id` = '{$user['id_role']}'");
    $role = $roles->fetch_assoc();
}


?>
<main>

<div class="header">
    <?php if($user['header'] == ""){ ?>
        <img src="img/header/default.jpg">
        <?php } else {?>
        <img src="img/header/<?=$user['header']?>">
    <?php }?>
</div>

<div class="profile">
    <div class="main">
        <div class="left">
            <div class="photo">
                <div class="photoin">
                    <?php if($user['avatar'] == ""){
                        ?>
                            <p><?php echo (substr($user['name'], 0, 1))?></p>
                        <?php
                    } else {?>
                    <img src="/img/avatar/<?=$user['avatar']?>" alt="">
                    <?php }?>
                </div>
            </div>
            <h3><?php echo($user['name'])?></h3>
            <p><?php echo($user['country'].", ".$user['city'])?></p>

        </div>
        <div class="center">
            <div class="about">
                <h2><?php echo($user['fullName'])?></h2>
                <h3><?php echo($user['specialization']." (".$role['role'].")")?></h3>
                <p style="padding-right: 20px;"><?php echo($user['about'])?></p>
            </div>
        </div>
        <div class="right">
            <form action="/components/user/changeUser.php" method="GET">
                <input type="hidden" value="<?= $user['id']?>" name ="id">
                <button name="changeUser"><img src="icons/setting.svg" alt=""> Изменить профиль</button>
            </form>
            <form action="/components/user/changePassword.php" method="GET">
                <input type="hidden" value="<?= $user['id']?>" name ="id">
                <button name="changePassword"><img src="icons/setting.svg" alt=""> Изменить пароль</button>
            </form> 
        </div>
    </div>
    <div class="vacancy">
        <a href="createVacancy.php"> <img src="icons/add-circle.svg"> Cоздать вакансию</a>
        <div class="vacancyForms">
        <?php
        $id = $user['id'];
        $vacancys = $core->query("SELECT * FROM `vacancy` WHERE `id_user` = '{$id}'");
            if($vacancys->num_rows > 0){
                while($vacancy = $vacancys->fetch_assoc()){?>
                
                    <form action="/components/action/vacancy.php" class="created" method="GET">
                        <input type="hidden" name="id" value="<?= $vacancy['id']?>">
                        <div class="photo">
                            <img src="img/createVacancyPhoto/<?= $vacancy['photo']?>">
                        </div>
                        <button name="delete"><img src="icons/minus-cirlce.svg"></button>
                        <button name="update" style="margin-left: 210px;"><img src="icons/setting.svg"></button>
                        <h3><?= $vacancy['name']?></h3>
                        <h2><?= $vacancy['price']?> ₽</h2>
                    </form>

                <?php
            }} else { ?>
                <p>У вас нет ни одной вакансий</p>
            <?php
            }
        ?>
        </div>
    </div>
</div>

</main>

<?php
include "components/footer.php"
?>
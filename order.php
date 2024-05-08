<?php
include "components/header.php";

if(isset($_POST['call'])){
    $result=$core->query("UPDATE `response` SET `id_status`= '3' WHERE `id` = '{$_POST['id']}'");
}

if(isset($_POST['cancel'])){
    $result=$core->query("UPDATE `response` SET `id_status`= '4' WHERE `id` = '{$_POST['id']}'");
}
?>

<main>
    <div class="order-button">
        <button onclick="incoming()">Входящие</button>
        <button onclick="outgoing()">Исходящие</button>
    </div>
    <div class="blocks">
        <div class="outgoing" id="outgoing">
            <h1>Входящие заказы</h1>
            <?php
            $responses= $core->query("SELECT * FROM `response` WHERE `id_user_sender` = '{$_SESSION['user']['id']}'");
            if($responses->num_rows > 0){
                ?>
            <div class="table">
                <p style="margin-right: 183px">Отклик к</p>
                <p style="margin-right: 200px">На вакансию</p>
                <p>Статус</p>
            </div>
                <?php
                while($response = $responses->fetch_assoc()){
                    $vacancys = $core->query("SELECT * FROM `vacancy` WHERE `id` = '{$response['id_vacancy']}'");
                    $vacancy = $vacancys->fetch_assoc(); 
                    $senders = $core->query("SELECT * FROM `users` WHERE `id` = '{$response['id_user_recipient']}'");
                    $sender = $senders->fetch_assoc();
                    $statuss = $core->query("SELECT * FROM `status` WHERE `id` = '{$response['id_status']}'");
                    $status = $statuss->fetch_assoc();
                ?>
                <form action="order.php" class="order" method="post">
                    <input type="hidden" name="id" value="<?=$response['id']?>">
                    <p style="width: 250px"><?= $sender['fullName']?></p>
                    <p style="width: 300px;" ><?= $vacancy['name'] ?></p>
                    <p style="width: 150px"><?= $status['status'] ?></p>
                    <?php
                    if($response['id_status']<3){
                    ?>
                    <button name="cancel" style="margin-left: 100px"><img src="/icons/trash.svg"></button>
                    <?php } else {}?>
                </form>
            <?php }} else {?>
                <p>У вас нет входящих заказов</p>
                <?php }?>
        </div>

        <div class="incoming" id="incoming">
            <h1>Входящие заказы</h1>
            <?php
            $responses= $core->query("SELECT * FROM `response` WHERE `id_user_recipient` = '{$_SESSION['user']['id']}'");
            if($responses->num_rows > 0){?>
            <div class="table">
                <p style="margin-right: 175px">Отклик от</p>
                <p style="margin-right: 200px">На вакансию</p>
                <p>Статус</p>
            </div>
            <?php
                while($response = $responses->fetch_assoc()){
                    $vacancys = $core->query("SELECT * FROM `vacancy` WHERE `id` = '{$response['id_vacancy']}'");
                    $vacancy = $vacancys->fetch_assoc(); 
                    $senders = $core->query("SELECT * FROM `users` WHERE `id` = '{$response['id_user_sender']}'");
                    $sender = $senders->fetch_assoc();
                    $statuss = $core->query("SELECT * FROM `status` WHERE `id` = '{$response['id_status']}'");
                    $status = $statuss->fetch_assoc();
                ?>
                <form action="order.php" class="order" method="post">
                    <input type="hidden" name="id" value="<?=$response['id']?>">
                    <p style="width: 250px"><?= $sender['fullName']?></p>
                    <p style="width: 300px;" ><?= $vacancy['name'] ?></p>
                    <p style="width: 150px"><?= $status['status'] ?></p>
                    <?php
                    if($response['id_status']<3){
                    ?>
                    <button name="call" style="margin-right: 20px">Выполнить</button>
                    <button name="cancel" class="cancel"><img src="/icons/trash.svg"></button>
                    <?php } else {}?>
                </form>
            <?php }} else {?>
                <p>У вас нет исходящих заказов</p>
                <?php }?>
        </div>
    </div>
</main>

<?php
include "components/footer.php"
?>
<?php
include "../header.php";

if(!isset($_SESSION['user'])){
    header("Location: index.php");
}

if(isset($_GET['delete'])){
    $delete = $core->query("DELETE FROM `vacancy` WHERE `id` = '{$_GET['id']}'");
    header("Location: ../../user.php");
}

if(isset($_GET['update'])){
    $vacancys = $core->query("SELECT * FROM `vacancy` WHERE `id` = '{$_GET['id']}'");
    $vacancy = $vacancys->fetch_assoc();
    $categorys = $core->query("SELECT * FROM `category`");
}

if(isset($_POST['vacancy'])){
    $img = uniqid().'.'.substr($_FILES['photo']['type'], 6);
    $update = $core->query("UPDATE `vacancy` SET `name` = '{$_POST['name']}', `id_category` = '{$_POST['category']}' , `description` = '{$_POST['description']}', `photo` = '$img', `price` = '{$_POST['price']}' WHERE `id` = '{$_POST['id']}'");
    move_uploaded_file($_FILES['photo']['tmp_name'],"../../img/createVacancyPhoto/".$img);
    header("Location: ../../user.php");
}

if(isset($_GET['response'])){
    $results = $core->query("SELECT * FROM `response` WHERE `id_user_sender` = '{$_SESSION['user']['id']}' AND `id_vacancy` = '{$_GET['id']}'");
    if($results->num_rows > 0){
        echo "<script>alert('Вы уже оставляли отклик на эту вакансию'); location.href = '/vacancy.php';</script>";

    }
    else{
        $response = $core->query("INSERT INTO `response`(`id_user_sender`, `id_user_recipient`, `id_status`, `id_vacancy`) VALUES ('{$_SESSION['user']['id']}', '{$_GET['id_user']}', '1', '{$_GET['id']}')");
        header("Location: /order.php");
    }
}

?>

<main>
    <h1 style="text-align: center; margin-top: 20px ">Изменение вакансии</h1>
    <a href="/user.php" class="back"> < Вернуться</a>
    <form action="vacancy.php" method="post" class="create" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $vacancy['id']?>">
        <select name="category">
            <?php
            while($category = $categorys->fetch_assoc()){?>
            <option value="<?= $category['id']?>"><?= $category['category']?></option>
            <?php } ?>
        </select>
        <input type="text" name="name" placeholder="Название" required value="<?= $vacancy['name']?>">
        <textarea name="description" required placeholder="Описание" cols="30" rows="10"><?= $vacancy['description']?></textarea>
        <label for="photo">Добавить изображение</label>
        <input type="file" name="photo" style="border: none;" value="<?= $vacancy['photo']?>">
        <input type="text" name="price" placeholder="Цена" required value="<?= $vacancy['price']?>">
        <button name="vacancy">Изменить</button>
    </form>
</main>


<?php
include "../footer.php"
?>
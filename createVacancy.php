<?php
include "components/header.php";

if(!isset($_SESSION['user'])){
    header("Location: index.php");
}

if(isset($_POST['create'])){
    $id = $_SESSION['user']['id'];
    $img = uniqid().'.'.substr($_FILES['image']['type'], 6);
    $create = $core->query("INSERT INTO `vacancy`(`id_user`, `id_category`, `name`, `description`, `photo`, `price`) VALUES ('$id', '{$_POST['category']}', '{$_POST['name']}', '{$_POST['description']}', '$img', '{$_POST['price']}')");
    move_uploaded_file($_FILES['image']['tmp_name'],"img/createVacancyPhoto/".$img);
    header("Location: user.php");
}

?>

<main>
    <h1 style="text-align: center; margin-top: 20px ">Создание вакансии</h1>
    <a href="user.php" class="back"> < Вернуться</a>
    <form action="createVacancy.php" method="POST" class="create" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Название" required>
        <select name="category">
            <?php
            $categorys = $core->query("SELECT * FROM `category`");
            while($category = $categorys->fetch_assoc()){?>
            <option value="<?= $category['id']?>"><?= $category['category']?></option>
            <?php } ?>
        </select>
        <textarea name="description" required placeholder="Описание" cols="30" rows="10"></textarea>
        <label for="img">Добавить изображение</label>
        <input type="file" name="image"  style="border: none;">
        <input type="text" name="price" placeholder="Цена" required>
        <button name="create">Создать</button>
    </form>
</main>

<?php
include "components/footer.php"
?>
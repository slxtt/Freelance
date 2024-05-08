<?php
    include "../header.php";

    $categorys = $core->query("SELECT * FROM `category`");

    if(isset($_POST['gosearch'])){
        $searchText = $_POST['search'];
        $search = $core->query("SELECT * FROM `vacancy` WHERE `name` LIKE '%$searchText%' OR `description` LIKE '%$searchText%'");
    }

?>

<main>
    <h1 style="text-align: center; margin-top: 20px">Результат поиска</h1>
    <form action="/components/freelance/search.php" method="POST" class="search">
        <input type="text" placeholder="Поиск" name="search">
        <button name="gosearch"><img src="/icons/search-normal.svg"></button>
    </form>
    <div class="works">
        <div class="worksLeft">
            <h2>Категории</h2>
            <?php
            while($category = $categorys->fetch_assoc()){?>
                <form action="category.php" method="GET">
                    <input type="hidden" value="<?=$category['id']?>" name="id_category">
                    <button name="category"><?=$category['category']?></button>
                </form>
            <?php }?>
        </div>
        <div class="worksRight">
            <?php
            if($search->num_rows > 0){
                while($result = $search->fetch_assoc()){
                ?>
                    <form action="/components/action/vacancy.php" class="postWork" method="get">
                        <input type="hidden" value="<?=$result['id']?>" name="id">
                        <input type="hidden" value="<?=$result['id_user']?>" name="id_user">
                        <div class="img">
                            <img src="/img/createVacancyPhoto/<?=$result['photo']?>">
                        </div>
                        <div class="description">
                        <h3><?=$result['name']?></h3>
                        <div class="line"></div>
                        <p><?=$result['description']?></p>
                        <h2><?=$result['price']?> ₽</h2>
                        </div>
                        <?php
                        if(!isset($_SESSION['user'])){
                            ?><?php
                        }
                        elseif($result['id_user'] == $_SESSION['user']['id']){
                            ?> <button name="update">Изменить</button> <?php
                        } else {
                        ?>
                        <button name="response">Отклик</button> <?php } ?>
                    </form>

                <?php }} else{
                    ?><p>По вашему запросу ничего не найдено</p>
                <?php } ?>
        </div>
    </div>
</main>


<?php
include "../footer.php"
?>
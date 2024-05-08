<?php
include "components/header.php";

$categorys = $core->query("SELECT * FROM `category`");

?>

<main>
    <h1 style="text-align: center; margin-top: 20px">Найди работу легко!</h1>
    <form action="components/works/search.php" method="POST" class="search">
        <input type="text" placeholder="Поиск" name="search">
        <button name="gosearch"><img src="icons/search-normal.svg"></button>
    </form>
    <div class="block">
        <?php
        while($category = $categorys->fetch_assoc()){ ?>
            <form action="/components/works/category.php"  method="get">
                <div class="blockLink">
                <input type="hidden" value="2" name="role">
                <input type="hidden" value="<?=$category['id']?>" name="id_category">
                <img src="img/category/<?=$category['img']?>">
                <button name="category"><?=$category['category']?></button>
                </div>
            </form>
            <?php } ?>
            </div>
</main>

<?php
include "components/footer.php"
?>
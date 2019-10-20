<?php


use AppCirque\core\DATE\gestion_dates;
use AppCirque\core\HELPERS\Finder;
use AppCirque\core\PDO\MY_SQL_PDO;

require '../../vendor/autoload.php';

$image = [];

session_start();

$path_images = $_GET['ID'];

if (!empty($_POST)){

    $date = new gestion_dates();
    $date = $date->day_date_words(' ');

    $imagine = new Imagine\Gd\Imagine();
    $size_small  = new Imagine\Image\Box(350 , 200);
    $HQ = new Imagine\Image\Box(1280 , 720);

    if (!empty($_FILES['headline-pic']['tmp_name'])){

        if (!mkdir($concurrentDirectory = 'miniatures/' . $path_images, 0777, true) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        if (!mkdir($concurrentDirectory = 'HQ/' . $path_images, 0777, true) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        $imagine->open($_FILES['headline-pic']['tmp_name'])
                ->thumbnail($HQ, 'inset')
                ->save("HQ/$path_images/mise_en_avant.png")
                ->thumbnail($size_small, 'inset')
                ->save("miniatures/$path_images/mise_en_avant.png");
    } else {

        $path = Finder::Path_Finder('ajax', 'HQ/default');

        if (!mkdir($concurrentDirectory = 'miniatures/' . $path_images, 0777, true) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        if (!mkdir($concurrentDirectory = 'HQ/' . $path_images, 0777, true) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        if (!is_file("miniatures/$path_images/mise_en_avant.png")){
            $imagine->open("$path/mise_en_avant.png")
                ->thumbnail($HQ, 'inset')
                ->save("HQ/$path_images/mise_en_avant.png")
                ->thumbnail($size_small, 'inset')
                ->save("miniatures/$path_images/mise_en_avant.png");
        }
    }

    $pdo = MY_SQL_PDO::start();

    $title = $_POST['title'];
    $headline = $_POST['headline'];
    $content = htmlentities($_POST['content']);
    $path = $_POST['dir_photo_name'];
    $category = $_POST['category'];
    $x = '';

    if (empty($headline)) {
        $y = substr($content, 0, 150);
        $headline = $y.'(...)';
    }

    try{
        $select = $pdo->query("SELECT images_path FROM articles WHERE images_path= '$path_images'");
        $x = $select->fetchAll();
    } catch (PDOException $e){}

    if (empty($x)){

        $req = $pdo->prepare("INSERT INTO articles SET title= ?, headline= ?, content= ?, images_path= ?, category= ?, date= ?");
        $req->execute([$title, $headline, $content, $path ,$category, $date]);
        $_SESSION['addarticles'] = 'Votre article a bien été ajouté';

    } else {

        $req = $pdo->prepare("UPDATE articles SET title= ?, headline= ?, content= ?, images_path= ?, category= ?, date= ? WHERE images_path= '$path_images'");
        $req->execute([$title, $headline, $content, $path ,$category, $date]);
        $_SESSION['addarticles'] = 'Votre article a bien été Modifié';
    }


    header('location: /src/admin/index.php?admin=addarticle');

}

if(isset($_FILES['drop_name'])){

    if (!mkdir($concurrentDirectory = 'miniatures/' . $_GET['ID'], 0777, true) && !is_dir($concurrentDirectory)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
    }
    if (!mkdir($concurrentDirectory = 'HQ/' . $path_images, 0777, true) && !is_dir($concurrentDirectory)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
    }

    $imagine = new Imagine\Gd\Imagine();
    $size_small  = new Imagine\Image\Box(350 , 200);
    $HQ = new Imagine\Image\Box(1280 , 720);

    $path = $_FILES['drop_name']['name'];
    $path_image = "miniatures/$path_images/$path";

    $image ['image']= $path_image;


    $imagine->open($_FILES['drop_name']['tmp_name'])
            ->thumbnail($HQ, 'inset')
            ->save("HQ/$path_images/$path")
            ->thumbnail($size_small, 'outbound')
            ->save("miniatures/$path_images/$path");
}

echo json_encode($image);

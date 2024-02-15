<?php 
include "../../include/layout/header.php";


$categories = $db->query("SELECT * FROM categories");

$invalidInputTitle = '';
$invalidInputAutor = '';
$invalidInputImage = '';
$invalidInputBody = '';

if(isset($_POST['addPost'])){
    if(empty(trim($_POST['title']))){
       
        $invalidInputTitle = "È obbligatorio compilare il campo!";
    }if(empty(trim($_POST['autor']))){
       
        $invalidInputAutor = "È obbligatorio compilare il campo!";
    }if(empty(trim($_FILES['image']['name']))){
       
        $invalidInputImage = "È obbligatorio selezionare una foto!";
    }if(empty(trim($_POST['body']))){
       
        $invalidInputBody = "È obbligatorio scrivere un testo!";
    } if(!empty(trim($_POST['title'])) && !empty(trim($_POST['autor'])) && !empty(trim($_FILES['image']['name'])) && !empty(trim($_POST['body']))){
        $title = $_POST['title'];
        $autor = $_POST['autor'];
        $body = $_POST['body'];
        $categoryId = $_POST['categoryId'];

        $nameImage = time() . "_" . $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];

       if (move_uploaded_file($tmpName, "../../../uploads/posts/$nameImage")){
        $postInsert = $db->prepare("INSERT INTO posts (title, autor, category_id, body, image) VALUES (:title, :autor, :category_id, :body, :image)");
        $postInsert->execute(['title' => $title, 'autor' => $autor, 'category_id' => $categoryId, 'body' => $body, 'image' => $nameImage]);

        header("Location:index.php");
        exit();
       } else {
        echo "Upload Error";
       }
    }
}
?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Section -->
                <?php 
                include "../../include/layout/sidebar.php"
                ?>

                <!-- Main Section -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
                    >
                        <h1 class="fs-3 fw-bold">Creare nuovo post</h1>
                    </div>

                    <!-- Crea Posts -->
                    <div class="mt-4">
                        <form method="post" class="row g-4" enctype="multipart/form-data">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">Titolo</label>
                                <input type="text" name="title" class="form-control" />
                                <div class="form-text text-danger"><?= $invalidInputTitle ?></div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">Autore</label>
                                <input type="text"  name="autor" class="form-control" />
                                <div class="form-text text-danger"><?= $invalidInputAutor ?></div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label"
                                    >Categorie</label
                                >
                                <select name="categoryId" class="form-select">
                                <?php if ($categories->rowCount() > 0) : ?>
                                   <?php foreach($categories as $category) :?>
                                   <option value="<?= $category['id']?>"><?= $category['title']?></option>
                                 <?php endforeach ?>
                                <?php endif ?>

                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="formFile" class="form-label"
                                    >Foto</label
                                >
                                <input class="form-control" name="image" type="file" />
                                <div class="form-text text-danger"><?= $invalidInputImage ?></div>
                            </div>

                            <div class="col-12">
                                <label for="formFile" class="form-label"
                                    >Il testo</label
                                >
                                <textarea
                                    class="form-control" name="body"
                                    rows="6"
                                ></textarea>
                                <div class="form-text text-danger"><?= $invalidInputBody ?></div>
                            </div>

                            <div class="col-12">
                                <button type="submit" name="addPost" class="btn btn-primary">
                                     Crea
                                </button>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>

        <?php 
                include "../../include/layout/footer.php"
                ?>

<?php 
include "./include/layout/header.php";

if(isset($_GET['entity']) && isset($_GET['action']) && isset($_GET['id'])){
    $entity = $_GET['entity'];
    $action = $_GET['action'];
    $id = $_GET['id'];


    if($action == "delete"){
        
     switch($entity){
        case "post":
            $query = $db->prepare('DELETE FROM posts WHERE id= :id');
            break;
        case "comment":
            $query = $db->prepare('DELETE FROM comments WHERE id= :id');
            break;
        case "category":
            $query = $db->prepare('DELETE FROM categories WHERE id= :id');
            break;
    } 
    }elseif($action == "approve"){
        $query = $db->prepare("UPDATE comments SET status  = '1' WHERE id= :id");
    }
    $query->execute(['id' => $id]);

}

$posts = $db->query("SELECT * FROM posts ORDER BY id DESC LIMIT 5");
$comments = $db->query("SELECT * FROM comments ORDER BY id DESC LIMIT 5");
$categories = $db->query("SELECT * FROM categories ORDER BY id DESC");

// echo "<pre>";
// print_r($posts->fetchAll());
?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Section -->
                <?php 
                include "./include/layout/sidebar.php"
                ?>
                <!-- Main Section -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
                    >
                        <h1 class="fs-3 fw-bold">Dashboard</h1>
                    </div>

                    <!-- Recently Posts -->
                    <div class="mt-4">
                        <h4 class="text-secondary fw-bold">l'ultimi post</h4>
                        <?php if ($posts->rowCount() > 0) : ?>
                        <div class="table-responsive small">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>titolo</th>
                                        <th>autore</th>
                                        <th>l'operazioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach($posts as $post) :
                                    ?>
                                    <tr>
                                        <th><?= $post['id']?></th>
                                        <td><?= $post['title']?></td>
                                        <td><?= $post['autor']?></td>
                                        <td>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-dark"
                                                >modifica</a
                                            >
                                            <a href="index.php?entity=post&action=delete&id=<?= $post['id']?>"
                                              class="btn btn-sm btn-outline-danger"
                                            >elimina</a>

                                        </td>
                                    </tr>
                                  <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else : ?>
                            <div class="col">
                                <div class="alert alert-danger">
                                    non è stato trovato alcun post...!!!

                                </div>
                            </div>
                            <?php endif?>
                    </div>

                    <!-- Recently Comments -->
                    <div class="mt-4">
                        <h4 class="text-secondary fw-bold">l'ultimi commenti</h4>
                        <?php if ($comments->rowCount() > 0) : ?>
                        <div class="table-responsive small">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Nome</th>
                                        <th>il commento</th>
                                        <th>l'operazioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    foreach($comments as $comment) :
                                    ?>
                                    <tr>
                                        <th><?= $comment['id']?></th>
                                        <td><?= $comment['name']?></td></td>
                                        <td><?= $comment['comment']?> </td>
                                        <td>
                                            <?php if($comment['status']):?>
                                            <a
                                                class="btn btn-sm btn-outline-success"
                                                >Accetata</a
                                            >
                                            <?php else: ?>
                                            <a
                                                href="index.php?entity=comment&action=approve&id=<?= $comment['id']?>"
                                                class="btn btn-sm btn-outline-info"
                                                >Attesa</a
                                            >
                                            <?php endif ?>
                                            <a
                                                href="index.php?entity=comment&action=delete&id=<?= $comment['id']?>"
                                                class="btn btn-sm btn-outline-danger"
                                                >Elimina</a
                                            >
                                        </td>
                                    </tr>
                                   <?php endforeach?>
                                </tbody>
                            </table>
                        </div>
                        <?php else : ?>
                            <div class="col">
                                <div class="alert alert-danger">
                                    non è stato trovato alcuni commenti...!!!

                                </div>
                            </div>
                            <?php endif?>
                    </div>
                     
                    <!-- Categories -->
                    <div class="mt-4">
                        <h4 class="text-secondary fw-bold">categorie</h4>
                        <?php if ($categories->rowCount() > 0) : ?>
                        <div class="table-responsive small">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>titolo</th>
                                        <th>l'operazioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    foreach($categories as $category) :
                                    ?>
                                    <tr>
                                        <th><?= $category['id']?></th>
                                        <td><?= $category['title']?></td>
                                        <td>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-dark"
                                                >Modifica</a
                                            >
                                            <a href="index.php?entity=category&action=delete&id=<?= $category['id']?>"
                                               class="btn btn-sm btn-outline-danger"
                                            >Elimina</a>

                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else : ?>
                            <div class="col">
                                <div class="alert alert-danger">
                                    non è stato trovato alcuni categorie...!!!

                                </div>
                            </div>
                            <?php endif?>
                    </div>
                </main>
            </div>
        </div>
  <!-- footer -->
               <?php 
                include "./include/layout/footer.php"
                ?>
      
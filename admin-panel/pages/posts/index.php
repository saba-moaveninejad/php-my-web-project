<?php 
include "../../include/layout/header.php";

$posts = $db->query("SELECT * FROM posts ORDER BY id DESC");


if(isset($_GET['action']) && isset($_GET['id'])){
    $id = $_GET['id'];
    $query = $db->prepare('DELETE FROM posts WHERE id = :id');

    $query->execute(['id' => $id]);
    
    header("Location:index.php");
    exit();
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
                        <h1 class="fs-3 fw-bold">Posts</h1>

                        <div class="btn-toolbar mb-2 mb-md-0">
                            <a href="./create.php" class="btn btn-sm btn-primary">
                                creare nuovo post
                            </a>
                        </div>
                    </div>

                     <!-- Posts -->
                     <div class="mt-4">
                     <?php if ($posts->rowCount() > 0) : ?>
                        <div class="table-responsive small">
                            <table class="table table-hover align-middle">
                                 <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Titolo</th>
                                        <th>Autore</th>
                                        <th>L'operazioni</th>
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
                                                href="./edit.html"
                                                class="btn btn-sm btn-outline-dark"
                                                >Modifica</a
                                            >
                                            <a href="index.php?action=delete&id=<?= $post['id']?>"
                                                class="btn btn-sm btn-outline-danger"
                                            >Elimina</a>

                                        </td>
                                    </tr>
                                   <?php endforeach?>
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
                </main>
            </div>
        </div>

                <?php 
                include "../../include/layout/footer.php"
                ?>

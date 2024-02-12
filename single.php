<?php
include "./include/layout/header.php";

if(isset($_GET['post'])){
    $postId = $_GET['post'];
    $post = $db->prepare("SELECT * FROM posts WHERE id = :id ORDER BY id");
    $post->execute(['id' => $postId]);
    $post = $post->fetch();
 }

?>
<main>
    <!-- Content -->
    <section class="mt-4">
        <div class="row">
            <!-- Posts & Comments Content -->
            <?php if(empty($post)): ?>
                <div class="col-lg-8">
                    <div class="alert alert-danger">
                    L'articolo cercato non è stato trovato!!!
                    </div>
                </div>
                <?php else: ?>
            <div class="col-lg-8">
                <div class="row justify-content-center">

                <?php  
                    $categoryId = $post['category_id'];
                    $postCategory = $db->query("SELECT * FROM categories WHERE id = $categoryId")->fetch();
                ?>
                    <!-- Post Section -->
                    <div class="col">
                        <div class="card">
                            <img src="./uploads/posts/<?= $post['image'] ?>" class="card-img-top" alt="post-image" />
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title fw-bold">
                                    <?= $post['title'] ?>
                                    </h5>
                                    <div>
                                        <span class="badge text-bg-secondary"><?= $postCategory['title'] ?></span>
                                    </div>
                                </div>
                                <p class="card-text text-secondary text-justify pt-3">
                                <?= $post['body'] ?>
                                </p>
                                <div>
                                    <p class="fs-6 mt-5 mb-0">
                                        scritta: <?= $post['autor'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="mt-4" />

                    <!-- Comment Section -->
                    <div class="col">

                        <?php 
                        $invalidInputName = '';
                        $invalidInputComment = '';
                        $message = '';
                        if(isset($_POST['submitComment'])){
                            if(empty(trim($_POST['name']))){
                                $invalidInputName = "È obbligatorio compilare il campo!";
                            }
                            elseif(empty(trim($_POST['comment']))){
                                $invalidInputComment = "È obbligatorio scrivere un commento!";
                            } else{
                                $name = $_POST['name'];
                                $comment = $_POST['comment'];

                                $commentInsert = $db->prepare("INSERT INTO comments(name, comment, post_id) VALUES (:name, :comment, :post_id)");
                                $commentInsert->execute(['name' => $name, 'comment' => $comment, 'post_id' => $postId]);

                                $message = "Il suo messaggio è stato inviato e sarà attivo dopo una verifica.";
                            }
                        }
                        ?>
                    
                        <!-- Comment Form -->
                        <div class="card">
                            <div class="card-body">
                                <p class="fw-bold fs-5">
                                    Invia un commento
                                </p>

                                <form method="POST">
                                    <div class="text-success"><?= $message ?></div>
                                    <div class="mb-3">
                                        <label class="form-label">Nome</label>
                                        <input type="text" name="name" class="form-control" />
                                        <div class="form-text text-danger"><?= $invalidInputName ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Commento</label>
                                        <textarea class="form-control" name="comment" rows="3"></textarea>
                                        <div class="form-text text-danger"><?= $invalidInputComment ?></div>
                                    </div>
                                    <button type="submit" name="submitComment" class="btn btn-dark">
                                        Invia
                                    </button>
                                </form>
                            </div>
                        </div>

                        <hr class="mt-4" />

                        <?php
                        $postId = $post['id']; 
                        $comments = $db->prepare("SELECT * FROM comments WHERE post_id = :id AND status = '1' ");
                        $comments->execute(['id' => $postId]);
                        ?>
                        <!-- Comment Content -->
                        <p class="fw-bold fs-6">Numeri di commenti : <?= $comments->rowCount() ?></p>
                        <?php if($comments->rowCount() > 0) : ?>
                        <?php foreach($comments as $comment) :
                        ?>
                          <div class="card bg-light-subtle mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <img src="./assets/images/profile.png" width="45" height="45" alt="user-profle" />

                                    <h5 class="card-title me-2 mb-0">
                                    <?= $comment['name'] ?>
                                    </h5>
                                </div>

                                <p class="card-text pt-3 pr-3">
                                <?= $comment['comment'] ?>
                                </p>
                            </div>
                          </div>
                        <?php endforeach ?>
                        <?php else : ?>
                            <div class="alert alert-danger">
                                   Non è stato trovato nessun commento per questo articolo
                                    </div>
                                    <?php endif ?>
                    </div>
                </div>
            </div>
            <?php endif?>

            <?php 
                include "./include/layout/sidebar.php"
             ?>
        </div>
    </section>
</main>

<?php
include "./include/layout/footer.php"
?>
 <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
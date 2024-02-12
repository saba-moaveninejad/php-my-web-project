<?php 

$query = "SELECT * FROM categories";
$categories = $db-> query($query);


?>

<!-- Sidebar Section -->
<div dir="ltr" class="col-lg-4">
                            <!-- Search Section -->
                            <!-- <div class="card">
                                <div class="card-body">
                                    <p class="fw-bold fs-6">Cerca</p>
                                    <form action="search.html">
                                        <div class="input-group mb-3">
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Cerca..."
                                            />
                                            <button
                                                class="btn btn-secondary"
                                                type="submit"
                                            >
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div> -->
                            <!-- <div class="card">
                                <div class="card-body">
                                    <p class="fw-bold fs-6">Cerca</p>
                                    <form action="search.php" method="GET">
                                    <input type="text" name="search" class="form-control" placeholder="Search.." name="search">
                                    <button class="btn btn-secondary" type="submit"><i class="bi bi-search"></i></button>
                                    </form>
                                    
                                </div>
                            </div> -->


                            <!-- Search Section -->
                            <!-- <div class="card">
                                <div class="card-body">
                                    <p class="fw-bold fs-6">Cerca</p>
                                    <form action="search.php">
                                        <div class="col-md-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Cerca..."
                                                aria-label="carca" aria-describedby="button-addon2"
                                            />
                                            <button
                                                class="btn btn-primary"
                                                type="submit"
                                              
                                            >
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>  -->
                            <div class="card">
                                <div class="card-body">
                                    <p class="fw-bold fs-6">Cerca</p>
                                    <form action="search.php" method="GET">
                                    <div class=" d-inline-flex mb-3" style="width: 21rem;">
                                      <input type="text" name="search" class="form-control" placeholder="Search..." name="search">
                                      <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i>
                                      </button>
                                    </div>
                                    </form>
                                    
                                </div>
                            </div>


                            
                            <!-- Categories Section -->
                            <div class="card mt-4">
                                <div class="fw-bold fs-6 card-header">Categorie</div>
                                <ul class="list-group list-group-flush p-0">
                                <?php if($categories->rowCount() > 0) : ?>
                                <?php foreach($categories as $category): ?> 
                                    <li class="list-group-item">
                                        <a
                                            class="link-body-emphasis text-decoration-none"
                                            href="index.php?category=<?= $category['id'] ?>"
                                            ><?= $category['title'] ?></a
                                        >
                                    </li>
                                    <?php endforeach ?>
                                    <?php endif ?>
                                </ul>
                            </div>

                            <!-- Subscribue Section -->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <p class="fw-bold fs-6">Novità e notizie</p>

                                    <?php 
                                    $invalidInputName = '';
                                    $invalidInputEmail = '';
                                    $message = '';
                                    if(isset($_POST['subscribe'])){
                                        if(empty(trim($_POST['name']))){
                                            $invalidInputName = "È obbligatorio compilare il campo!";
                                        }
                                        elseif(empty(trim($_POST['email']))){
                                            $invalidInputEmail = "È obbligatorio compilare il campo!";
                                        } else{
                                            $name = $_POST['name'];
                                            $email = $_POST['email'];

                                            $subscribeInsert = $db->prepare("INSERT INTO subscribers(name, email) VALUES (:name, :email)");
                                            $subscribeInsert->execute(['name' => $name, 'email' => $email]);

                                            $message = "sei stato registrato";
                                        }
                                    }
                                    ?>
                                    <div class="text-success"><?= $message ?></div>
                                    <form method="POST">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >Nome</label
                                            >
                                            <input
                                                type="text"
                                                name = "name"
                                                class="form-control"
                                            />
                                            <div class="form-text text-danger"><?= $invalidInputName ?></div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >Email</label
                                            >
                                            <input
                                                type="email"
                                                name = "email"
                                                class="form-control"
                                            />
                                            <div class="form-text text-danger"><?= $invalidInputEmail ?></div>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button
                                                type="submit"
                                                name = "subscribe"
                                                class="btn btn-secondary"
                                            >
                                               Invia
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- About Section -->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <p class="fw-bold fs-6">Noi</p>
                                    <p class="text-justify">
                                        La nostra missione è ispirare e connettere le
                                         persone alla natura, offrendo informazioni dettagliate
                                          su destinazioni turistiche affascinanti e risorse utili 
                                          per coloro che cercano esperienze autentiche.
                                           Attraverso storie coinvolgenti, guide dettagliate e 
                                           immagini mozzafiato, vogliamo alimentare la vostra
                                            passione per l'esplorazione e fornirvi l'ispirazione 
                                            necessaria per pianificare le vostre prossime avventure. 
                                            Unisciti a noi nel viaggio verso la scoperta della bellezza 
                                            del mondo naturale!
                                    </p>
                                </div>
                            </div>
                        </div>
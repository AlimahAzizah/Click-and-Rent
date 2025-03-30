<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Inscription à Click&Rent</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <form action="../public/index.php?action=register" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required 
                                           pattern="[A-Za-zÀ-ÿ\s\-]{2,50}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" required 
                                           pattern="[A-Za-zÀ-ÿ\s\-]{2,50}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Adresse Email</label>
                            <input type="email" class="form-control" id="email" name="email" required 
                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password" required 
                                           minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                                    <small class="form-text text-muted">
                                        8 caractères minimum avec majuscule, minuscule et chiffre
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirm">Confirmation</label>
                                    <input type="password" class="form-control" id="password_confirm" 
                                           name="password_confirm" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">S'inscrire</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="../public/index.php?action=showLogin" class="text-secondary">Déjà inscrit ? Connectez-vous</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
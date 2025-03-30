<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Connexion à Click&Rent</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <form action="../public/index.php?action=login" method="POST">
                        <div class="form-group">
                            <label for="email">Adresse Email</label>
                            <input type="email" class="form-control" id="email" name="email" required 
                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required 
                                   minlength="8">
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                            <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="/password-reset" class="text-secondary">Mot de passe oublié ?</a>
                        <span class="mx-2">|</span>
                        <a href="../public/index.php?page=register" class="text-secondary">Créer un compte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
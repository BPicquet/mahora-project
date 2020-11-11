<section class="login-page">
    <div class="login">
        <h2>Connexion</h2>

        <form action="index.php?action=connexion" method="post">
            <input type="text" name="login" placeholder="Pseudo" required="" autofocus="" />
            <input type="password" name="mdp" placeholder="Password" required="" autofocus="" />
            <button class="all-button button-login" type="submit">Se connecter</button>
        </form>
    </div>

    <img src="./style/img/logo-mahora.png" alt="">

    <div class="register">
        <h2>Inscription</h2>

        <form action="index.php?action=register" method="post">
            <input type="text" name="login" placeholder="Pseudo" required="" autofocus="" />
            <input type="text" name="email" placeholder="Email" required="" autofocus="" />
            <input type="password" name="mdp" placeholder="Password" required="" autofocus="" />
            <input type="password" name="cmdp" placeholder="Confirm password" required="" autofocus="" />
            <button class="all-button button-login" name="formsendregister" type="submit">S'inscrire</button>
        </form>
    </div>
</section>
    
<div>
    <h2>Connexion</h2>
    <form method="POST" action="/login">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">Se connecter</button>
        </div>
    </form>
    <p>Pas de compte ? <a href="/register">S'inscrire</a></p>
</div>

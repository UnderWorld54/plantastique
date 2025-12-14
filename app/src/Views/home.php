<div class="welcome">
    <?php if ($user): ?>
        <h2>Bonjour <?= $this->escape($user['name']) ?></h2>
        <p><a href="/logout">Se déconnecter</a></p>
    <?php else: ?>
        <h2>Bienvenue sur <?= $this->escape($title) ?></h2>
        <p><a href="/login">Se connecter</a> | <a href="/register">S'inscrire</a></p>
    <?php endif; ?>
    <div class="message">
        <p><?= $this->escape($message) ?></p>
    </div>
</div>

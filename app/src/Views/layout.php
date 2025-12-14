<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->escape($title ?? 'Plantastique ') ?></title>
    <link rel="stylesheet" href="public/css/output/output.css">
</head>
<body>
    <div class="container">
        <!-- navbar -->
        <header>
            <h1><?= $this->escape($siteTitle ?? 'Plantastique ') ?></h1>
            <nav>
                <a href="/">Accueil</a>
                <a href="/plants">Plantes</a>
                <a href="/plants/create">Ajouter une plante</a>
                <?php if (Framework\Auth::check()): ?>
                    <a href="/logout">Déconnexion</a>
                <?php else: ?>
                    <a href="/login">Connexion</a>
                    <a href="/register">Inscription</a>
                <?php endif; ?>
            </nav>
        </header>
        
        <main>
            <?= $this->yield('content') ?>
        </main>
        
        <footer>
            <p>&copy; <?= date('Y') ?> Plantastique. Tous droits réservés.</p>
        </footer>
    </div>
</body>
</html>


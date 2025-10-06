<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>
    <div>
        <h1>404</h1>
        <p class="error-message"><?= htmlspecialchars($message) ?></p>
        <a href="/">Retour à l'accueil</a>
    </div>
</body>
</html>


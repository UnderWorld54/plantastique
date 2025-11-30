<?php $this->layout('layout') ?>

<h2>Créer un compte</h2>

<div id="message"></div>

<form id="registerForm">
    <label for="name">Nom complet</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Mot de passe</label>
    <input type="password" id="password" name="password" required minlength="6">

    <button type="submit">S'inscrire</button>
</form>

<script>
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const messageDiv = document.getElementById('message');
    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
    };

    try {
        const response = await fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (response.ok) {
            messageDiv.textContent = data.message;
            document.getElementById('registerForm').reset();
        } else {
            messageDiv.textContent = data.error;
        }
    } catch (error) {
        messageDiv.textContent = 'Erreur de connexion au serveur';
    }
});
</script>

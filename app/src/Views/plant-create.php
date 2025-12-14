<style>
    /** style généré par IA*/
.plant-form {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.plant-form h2 {
    margin-top: 0;
    color: #2d5016;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 3px;
    box-sizing: border-box;
}

.form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.btn {
    padding: 10px 20px;
    background-color: #4a7c2c;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.btn:hover {
    background-color: #3a6222;
}

.back-link {
    display: inline-block;
    margin-top: 15px;
    color: #4a7c2c;
    text-decoration: none;
}

.back-link:hover {
    text-decoration: underline;
}
</style>

<div class="plant-form">
    <h2>Ajouter une nouvelle plante</h2>
    <form method="POST" action="/plants/create">
        <div class="form-group">
            <label for="name">Nom de la plante:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="species">Espèce:</label>
            <input type="text" id="species" name="species" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="image_url">URL de l'image:</label>
            <input type="url" id="image_url" name="image_url" placeholder="https://exemple.com/image.jpg">
        </div>
        <button type="submit" class="btn">Ajouter la plante</button>
    </form>
    <a href="/plants" class="back-link">Retour à la liste</a>
</div>

<style>
    /** style généré par IA*/
.plants-container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
}

.plants-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.plants-header h2 {
    margin: 0;
    color: #2d5016;
}

.add-plant-btn {
    padding: 10px 20px;
    background-color: #4a7c2c;
    color: white;
    text-decoration: none;
    border-radius: 3px;
    display: inline-block;
}

.add-plant-btn:hover {
    background-color: #3a6222;
}

.plants-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.plant-card {
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.plant-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.plant-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background-color: #e8f5e9;
}

.plant-info {
    padding: 15px;
}

.plant-name {
    font-size: 1.3em;
    font-weight: bold;
    margin: 0 0 5px 0;
    color: #2d5016;
}

.plant-species {
    font-style: italic;
    color: #666;
    margin: 0 0 10px 0;
}

.plant-description {
    color: #444;
    margin: 10px 0;
    line-height: 1.4;
}

.plant-owner {
    font-size: 0.9em;
    color: #888;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #eee;
}

.no-plants {
    text-align: center;
    padding: 40px;
    color: #666;
}

.delete-btn {
    padding: 8px 15px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: 0.9em;
    margin-top: 10px;
}

.delete-btn:hover {
    background-color: #c82333;
}
</style>

<div class="plants-container">
    <div class="plants-header">
        <h2><?= $this->escape($title) ?></h2>
        <a href="/plants/create" class="add-plant-btn">+ Ajouter une plante</a>
    </div>

    <?php if (empty($plants)): ?>
        <div class="no-plants">
            <p>Aucune plante .</p>
        </div>
    <?php else: ?>
        <div class="plants-grid">
            <?php foreach ($plants as $plant): ?>
                <div class="plant-card">
                    <?php if (!empty($plant['image_url'])): ?>
                        <img src="<?= $this->escape($plant['image_url']) ?>" alt="<?= $this->escape($plant['name']) ?>" class="plant-image">
                    <?php else: ?>
                        <div class="plant-image" style="display: flex; align-items: center; justify-content: center; color: #999;">
                            Pas d'image
                        </div>
                    <?php endif; ?>

                    <div class="plant-info">
                        <h3 class="plant-name"><?= $this->escape($plant['name']) ?></h3>
                        <p class="plant-species"><?= $this->escape($plant['species']) ?></p>

                        <?php if (!empty($plant['description'])): ?>
                            <p class="plant-description"><?= $this->escape($plant['description']) ?></p>
                        <?php endif; ?>

                        <div class="plant-owner">
                            Ajoutée par <?= $this->escape($plant['owner_name']) ?>
                        </div>

                        <?php if ($current_user_id && $plant['user_id'] == $current_user_id): ?>
                            <form method="POST" action="/plants/delete/<?= $plant['id'] ?>" style="margin-top: 10px;">
                                <button type="submit" class="delete-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette plante ?')">Supprimer</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

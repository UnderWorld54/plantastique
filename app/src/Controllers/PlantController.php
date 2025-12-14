<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Database;
use Framework\Auth;

class PlantController extends Controller
{
    public function list()
    {
        $plants = Database::query("
            SELECT p.*, u.name as owner_name
            FROM plants p
            JOIN users u ON p.user_id = u.id
            ORDER BY p.created_at DESC
        ");

        return $this->viewWithLayout('plants', [
            'title' => "Liste des plantes",
            'siteTitle' => 'Plantastique - Liste des plantes',
            'plants' => $plants ?: [],
            'current_user_id' => Auth::id()
        ]);
    }

    public function showCreate()
    {
        if (!Auth::check()) {
            return $this->redirect('/login');
        }

        return $this->viewWithLayout('plant-create', [
            'title' => "Ajouter une plante",
            'siteTitle' => 'Plantastique - Nouvelle plante'
        ]);
    }

    public function create()
    {
        if (!Auth::check()) {
            return $this->redirect('/login');
        }

        $name = $this->request->input('name');
        $species = $this->request->input('species');
        $description = $this->request->input('description');
        $imageUrl = $this->request->input('image_url');

        if (!$name || !$species) {
            return $this->redirect('/plants/create');
        }

        $plantId = Database::create('plants', [
            'user_id' => Auth::id(),
            'name' => $name,
            'species' => $species,
            'description' => $description,
            'image_url' => $imageUrl
        ]);

        if ($plantId === false) {
            return $this->redirect('/plants/create');
        }

        return $this->redirect('/plants');
    }

    public function delete()
    {
        if (!Auth::check()) {
            return $this->redirect('/login');
        }

        $id = $this->param('id');

        $plants = Database::query("SELECT * FROM plants WHERE id = :id", ['id' => $id]);

        if (!$plants || count($plants) === 0) {
            return $this->redirect('/plants');
        }

        $plant = $plants[0];

        if ($plant['user_id'] != Auth::id()) {
            return $this->redirect('/plants');
        }

        Database::deleteById('plants', $id);

        return $this->redirect('/plants');
    }
}

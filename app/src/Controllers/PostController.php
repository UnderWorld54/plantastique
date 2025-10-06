<?php

namespace App\Controllers;

use Framework\Controller;

class PostController extends Controller
{
    public function show()
    {
        $id = $this->param('id');
        return $this->viewWithLayout('post', [
            'id' => $id,
            'title' => "Post #{$id}",
        ]);
    }

    public function list()
    {
        return $this->viewWithLayout('posts', [
            'title' => "Liste des posts"
        ]);
    }
}

<?php

namespace Framework;

class Template
{
    private string $viewsPath;
    private array $data = [];
    private ?string $layout = null;
    private array $sections = [];
    private string $currentSection = '';

    public function __construct(string $viewsPath = null)
    {
        $this->viewsPath = $viewsPath ?? __DIR__ . '/../src/Views/';
    }

    // LE layout
    public function layout(string $layout): self
    {
        $this->layout = $layout;
        return $this;
    }


    // Données
    public function with(array $data): self
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    public function section(string $name): void
    {
        $this->currentSection = $name;
        ob_start();
    }

    public function endSection(): void
    {
        if ($this->currentSection) {
            $this->sections[$this->currentSection] = ob_get_clean();
            $this->currentSection = '';
        }
    }

    public function yield(string $sectionName, string $default = ''): string
    {
        return $this->sections[$sectionName] ?? $default;
    }

    public function render(string $view, array $data = []): string
    {
        // Fusionner les données
        $this->data = array_merge($this->data, $data);
        
        // Extraire les variables pour qu'elles soient disponibles dans les vues
        extract($this->data);
        
        // Si un layout est défini, rendre d'abord la vue puis le layout
        if ($this->layout) {
            return $this->renderWithLayout($view);
        }
        
        // Sinon, rendre juste la vue
        ob_start();
        
        $viewPath = $this->viewsPath . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: {$view}");
        }
        
        include $viewPath;
        return ob_get_clean();
    }

    private function renderWithLayout(string $view): string
    {
        // D'abord rendre la vue pour capturer le contenu
        extract($this->data);
        
        ob_start();
        
        $viewPath = $this->viewsPath . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: {$view}");
        }
        
        include $viewPath;
        $content = ob_get_clean();
        
        // Ajouter le contenu comme section 'content'
        $this->sections['content'] = $content;
        
        // Maintenant, rendre le layout
        extract($this->data);
        
        ob_start();
        
        $layoutPath = $this->viewsPath . $this->layout . '.php';
        if (!file_exists($layoutPath)) {
            throw new \Exception("Layout not found: {$this->layout}");
        }
        
        include $layoutPath;
        return ob_get_clean();
    }


    
    public function escape(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    // Inclusion d'une vue partielle (TO FIX)
    public function include(string $view, array $data = []): void
    {
        $viewPath = $this->viewsPath . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \Exception("Partial view not found: {$view}");
        }
        
        extract(array_merge($this->data, $data));
        include $viewPath;
    }
}

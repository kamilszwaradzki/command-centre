<?php

namespace Core;

class View
{
    private string $viewsDir;
    private array $data = [];
    private ?string $layout = null;
    private array $sections = [];

    public function __construct(string $viewsDir = __DIR__ . '/../../views')
    {
        $this->viewsDir = rtrim($viewsDir, '/');
    }

    /**
     * Przekazuje dane do widoku (chainable)
     */
    public function with(array $data): self
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Ustawia layout (opcjonalny)
     * np. 'layouts/main' – wtedy widok będzie wstawiony w @yield('content')
     */
    public function layout(string $layout): self
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Renderuje widok i zwraca string (lub od razu wyświetla)
     */
    public function render(string $view, array $data = []): string
    {
        $this->with($data);

        $file = $this->viewsDir . '/' . $view . '.php';

        if (!file_exists($file)) {
            throw new \Exception("Widok nie znaleziony: $file");
        }

        // Izolowany scope – zmienne nie przeciekają poza widok
        $renderer = function () use ($file) {
            extract($this->data, EXTR_SKIP); // EXTR_SKIP chroni przed nadpisywaniem zmiennych typu $this
            ob_start();
            require $file;
            return ob_get_clean();
        };

        $content = $renderer();

        // Jeśli jest layout – renderujemy go i wstawiamy $content w @yield('content')
        if ($this->layout) {
            $this->sections['content'] = $content;
            $layoutFile = $this->viewsDir . '/' . $this->layout . '.php';

            if (!file_exists($layoutFile)) {
                throw new \Exception("Layout nie znaleziony: $layoutFile");
            }

            $layoutRenderer = function () use ($layoutFile) {
                extract($this->sections, EXTR_SKIP);
                ob_start();
                require $layoutFile;
                return ob_get_clean();
            };

            return $layoutRenderer();
        }

        return $content;
    }

    /**
     * Wyświetla bezpośrednio (zamiast return string)
     */
    public function show(string $view, array $data = []): void
    {
        echo $this->render($view, $data);
        exit;
    }

    /**
     * Pomocnicza metoda do sekcji w widokach (dla layoutów)
     * Używane w widokach: @section('title') ... @endsection
     */
    public function section(string $name): void
    {
        if (ob_get_length()) {
            $this->sections[$name] = ob_get_clean();
        }
        ob_start();
    }

    public function endSection(): void
    {
        $this->sections[key(array_slice($this->sections, -1, 1, true))] = ob_get_clean();
    }

    /**
     * Wstawia sekcję w layoucie: @yield('content')
     */
    public function yield(string $name, string $default = ''): void
    {
        echo $this->sections[$name] ?? $default;
    }
}
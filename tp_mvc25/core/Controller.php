<?php
/**
 * Base Controller: render view, redirect, flash message, helper input.
 */
abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = __DIR__ . "/../app/views/$view.php";
        if (!is_file($viewFile)) {
            http_response_code(500);
            die("View $view tidak ditemukan");
        }
        ob_start();
        require $viewFile;
        $content = ob_get_clean();
        require __DIR__ . '/../app/views/layouts/main.php';
    }

    protected function redirect(string $controller, string $action = 'index', array $params = []): void
    {
        header('Location: ' . url($controller, $action, $params));
        exit;
    }

    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    protected function notFound(): void
    {
        http_response_code(404);
        $this->view('layouts/404');
        exit;
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /** Ambil & trim input POST sesuai daftar field. */
    protected function input(array $fields): array
    {
        $out = [];
        foreach ($fields as $f) {
            $out[$f] = trim((string) ($_POST[$f] ?? ''));
        }
        return $out;
    }

    protected function requirePost(): void
    {
        if (!$this->isPost()) {
            http_response_code(405);
            die('Method not allowed');
        }
        csrf_check();
    }
}

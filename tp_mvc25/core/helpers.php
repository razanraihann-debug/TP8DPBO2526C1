<?php
/** Escape output (cegah XSS). */
function e($v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

/** Bangun URL front controller: index.php?c=...&a=... */
function url(string $controller, string $action = 'index', array $params = []): string
{
    return 'index.php?' . http_build_query(['c' => $controller, 'a' => $action] + $params);
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check(): void
{
    $t = $_POST['_csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', $t)) {
        http_response_code(419);
        die('Invalid CSRF token');
    }
}

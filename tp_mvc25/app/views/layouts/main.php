<?php
$current = $_GET['c'] ?? 'lecturers';
$nav = ['lecturers' => 'Lecturers', 'departments' => 'Departments', 'courses' => 'Courses'];
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="assets/bootstrap.min.css" rel="stylesheet">
  <title><?= e($title ?? 'Home') ?></title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= url('lecturers') ?>">TP MVC</a>
      <ul class="navbar-nav flex-row gap-3">
        <?php foreach ($nav as $key => $label): ?>
          <li class="nav-item">
            <a class="nav-link <?= $current === $key ? 'active' : '' ?>" href="<?= url($key) ?>"><?= e($label) ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </nav>

  <div class="container my-4">
    <?php if ($flash): ?>
      <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
    <?php endif; ?>
    <?= $content ?>
  </div>

  <script src="assets/bootstrap.bundle.min.js"></script>
</body>
</html>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="m-0">Courses</h3>
  <a class="btn btn-primary" href="<?= url('courses', 'create') ?>">Add New</a>
</div>
<table class="table table-striped align-middle">
  <thead>
    <tr><th>ID</th><th>CODE</th><th>NAME</th><th>SKS</th><th>SEMESTER</th><th>LECTURER</th><th>DEPARTMENT</th><th>ACTIONS</th></tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <th><?= e($r['id']) ?></th>
        <td><?= e($r['code']) ?></td>
        <td><?= e($r['name']) ?></td>
        <td><?= e($r['credits']) ?></td>
        <td><?= e($r['semester']) ?></td>
        <td><?= e($r['lecturer_name'] ?? '-') ?></td>
        <td><?= e($r['department_name'] ?? '-') ?></td>
        <td class="text-nowrap">
          <a class="btn btn-success btn-sm" href="<?= url('courses', 'edit', ['id' => $r['id']]) ?>">Edit</a>
          <form class="d-inline" method="post" action="<?= url('courses', 'delete') ?>"
                onsubmit="return confirm('Hapus mata kuliah ini?')">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= e($r['id']) ?>">
            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$rows): ?><tr><td colspan="8" class="text-center text-muted">Belum ada data.</td></tr><?php endif; ?>
  </tbody>
</table>

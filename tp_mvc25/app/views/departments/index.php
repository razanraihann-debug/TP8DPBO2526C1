<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="m-0">Departments</h3>
  <a class="btn btn-primary" href="<?= url('departments', 'create') ?>">Add New</a>
</div>
<table class="table table-striped align-middle">
  <thead>
    <tr><th>ID</th><th>CODE</th><th>NAME</th><th>LECTURERS</th><th>COURSES</th><th>ACTIONS</th></tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <th><?= e($r['id']) ?></th>
        <td><?= e($r['code']) ?></td>
        <td><?= e($r['name']) ?></td>
        <td><?= e($r['lecturer_count']) ?></td>
        <td><?= e($r['course_count']) ?></td>
        <td class="text-nowrap">
          <a class="btn btn-success btn-sm" href="<?= url('departments', 'edit', ['id' => $r['id']]) ?>">Edit</a>
          <form class="d-inline" method="post" action="<?= url('departments', 'delete') ?>"
                onsubmit="return confirm('Hapus program studi ini?')">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= e($r['id']) ?>">
            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$rows): ?><tr><td colspan="6" class="text-center text-muted">Belum ada data.</td></tr><?php endif; ?>
  </tbody>
</table>

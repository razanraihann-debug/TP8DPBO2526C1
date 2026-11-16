<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="m-0">Lecturers</h3>
  <a class="btn btn-primary" href="<?= url('lecturers', 'create') ?>">Add New</a>
</div>
<table class="table table-striped align-middle">
  <thead>
    <tr>
      <th>ID</th><th>NAME</th><th>NIDN</th><th>PHONE</th><th>EMAIL</th>
      <th>DEPARTMENT</th><th>COURSES</th><th>JOIN DATE</th><th>ACTIONS</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <th><?= e($r['id']) ?></th>
        <td><?= e($r['name']) ?></td>
        <td><?= e($r['nidn']) ?></td>
        <td><?= e($r['phone']) ?></td>
        <td><?= e($r['email'] ?? '-') ?></td>
        <td><?= e($r['department_name'] ?? '-') ?></td>
        <td><?= e($r['course_count']) ?></td>
        <td><?= e($r['join_date']) ?></td>
        <td class="text-nowrap">
          <a class="btn btn-success btn-sm" href="<?= url('lecturers', 'edit', ['id' => $r['id']]) ?>">Edit</a>
          <form class="d-inline" method="post" action="<?= url('lecturers', 'delete') ?>"
                onsubmit="return confirm('Hapus dosen ini?')">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= e($r['id']) ?>">
            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$rows): ?><tr><td colspan="9" class="text-center text-muted">Belum ada data.</td></tr><?php endif; ?>
  </tbody>
</table>

<?php $v = fn($k, $d = '') => e($old[$k] ?? $d); ?>
<div class="col-lg-6 m-auto">
  <form method="post" action="<?= url('lecturers', $action) ?>">
    <?= csrf_field() ?>
    <?php if (isset($old['id'])): ?><input type="hidden" name="id" value="<?= $v('id') ?>"><?php endif; ?>
    <div class="card">
      <div class="card-header <?= $action === 'store' ? 'bg-primary' : 'bg-warning' ?>">
        <h1 class="text-white text-center fs-3 m-0"><?= e($title) ?></h1>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label">NAME</label>
          <input type="text" name="name" value="<?= $v('name') ?>" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>">
          <div class="invalid-feedback"><?= e($errors['name'] ?? '') ?></div>
        </div>
        <div class="mb-3">
          <label class="form-label">NIDN</label>
          <input type="text" name="nidn" value="<?= $v('nidn') ?>" class="form-control <?= isset($errors['nidn']) ? 'is-invalid' : '' ?>">
          <div class="invalid-feedback"><?= e($errors['nidn'] ?? '') ?></div>
        </div>
        <div class="mb-3">
          <label class="form-label">PHONE</label>
          <input type="text" name="phone" value="<?= $v('phone') ?>" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>">
          <div class="invalid-feedback"><?= e($errors['phone'] ?? '') ?></div>
        </div>
        <div class="mb-3">
          <label class="form-label">EMAIL</label>
          <input type="text" name="email" value="<?= $v('email') ?>" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>">
          <div class="invalid-feedback"><?= e($errors['email'] ?? '') ?></div>
        </div>
        <div class="mb-3">
          <label class="form-label">DEPARTMENT</label>
          <select name="department_id" class="form-select <?= isset($errors['department_id']) ? 'is-invalid' : '' ?>">
            <option value="">- Tidak ada -</option>
            <?php foreach ($departments as $d): ?>
              <option value="<?= e($d['id']) ?>" <?= (string) ($old['department_id'] ?? '') === (string) $d['id'] ? 'selected' : '' ?>>
                <?= e($d['code'] . ' - ' . $d['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback"><?= e($errors['department_id'] ?? '') ?></div>
        </div>
        <div class="mb-3">
          <label class="form-label">JOIN DATE</label>
          <input type="date" name="join_date" value="<?= $v('join_date') ?>" class="form-control <?= isset($errors['join_date']) ? 'is-invalid' : '' ?>">
          <div class="invalid-feedback"><?= e($errors['join_date'] ?? '') ?></div>
        </div>
        <button class="btn btn-success" type="submit">Submit</button>
        <a class="btn btn-info" href="<?= url('lecturers') ?>">Cancel</a>
      </div>
    </div>
  </form>
</div>

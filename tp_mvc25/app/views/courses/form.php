<?php $v = fn($k, $d = '') => e($old[$k] ?? $d); ?>
<div class="col-lg-6 m-auto">
  <form method="post" action="<?= url('courses', $action) ?>">
    <?= csrf_field() ?>
    <?php if (isset($old['id'])): ?><input type="hidden" name="id" value="<?= $v('id') ?>"><?php endif; ?>
    <div class="card">
      <div class="card-header <?= $action === 'store' ? 'bg-primary' : 'bg-warning' ?>">
        <h1 class="text-white text-center fs-3 m-0"><?= e($title) ?></h1>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label">CODE</label>
          <input type="text" name="code" maxlength="10" value="<?= $v('code') ?>" class="form-control <?= isset($errors['code']) ? 'is-invalid' : '' ?>">
          <div class="invalid-feedback"><?= e($errors['code'] ?? '') ?></div>
        </div>
        <div class="mb-3">
          <label class="form-label">NAME</label>
          <input type="text" name="name" value="<?= $v('name') ?>" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>">
          <div class="invalid-feedback"><?= e($errors['name'] ?? '') ?></div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label class="form-label">SKS</label>
            <input type="number" min="1" max="6" name="credits" value="<?= $v('credits', 3) ?>" class="form-control <?= isset($errors['credits']) ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback"><?= e($errors['credits'] ?? '') ?></div>
          </div>
          <div class="col mb-3">
            <label class="form-label">SEMESTER</label>
            <input type="number" min="1" max="14" name="semester" value="<?= $v('semester', 1) ?>" class="form-control <?= isset($errors['semester']) ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback"><?= e($errors['semester'] ?? '') ?></div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">LECTURER</label>
          <select name="lecturer_id" class="form-select <?= isset($errors['lecturer_id']) ? 'is-invalid' : '' ?>">
            <option value="">- Belum ditentukan -</option>
            <?php foreach ($lecturers as $l): ?>
              <option value="<?= e($l['id']) ?>" <?= (string) ($old['lecturer_id'] ?? '') === (string) $l['id'] ? 'selected' : '' ?>>
                <?= e($l['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback"><?= e($errors['lecturer_id'] ?? '') ?></div>
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
        <button class="btn btn-success" type="submit">Submit</button>
        <a class="btn btn-info" href="<?= url('courses') ?>">Cancel</a>
      </div>
    </div>
  </form>
</div>

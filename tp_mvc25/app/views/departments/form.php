<?php $v = fn($k, $d = '') => e($old[$k] ?? $d); ?>
<div class="col-lg-6 m-auto">
  <form method="post" action="<?= url('departments', $action) ?>">
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
        <button class="btn btn-success" type="submit">Submit</button>
        <a class="btn btn-info" href="<?= url('departments') ?>">Cancel</a>
      </div>
    </div>
  </form>
</div>

<?php
class DepartmentsController extends Controller
{
    private Department $departments;

    public function __construct()
    {
        $this->departments = new Department();
    }

    public function index(): void
    {
        $this->view('departments/index', [
            'title' => 'Departments',
            'rows'  => $this->departments->allWithCounts(),
        ]);
    }

    public function create(): void
    {
        $this->form('Create Department', 'store', [], []);
    }

    public function store(): void
    {
        $this->requirePost();
        $data   = $this->input(['code', 'name']);
        $errors = $this->validate($data);
        if ($errors) {
            $this->form('Create Department', 'store', $data, $errors);
            return;
        }
        $this->departments->create($data);
        $this->flash('success', 'Program studi berhasil ditambahkan.');
        $this->redirect('departments');
    }

    public function edit(): void
    {
        $row = $this->departments->find((int) ($_GET['id'] ?? 0)) ?? $this->notFound();
        $this->form('Update Department', 'update', $row, []);
    }

    public function update(): void
    {
        $this->requirePost();
        $id = (int) ($_POST['id'] ?? 0);
        $this->departments->find($id) ?? $this->notFound();
        $data   = $this->input(['code', 'name']);
        $errors = $this->validate($data, $id);
        if ($errors) {
            $this->form('Update Department', 'update', $data + ['id' => $id], $errors);
            return;
        }
        $this->departments->update($id, $data);
        $this->flash('success', 'Program studi berhasil diperbarui.');
        $this->redirect('departments');
    }

    public function delete(): void
    {
        $this->requirePost();
        $id = (int) ($_POST['id'] ?? 0);
        if ($this->departments->usageCount($id) > 0) {
            $this->flash('danger', 'Program studi tidak bisa dihapus karena masih dipakai oleh dosen atau mata kuliah.');
            $this->redirect('departments');
        }
        try {
            $this->departments->delete($id);
            $this->flash('success', 'Program studi berhasil dihapus.');
        } catch (PDOException $e) { // jaring pengaman: FK RESTRICT di database
            $this->flash('danger', 'Program studi tidak bisa dihapus karena masih dipakai.');
        }
        $this->redirect('departments');
    }

    private function form(string $title, string $action, array $old, array $errors): void
    {
        $this->view('departments/form', compact('title', 'action', 'old', 'errors'));
    }

    private function validate(array $d, int $id = 0): array
    {
        $err = [];
        if ($d['code'] === '') $err['code'] = 'Kode wajib diisi.';
        elseif (strlen($d['code']) > 10) $err['code'] = 'Kode maksimal 10 karakter.';
        elseif ($this->departments->codeExists($d['code'], $id)) $err['code'] = 'Kode sudah dipakai.';
        if ($d['name'] === '') $err['name'] = 'Nama wajib diisi.';
        return $err;
    }
}

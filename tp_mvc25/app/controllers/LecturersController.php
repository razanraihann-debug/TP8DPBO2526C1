<?php
class LecturersController extends Controller
{
    private Lecturer $lecturers;
    private Department $departments;

    public function __construct()
    {
        $this->lecturers   = new Lecturer();
        $this->departments = new Department();
    }

    public function index(): void
    {
        $this->view('lecturers/index', [
            'title' => 'Lecturers',
            'rows'  => $this->lecturers->allWithDepartment(),
        ]);
    }

    public function create(): void
    {
        $this->form('Create Lecturer', 'store', [], []);
    }

    public function store(): void
    {
        $this->requirePost();
        $data   = $this->input(['name', 'nidn', 'phone', 'join_date', 'email', 'department_id']);
        $errors = $this->validate($data);
        if ($errors) {
            $this->form('Create Lecturer', 'store', $data, $errors);
            return;
        }
        $this->lecturers->create($data);
        $this->flash('success', 'Dosen berhasil ditambahkan.');
        $this->redirect('lecturers');
    }

    public function edit(): void
    {
        $row = $this->lecturers->find((int) ($_GET['id'] ?? 0)) ?? $this->notFound();
        $this->form('Update Lecturer', 'update', $row, []);
    }

    public function update(): void
    {
        $this->requirePost();
        $id = (int) ($_POST['id'] ?? 0);
        $this->lecturers->find($id) ?? $this->notFound();
        $data   = $this->input(['name', 'nidn', 'phone', 'join_date', 'email', 'department_id']);
        $errors = $this->validate($data, $id);
        if ($errors) {
            $this->form('Update Lecturer', 'update', $data + ['id' => $id], $errors);
            return;
        }
        $this->lecturers->update($id, $data);
        $this->flash('success', 'Dosen berhasil diperbarui.');
        $this->redirect('lecturers');
    }

    public function delete(): void
    {
        $this->requirePost();
        $id = (int) ($_POST['id'] ?? 0);
        if ($this->lecturers->usageCount($id) > 0) {
            $this->flash('danger', 'Dosen tidak bisa dihapus karena masih mengampu mata kuliah.');
            $this->redirect('lecturers');
        }
        try {
            $this->lecturers->delete($id);
            $this->flash('success', 'Dosen berhasil dihapus.');
        } catch (PDOException $e) { // jaring pengaman: FK RESTRICT di database
            $this->flash('danger', 'Dosen tidak bisa dihapus karena masih dipakai.');
        }
        $this->redirect('lecturers');
    }

    private function form(string $title, string $action, array $old, array $errors): void
    {
        $this->view('lecturers/form', [
            'title'       => $title,
            'action'      => $action,
            'old'         => $old,
            'errors'      => $errors,
            'departments' => $this->departments->all('name'),
        ]);
    }

    private function validate(array &$d, int $id = 0): array
    {
        $err = [];
        if ($d['name'] === '')  $err['name']  = 'Nama wajib diisi.';
        if ($d['nidn'] === '')  $err['nidn']  = 'NIDN wajib diisi.';
        elseif ($this->lecturers->nidnExists($d['nidn'], $id)) $err['nidn'] = 'NIDN sudah terdaftar.';
        if ($d['phone'] === '') $err['phone'] = 'No. telepon wajib diisi.';
        if ($d['join_date'] === '' || !strtotime($d['join_date'])) $err['join_date'] = 'Tanggal bergabung tidak valid.';
        if ($d['email'] !== '' && !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $err['email'] = 'Format email tidak valid.';
        if ($d['department_id'] !== '' && !$this->departments->find((int) $d['department_id'])) {
            $err['department_id'] = 'Program studi tidak ditemukan.';
        }
        return $err;
    }
}

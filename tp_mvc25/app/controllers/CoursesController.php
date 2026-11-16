<?php
class CoursesController extends Controller
{
    private Course $courses;
    private Lecturer $lecturers;
    private Department $departments;

    public function __construct()
    {
        $this->courses     = new Course();
        $this->lecturers   = new Lecturer();
        $this->departments = new Department();
    }

    public function index(): void
    {
        $this->view('courses/index', [
            'title' => 'Courses',
            'rows'  => $this->courses->allWithRelations(),
        ]);
    }

    public function create(): void
    {
        $this->form('Create Course', 'store', ['credits' => 3, 'semester' => 1], []);
    }

    public function store(): void
    {
        $this->requirePost();
        $data   = $this->input(['code', 'name', 'credits', 'semester', 'lecturer_id', 'department_id']);
        $errors = $this->validate($data);
        if ($errors) {
            $this->form('Create Course', 'store', $data, $errors);
            return;
        }
        $this->courses->create($data);
        $this->flash('success', 'Mata kuliah berhasil ditambahkan.');
        $this->redirect('courses');
    }

    public function edit(): void
    {
        $row = $this->courses->find((int) ($_GET['id'] ?? 0)) ?? $this->notFound();
        $this->form('Update Course', 'update', $row, []);
    }

    public function update(): void
    {
        $this->requirePost();
        $id = (int) ($_POST['id'] ?? 0);
        $this->courses->find($id) ?? $this->notFound();
        $data   = $this->input(['code', 'name', 'credits', 'semester', 'lecturer_id', 'department_id']);
        $errors = $this->validate($data, $id);
        if ($errors) {
            $this->form('Update Course', 'update', $data + ['id' => $id], $errors);
            return;
        }
        $this->courses->update($id, $data);
        $this->flash('success', 'Mata kuliah berhasil diperbarui.');
        $this->redirect('courses');
    }

    public function delete(): void
    {
        $this->requirePost();
        $this->courses->delete((int) ($_POST['id'] ?? 0));
        $this->flash('success', 'Mata kuliah berhasil dihapus.');
        $this->redirect('courses');
    }

    private function form(string $title, string $action, array $old, array $errors): void
    {
        $this->view('courses/form', [
            'title'       => $title,
            'action'      => $action,
            'old'         => $old,
            'errors'      => $errors,
            'lecturers'   => $this->lecturers->all('name'),
            'departments' => $this->departments->all('name'),
        ]);
    }

    private function validate(array $d, int $id = 0): array
    {
        $err = [];
        if ($d['code'] === '') $err['code'] = 'Kode wajib diisi.';
        elseif (strlen($d['code']) > 10) $err['code'] = 'Kode maksimal 10 karakter.';
        elseif ($this->courses->codeExists($d['code'], $id)) $err['code'] = 'Kode sudah dipakai.';
        if ($d['name'] === '') $err['name'] = 'Nama wajib diisi.';
        if (!ctype_digit($d['credits']) || (int) $d['credits'] < 1 || (int) $d['credits'] > 6) {
            $err['credits'] = 'SKS harus 1-6.';
        }
        if (!ctype_digit($d['semester']) || (int) $d['semester'] < 1 || (int) $d['semester'] > 14) {
            $err['semester'] = 'Semester harus 1-14.';
        }
        if ($d['lecturer_id'] !== '' && !$this->lecturers->find((int) $d['lecturer_id'])) {
            $err['lecturer_id'] = 'Dosen tidak ditemukan.';
        }
        if ($d['department_id'] !== '' && !$this->departments->find((int) $d['department_id'])) {
            $err['department_id'] = 'Program studi tidak ditemukan.';
        }
        return $err;
    }
}

# TP MVC 25 — PHP MVC (Lecturers, Departments, Courses)

## Cara menjalankan (XAMPP/Laragon)
1. Taruh folder `tp_mvc25` di `htdocs`.
2. Import `database/tp_mvc25.sql` lewat phpMyAdmin (database dibuat otomatis).
3. Sesuaikan kredensial di `config/config.php` bila perlu.
4. Buka `http://localhost/tp_mvc25/`.

## Struktur MVC
```
index.php              Front controller / router (?c=controller&a=action)
config/config.php      Konfigurasi DB
core/                  Database (PDO), Model, Controller dasar, helpers
app/models/            Lecturer, Department, Course
app/controllers/       LecturersController, DepartmentsController, CoursesController
app/views/             layouts/ + lecturers/ departments/ courses/
assets/                Bootstrap
database/tp_mvc25.sql  Skema + data contoh
```

## Relasi
- departments 1—N lecturers (lecturers.department_id)
- lecturers   1—N courses   (courses.lecturer_id)
- departments 1—N courses   (courses.department_id)
- FK ke `departments` memakai ON DELETE RESTRICT: prodi yang masih dipakai dosen/mata kuliah
  tidak bisa dihapus (dicek di controller + dijaga database).
- FK `courses.lecturer_id` juga ON DELETE RESTRICT: dosen yang masih mengampu mata kuliah tidak bisa dihapus.

## Perubahan dari kode awal
- Tabel `lecturers` + kolom `email`, `department_id`; NIDN dibuat UNIQUE.
- Tabel baru: `departments`, `courses` (masing-masing CRUD penuh).
- Query diganti PDO prepared statement (sebelumnya rentan SQL injection),
  output di-escape, delete lewat POST + token CSRF, ada validasi & flash message.

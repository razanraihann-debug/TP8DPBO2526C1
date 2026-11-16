# JANJI
Saya Razan Raihan Malik dengan NIM 2508838 mengerjakan Tugas Praktikum 8 pada Mata Kuliah Desain dan Pemrograman Berorientasi Objek (DPBO) untuk keberkahan-Nya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

# Struktur Folder
<img width="311" height="631" alt="Screenshot 2026-11-16 at 21 35 02" src="https://github.com/user-attachments/assets/2159f8d7-9f03-4ca6-8f22-21184f76f910" />

# Struktur MVC
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

# Relasi
- departments 1—N lecturers (lecturers.department_id)
- lecturers   1—N courses   (courses.lecturer_id)
- departments 1—N courses   (courses.department_id)
- FK ke `departments` memakai ON DELETE RESTRICT: prodi yang masih dipakai dosen/mata kuliah
  tidak bisa dihapus (dicek di controller + dijaga database).
- FK `courses.lecturer_id` juga ON DELETE RESTRICT: dosen yang masih mengampu mata kuliah tidak bisa dihapus.
  
# Dokumentasi



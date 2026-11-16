<?php
class Course extends Model
{
    protected string $table = 'courses';
    protected array $fillable = ['code', 'name', 'credits', 'semester', 'lecturer_id', 'department_id'];

    /** Daftar mata kuliah + nama dosen & prodi (JOIN). */
    public function allWithRelations(): array
    {
        $sql = "SELECT c.*, l.name AS lecturer_name, d.name AS department_name
                FROM courses c
                LEFT JOIN lecturers l   ON l.id = c.lecturer_id
                LEFT JOIN departments d ON d.id = c.department_id
                ORDER BY c.semester, c.code";
        return $this->db->query($sql)->fetchAll();
    }

    public function codeExists(string $code, int $exceptId = 0): bool
    {
        $st = $this->db->prepare("SELECT 1 FROM courses WHERE code = ? AND id <> ?");
        $st->execute([$code, $exceptId]);
        return (bool) $st->fetchColumn();
    }
}

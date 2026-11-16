<?php
class Lecturer extends Model
{
    protected string $table = 'lecturers';
    protected array $fillable = ['name', 'nidn', 'phone', 'join_date', 'email', 'department_id'];

    /** Daftar dosen + nama prodi + jumlah mata kuliah yang diampu. */
    public function allWithDepartment(): array
    {
        $sql = "SELECT l.*, d.name AS department_name,
                  (SELECT COUNT(*) FROM courses c WHERE c.lecturer_id = l.id) AS course_count
                FROM lecturers l
                LEFT JOIN departments d ON d.id = l.department_id
                ORDER BY l.id";
        return $this->db->query($sql)->fetchAll();
    }

    /** Jumlah mata kuliah yang masih diampu dosen ini. */
    public function usageCount(int $id): int
    {
        $st = $this->db->prepare("SELECT COUNT(*) FROM courses WHERE lecturer_id = ?");
        $st->execute([$id]);
        return (int) $st->fetchColumn();
    }

    public function nidnExists(string $nidn, int $exceptId = 0): bool
    {
        $st = $this->db->prepare("SELECT 1 FROM lecturers WHERE nidn = ? AND id <> ?");
        $st->execute([$nidn, $exceptId]);
        return (bool) $st->fetchColumn();
    }
}

<?php
class Department extends Model
{
    protected string $table = 'departments';
    protected array $fillable = ['code', 'name'];

    /** Daftar prodi + jumlah dosen & mata kuliah. */
    public function allWithCounts(): array
    {
        $sql = "SELECT d.*,
                  (SELECT COUNT(*) FROM lecturers l WHERE l.department_id = d.id) AS lecturer_count,
                  (SELECT COUNT(*) FROM courses c WHERE c.department_id = d.id)   AS course_count
                FROM departments d ORDER BY d.name";
        return $this->db->query($sql)->fetchAll();
    }

    /** Jumlah dosen + mata kuliah yang masih memakai prodi ini. */
    public function usageCount(int $id): int
    {
        $st = $this->db->prepare(
            "SELECT (SELECT COUNT(*) FROM lecturers WHERE department_id = ?)
                  + (SELECT COUNT(*) FROM courses   WHERE department_id = ?)"
        );
        $st->execute([$id, $id]);
        return (int) $st->fetchColumn();
    }

    public function codeExists(string $code, int $exceptId = 0): bool
    {
        $st = $this->db->prepare("SELECT 1 FROM departments WHERE code = ? AND id <> ?");
        $st->execute([$code, $exceptId]);
        return (bool) $st->fetchColumn();
    }
}

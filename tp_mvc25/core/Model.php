<?php
/**
 * Base Model: CRUD generik memakai prepared statement.
 * Model turunan cukup mengisi $table dan $fillable.
 */
abstract class Model
{
    protected PDO $db;
    protected string $table;
    protected array $fillable = [];

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all(string $orderBy = 'id'): array
    {
        return $this->db->query("SELECT * FROM `{$this->table}` ORDER BY $orderBy")->fetchAll();
    }

    public function find(int $id): ?array
    {
        $st = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE id = ?");
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $data = $this->only($data);
        $cols = implode(',', array_map(fn($c) => "`$c`", array_keys($data)));
        $ph   = implode(',', array_fill(0, count($data), '?'));
        $st   = $this->db->prepare("INSERT INTO `{$this->table}` ($cols) VALUES ($ph)");
        $st->execute(array_values($data));
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $data = $this->only($data);
        $set  = implode(',', array_map(fn($c) => "`$c` = ?", array_keys($data)));
        $st   = $this->db->prepare("UPDATE `{$this->table}` SET $set WHERE id = ?");
        return $st->execute([...array_values($data), $id]);
    }

    public function delete(int $id): bool
    {
        $st = $this->db->prepare("DELETE FROM `{$this->table}` WHERE id = ?");
        return $st->execute([$id]);
    }

    /** Hanya ambil kolom yang diizinkan; string kosong pada kolom nullable -> NULL. */
    protected function only(array $data): array
    {
        $out = [];
        foreach ($this->fillable as $col) {
            if (array_key_exists($col, $data)) {
                $out[$col] = $data[$col] === '' ? null : $data[$col];
            }
        }
        return $out;
    }
}

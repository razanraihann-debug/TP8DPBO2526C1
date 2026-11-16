-- =====================================================
-- Database: tp_mvc25
-- Domain  : Data Dosen (lecturers), Program Studi (departments),
--           Mata Kuliah (courses)
-- Relasi  : departments 1 --- N lecturers
--           lecturers   1 --- N courses
--           departments 1 --- N courses
-- =====================================================
CREATE DATABASE IF NOT EXISTS `tp_mvc25`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tp_mvc25`;

DROP TABLE IF EXISTS `courses`;
DROP TABLE IF EXISTS `lecturers`;
DROP TABLE IF EXISTS `departments`;

-- Tabel BARU 1: program studi / departemen
CREATE TABLE `departments` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code`       VARCHAR(10)  NOT NULL,
  `name`       VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_departments_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel LAMA (lecturers) + atribut baru: email, department_id
CREATE TABLE `lecturers` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(100) NOT NULL,
  `nidn`          VARCHAR(20)  NOT NULL,
  `phone`         VARCHAR(20)  NOT NULL,
  `join_date`     DATE         NOT NULL,
  `email`         VARCHAR(100) DEFAULT NULL,          -- atribut baru
  `department_id` INT UNSIGNED DEFAULT NULL,          -- atribut baru (FK)
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_lecturers_nidn` (`nidn`),
  KEY `idx_lecturers_department` (`department_id`),
  CONSTRAINT `fk_lecturers_department` FOREIGN KEY (`department_id`)
    REFERENCES `departments` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel BARU 2: mata kuliah
CREATE TABLE `courses` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code`          VARCHAR(10)  NOT NULL,
  `name`          VARCHAR(100) NOT NULL,
  `credits`       TINYINT UNSIGNED NOT NULL DEFAULT 3,
  `semester`      TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `lecturer_id`   INT UNSIGNED DEFAULT NULL,
  `department_id` INT UNSIGNED DEFAULT NULL,
  `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_courses_code` (`code`),
  KEY `idx_courses_lecturer` (`lecturer_id`),
  KEY `idx_courses_department` (`department_id`),
  CONSTRAINT `fk_courses_lecturer` FOREIGN KEY (`lecturer_id`)
    REFERENCES `lecturers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_courses_department` FOREIGN KEY (`department_id`)
    REFERENCES `departments` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------- Data contoh ----------------
INSERT INTO `departments` (`code`, `name`) VALUES
  ('TI', 'Teknik Informatika'),
  ('SI', 'Sistem Informasi'),
  ('MI', 'Manajemen Informatika');

INSERT INTO `lecturers` (`name`, `nidn`, `phone`, `join_date`, `email`, `department_id`) VALUES
  ('Dr. Budi Santoso, M.Kom', '0412058801', '081234567890', '2015-08-17', 'budi@kampus.ac.id', 1),
  ('Siti Aminah, M.T',        '0423098702', '081298765432', '2018-02-01', 'siti@kampus.ac.id', 1),
  ('Rudi Hartono, M.Sc',      '0405078503', '085711223344', '2020-09-01', 'rudi@kampus.ac.id', 2);

INSERT INTO `courses` (`code`, `name`, `credits`, `semester`, `lecturer_id`, `department_id`) VALUES
  ('TI101', 'Pemrograman Web',   3, 3, 1, 1),
  ('TI102', 'Basis Data',        3, 3, 2, 1),
  ('SI201', 'Analisis Sistem',   3, 4, 3, 2),
  ('TI103', 'Pemrograman Mobile',3, 5, 1, 1);

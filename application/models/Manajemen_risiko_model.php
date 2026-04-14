<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_risiko_model extends CI_Model {
    protected $table = 'manajemen_risiko';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function ensure_schema()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id_risiko` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_user` INT(8) UNSIGNED NOT NULL,
            `jenis_usaha` VARCHAR(100) NULL,
            `daftar_risiko` TEXT NULL,
            `rekomendasi_mitigasi` TEXT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        if (! $this->db->field_exists('nama_risiko', $this->table)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `nama_risiko` VARCHAR(255) NULL AFTER `id_user`");
        }

        if (! $this->db->field_exists('tingkat', $this->table)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `tingkat` VARCHAR(20) NULL AFTER `nama_risiko`");
        }

        if (! $this->db->field_exists('tindakan_mitigasi', $this->table)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `tindakan_mitigasi` TEXT NULL AFTER `tingkat`");
        }

        if (! $this->db->field_exists('status_penanganan', $this->table)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `status_penanganan` VARCHAR(30) NULL AFTER `tindakan_mitigasi`");
        }

        if (! $this->db->field_exists('tanggal', $this->table)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `tanggal` DATE NULL AFTER `status_penanganan`");
        }

        $this->db->query("UPDATE `{$this->table}`
            SET
                `nama_risiko` = COALESCE(NULLIF(`nama_risiko`, ''), `daftar_risiko`),
                `tingkat` = COALESCE(NULLIF(`tingkat`, ''), 'Sedang'),
                `tindakan_mitigasi` = COALESCE(NULLIF(`tindakan_mitigasi`, ''), `rekomendasi_mitigasi`),
                `status_penanganan` = COALESCE(NULLIF(`status_penanganan`, ''), 'Belum Ditangani'),
                `tanggal` = COALESCE(`tanggal`, DATE(`created_at`), CURDATE())
            WHERE
                `nama_risiko` IS NULL
                OR `nama_risiko` = ''
                OR `tingkat` IS NULL
                OR `tingkat` = ''
                OR `tindakan_mitigasi` IS NULL
                OR `tindakan_mitigasi` = ''
                OR `status_penanganan` IS NULL
                OR `status_penanganan` = ''
                OR `tanggal` IS NULL");
    }

    public function get_by_user($id_user)
    {
        return $this->db
            ->select("id_risiko,
                COALESCE(NULLIF(nama_risiko, ''), daftar_risiko) AS nama_risiko,
                COALESCE(NULLIF(tingkat, ''), 'Sedang') AS tingkat,
                COALESCE(NULLIF(tindakan_mitigasi, ''), rekomendasi_mitigasi) AS tindakan_mitigasi,
                COALESCE(NULLIF(status_penanganan, ''), 'Belum Ditangani') AS status_penanganan,
                COALESCE(tanggal, DATE(created_at), CURDATE()) AS tanggal", false)
            ->where('id_user', (int) $id_user)
            ->order_by('tanggal', 'DESC')
            ->order_by('id_risiko', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id_for_user($id_risiko, $id_user)
    {
        return $this->db
            ->select("id_risiko,
                COALESCE(NULLIF(nama_risiko, ''), daftar_risiko) AS nama_risiko,
                COALESCE(NULLIF(tingkat, ''), 'Sedang') AS tingkat,
                COALESCE(NULLIF(tindakan_mitigasi, ''), rekomendasi_mitigasi) AS tindakan_mitigasi,
                COALESCE(NULLIF(status_penanganan, ''), 'Belum Ditangani') AS status_penanganan,
                COALESCE(tanggal, DATE(created_at), CURDATE()) AS tanggal", false)
            ->where('id_risiko', (int) $id_risiko)
            ->where('id_user', (int) $id_user)
            ->get($this->table)
            ->row();
    }

    public function get_summary_by_user($id_user)
    {
        $result = $this->db->query(
            "SELECT
                COUNT(*) AS total,
                SUM(CASE WHEN tingkat = 'Tinggi' THEN 1 ELSE 0 END) AS tinggi,
                SUM(CASE WHEN tingkat = 'Sedang' THEN 1 ELSE 0 END) AS sedang,
                SUM(CASE WHEN tingkat = 'Rendah' THEN 1 ELSE 0 END) AS rendah
             FROM `{$this->table}`
             WHERE `id_user` = ?",
            [(int) $id_user]
        )->row_array();

        return [
            'total'  => (int) ($result['total'] ?? 0),
            'tinggi' => (int) ($result['tinggi'] ?? 0),
            'sedang' => (int) ($result['sedang'] ?? 0),
            'rendah' => (int) ($result['rendah'] ?? 0),
        ];
    }

    public function insert_for_user($id_user, $data)
    {
        $payload = [
            'id_user' => (int) $id_user,
            'nama_risiko' => $data['nama_risiko'],
            'tingkat' => $data['tingkat'],
            'tindakan_mitigasi' => $data['tindakan_mitigasi'],
            'status_penanganan' => $data['status_penanganan'],
            'tanggal' => $data['tanggal'],
            'daftar_risiko' => $data['nama_risiko'],
            'rekomendasi_mitigasi' => $data['tindakan_mitigasi'],
            'jenis_usaha' => 'UMKM'
        ];

        $this->db->insert($this->table, $payload);
        return $this->db->insert_id();
    }

    public function update_for_user($id_risiko, $id_user, $data)
    {
        $payload = [
            'nama_risiko' => $data['nama_risiko'],
            'tingkat' => $data['tingkat'],
            'tindakan_mitigasi' => $data['tindakan_mitigasi'],
            'status_penanganan' => $data['status_penanganan'],
            'tanggal' => $data['tanggal'],
            'daftar_risiko' => $data['nama_risiko'],
            'rekomendasi_mitigasi' => $data['tindakan_mitigasi'],
        ];

        return $this->db
            ->where('id_risiko', (int) $id_risiko)
            ->where('id_user', (int) $id_user)
            ->update($this->table, $payload);
    }

    public function delete_for_user($id_risiko, $id_user)
    {
        return $this->db
            ->where('id_risiko', (int) $id_risiko)
            ->where('id_user', (int) $id_user)
            ->delete($this->table);
    }
}


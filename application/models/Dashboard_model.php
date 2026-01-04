<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function getSummary($id_user, $periode = 'hari')
    {
        $date_filter = '';
        
        switch($periode) {
            case 'minggu':
                $date_filter = "DATE(tanggal) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                break;
            case 'bulan':
                $date_filter = "MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
                break;
            case 'tahun':
                $date_filter = "YEAR(tanggal) = YEAR(CURDATE())";
                break;
            default: // hari
                $date_filter = "DATE(tanggal) = CURDATE()";
        }
        
        // Query penjualan
        $query_sales = $this->db->select('COALESCE(SUM(nominal), 0) as total')
            ->where('id_user', $id_user)
            ->where('jenis', 'pemasukan')
            ->where($date_filter, null, false)
            ->get('pencatatan_keuangan');
        $sales = $query_sales->row()->total ?? 0;
        
        // Query pengeluaran
        $query_expense = $this->db->select('COALESCE(SUM(nominal), 0) as total')
            ->where('id_user', $id_user)
            ->where('jenis', 'pengeluaran')
            ->where($date_filter, null, false)
            ->get('pencatatan_keuangan');
        $expense = $query_expense->row()->total ?? 0;
        
        return [
            'today_sales'   => (int)$sales,
            'today_expense' => (int)$expense,
            'today_profit'  => (int)($sales - $expense),
            'margin'        => $sales > 0 ? round((($sales - $expense) / $sales) * 100, 1) : 0
        ];
    }

    public function getTransactions($id_user, $limit = 10)
    {
        return $this->db->where('id_user', $id_user)
            ->order_by('tanggal', 'DESC')
            ->order_by('id_transaksi', 'DESC')
            ->limit($limit)
            ->get('pencatatan_keuangan')
            ->result_array();
    }

    public function getTransactionsByPeriod($id_user, $periode = 'hari', $limit = 10)
    {
        $date_filter = '';
        
        switch($periode) {
            case 'minggu':
                $date_filter = "DATE(tanggal) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                break;
            case 'bulan':
                $date_filter = "MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
                break;
            case 'tahun':
                $date_filter = "YEAR(tanggal) = YEAR(CURDATE())";
                break;
            default: // hari
                $date_filter = "DATE(tanggal) = CURDATE()";
        }
        
        return $this->db->where('id_user', $id_user)
            ->where($date_filter, null, false)
            ->order_by('tanggal', 'DESC')
            ->order_by('id_transaksi', 'DESC')
            ->limit($limit)
            ->get('pencatatan_keuangan')
            ->result_array();
    }

    public function getChartData($id_user, $days = 7)
    {
        $data = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $date_formatted = date('D', strtotime($date));
            
            // Get sales for this date
            $sales = $this->db->select('COALESCE(SUM(nominal), 0) as total')
                ->where('id_user', $id_user)
                ->where('jenis', 'pemasukan')
                ->where("DATE(tanggal)", $date)
                ->get('pencatatan_keuangan')
                ->row()->total ?? 0;
            
            // Get expense for this date
            $expense = $this->db->select('COALESCE(SUM(nominal), 0) as total')
                ->where('id_user', $id_user)
                ->where('jenis', 'pengeluaran')
                ->where("DATE(tanggal)", $date)
                ->get('pencatatan_keuangan')
                ->row()->total ?? 0;
            
            $data[] = [
                'date' => $date,
                'label' => $date_formatted,
                'sales' => (int)$sales,
                'expense' => (int)$expense,
                'profit' => (int)($sales - $expense)
            ];
        }
        
        return $data;
    }
}

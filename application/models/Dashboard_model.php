<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function getSummary($id_user)
    {
        return [
            'today_sales'   => 150000,
            'today_expense' => 75000,
            'today_profit'  => 75000,
            'margin'        => 50
        ];
    }

    public function getTransactions($id_user)
    {
        return [
            [
                'title'  => 'Pembelian beras 5kg',
                'time'   => '23.41',
                'type'   => 'bahan baku',
                'amount' => -75000
            ],
            [
                'title'  => 'Penjualan nasi ayam 10 porsi',
                'time'   => '23.32',
                'type'   => 'penjualan',
                'amount' => 150000
            ]
        ];
    }
}

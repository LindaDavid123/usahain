<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advisor extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Allow public access: all advisor features accessible without login
        $this->load->helper(['url','form']);
        $this->load->library('form_validation');
        $this->load->model('Al_advisor_model');
        $this->load->library('Gemini');
    }

    public function index()
    {
        // Show the advisor form directly as the main advisor page
        $this->load->view('advisor/form');
    }

    public function view($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $advisor = $this->db->get_where('al_advisor', ['id_ide' => $id, 'id_user' => $id_user])->row();
        if (!$advisor) { show_404(); return; }
        $data['advisor'] = $advisor;
        $this->load->view('advisor/view', $data);
    }

    /**
     * Chat interface for a specific advisor entry.
     * Accessible after a recommendation has been created.
     */
    public function chat($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $advisor = $this->Al_advisor_model->get($id);
        if (!$advisor || $advisor->id_user != $id_user) { show_404(); return; }

        // decode chat history (stored as JSON) if exists
        $chat = [];
        if (!empty($advisor->riwayat_chat)) {
            $decoded = json_decode($advisor->riwayat_chat, true);
            if (is_array($decoded)) $chat = $decoded;
        }

        $data['advisor'] = $advisor;
        $data['chat'] = $chat;
        $this->load->view('advisor/chat', $data);
    }

    public function form()
    {
        $this->load->view('advisor/form');
    }

    public function create()
    {
        if ($this->input->method() === 'post') {
            // ensure we have an associated user id; if not, create a temporary guest user
            $id_user = $this->session->userdata('id_user');
            if (!$id_user) {
                // create a guest user record so DB foreign key is satisfied
                $guest_name = 'Guest-' . time();
                $random_pass = bin2hex(random_bytes(8));
                $hash = password_hash($random_pass, PASSWORD_BCRYPT);
                $guest = [
                    'nama' => $guest_name,
                    'role' => 'user',
                    'email' => null,
                    'password' => $hash,
                    'nama_usaha' => null
                ];
                $this->db->insert('user', $guest);
                $id_user = $this->db->insert_id();
                // set session so the guest can continue in this session
                $this->session->set_userdata([
                    'id_user' => $id_user,
                    'nama' => $guest_name,
                    'role' => 'user'
                ]);
                $this->session->set_flashdata('info', 'Anda menggunakan sesi tamu. Buat akun untuk menyimpan data secara permanen.');
            }
            $this->form_validation->set_rules('modal', 'Modal Awal', 'required|numeric');
            $this->form_validation->set_rules('lokasi', 'Lokasi Usaha', 'required|min_length[3]');
            $this->form_validation->set_rules('minat', 'Jenis Usaha/Minat', 'required|min_length[3]');
            if ($this->form_validation->run() === TRUE) {
                $modal = $this->input->post('modal');
                $lokasi = $this->input->post('lokasi');
                $minat = $this->input->post('minat');
                
                // Generate AI recommendation based on input
                $rekomendasi = $this->generate_recommendation($modal, $lokasi, $minat);

                $data = [
                    'id_user' => $id_user,
                    'modal' => $modal,
                    'lokasi' => $lokasi,
                    'minat' => $minat,
                    'rekomendasi' => $rekomendasi,
                    'riwayat_chat' => '',
                ];
                $insert_id = $this->Al_advisor_model->insert($data);
                redirect('advisor/chat/'.$insert_id);
                return;
            }
        }
        $this->load->view('advisor/form');
    }

    public function edit($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $advisor = $this->db->get_where('al_advisor', ['id_ide' => $id, 'id_user' => $id_user])->row();
        if (!$advisor) { show_404(); return; }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('modal', 'Modal Awal', 'required|numeric');
            $this->form_validation->set_rules('lokasi', 'Lokasi Usaha', 'required|min_length[3]');
            $this->form_validation->set_rules('minat', 'Jenis Usaha/Minat', 'required|min_length[3]');

            if ($this->form_validation->run() === TRUE) {
                $modal = $this->input->post('modal');
                $lokasi = $this->input->post('lokasi');
                $minat = $this->input->post('minat');
                $rekomendasi = $this->generate_recommendation($modal, $lokasi, $minat);

                $update_data = [
                    'modal' => $modal,
                    'lokasi' => $lokasi,
                    'minat' => $minat,
                    'rekomendasi' => $rekomendasi,
                ];
                $this->db->where('id_ide', $id)->update('al_advisor', $update_data);
                redirect('advisor');
                return;
            }
        }

        $data['advisor'] = $advisor;
        $this->load->view('advisor/form', $data);
    }

    public function delete($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $advisor = $this->db->get_where('al_advisor', ['id_ide' => $id, 'id_user' => $id_user])->row();
        if (!$advisor) { show_404(); return; }

        if ($this->input->method() !== 'post') {
            $data['advisor'] = $advisor;
            $this->load->view('advisor/delete', $data);
            return;
        }

        $this->db->where('id_ide', $id)->delete('al_advisor');
        redirect('advisor');
    }

    /**
     * AJAX endpoint to append a user message and generate a simple AI reply.
     * Expects POST: id (advisor id), message (text)
     */
    public function send_message()
    {
        // Clear ALL output buffers to prevent BOM or whitespace
        while (ob_get_level()) {
            ob_end_clean();
        }
        ob_start();
        
        header('Content-Type: application/json; charset=UTF-8');

        if ($this->input->method() !== 'post') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
            exit;
        }

        $id = $this->input->post('id');
        $message = trim($this->input->post('message'));

        if (!$id || $message === '') {
            echo json_encode(['status' => 'error', 'message' => 'Pesan kosong']);
            exit;
        }

        $advisor = $this->Al_advisor_model->get($id);
        if (!$advisor) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
            exit;
        }

        // Decode chat lama
        $chat = [];
        if (!empty($advisor->riwayat_chat)) {
            $chat = json_decode($advisor->riwayat_chat, true) ?: [];
        }

        // Simpan pesan user
        $chat[] = [
            'from' => 'user',
            'message' => $message,
            'time' => date('Y-m-d H:i:s')
        ];

        // Load Gemini
        $this->load->library('Gemini');

        // Gunakan fungsi call_gemini_response yang sudah include riwayat chat
        $reply = $this->call_gemini_response($advisor, $message);

        // Accept any non-empty reply from Gemini as valid
        $valid = ($reply && strlen(trim($reply)) > 30);
        $source = 'gemini';

        // If primary failed or reply too short, try one more time
        if (!$valid) {
            log_message('warning', 'Gemini primary response empty/short, attempting retry');
            sleep(2); // Wait before retry
            $reply = $this->call_gemini_response($advisor, $message);
            $valid = ($reply && strlen(trim($reply)) >= 30);
        }

        if (!$valid) {
            log_message('warning', 'Gemini did not return a relevant reply; using local fallback for advisor id: '.$id);
            // Use a local fallback responder so the user always gets an answer
            $reply = $this->local_ai_reply($advisor, $message);
            $source = 'fallback';
        }

        // Simpan balasan AI (atau fallback)
        $chat[] = [
            'from' => 'ai',
            'message' => $reply,
            'time' => date('Y-m-d H:i:s')
        ];

        // Update DB
        $this->Al_advisor_model->update($id, [
            'riwayat_chat' => json_encode($chat)
        ]);

        $response = [
            'status' => 'ok',
            'reply' => $reply,
            'chat' => $chat,
            'source' => $source // 'gemini' or 'fallback'
        ];
        
        log_message('debug', 'Sending response: ' . json_encode(['status' => $response['status'], 'reply_length' => strlen($reply), 'source' => $source]));
        
        // Clean all buffers and send only JSON
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit; // Prevent any further output
    }


    // Helper method to generate AI-like recommendations
    private function generate_recommendation($modal, $lokasi, $minat)
    {
        $recommendations = [];

        // Modal-based recommendations
        if ($modal < 5000000) {
            $recommendations[] = "Mulai dengan usaha skala kecil seperti dagang eceran, jasa freelance, atau produk digital.";
        } elseif ($modal < 50000000) {
            $recommendations[] = "Dengan modal Rp " . number_format($modal, 0, ',', '.') . ", Anda bisa membuka warung makan, toko kelontong, atau usaha jasa.";
        } else {
            $recommendations[] = "Modal Anda cukup untuk membuka usaha skala menengah seperti toko retail, layanan konsultasi, atau manufaktur kecil.";
        }

        // Location-based recommendations
        if (stripos($lokasi, 'kota') !== false || stripos($lokasi, 'perkotaan') !== false) {
            $recommendations[] = "Di area perkotaan, pertimbangkan bisnis yang dekat dengan target pasar urban seperti kafe, boutique, atau layanan digital.";
        } elseif (stripos($lokasi, 'desa') !== false || stripos($lokasi, 'pedesaan') !== false) {
            $recommendations[] = "Di area pedesaan, fokus pada produk lokal, pertanian, atau jasa yang dibutuhkan komunitas lokal.";
        }

        // Business type recommendations
        if (stripos($minat, 'makanan') !== false || stripos($minat, 'kuliner') !== false) {
            $recommendations[] = "Untuk bisnis kuliner, pastikan memiliki sertifikat HALAL dan izin usaha dagang dari dinas setempat.";
            $recommendations[] = "Manfaatkan platform online seperti Gofood, Grabfood, atau Instagram untuk marketing digital.";
        } elseif (stripos($minat, 'elektronik') !== false || stripos($minat, 'gadget') !== false) {
            $recommendations[] = "Pastikan stok terjamin dan harga kompetitif. Pertimbangkan membership program untuk customer loyalty.";
        } elseif (stripos($minat, 'fashion') !== false || stripos($minat, 'pakaian') !== false) {
            $recommendations[] = "Tren fashion cepat berubah. Pantau media sosial dan tren global untuk selalu relevan.";
            $recommendations[] = "Bangun komunitas followers dan lakukan kolaborasi dengan influencer lokal.";
        } else {
            $recommendations[] = "Lakukan riset pasar mendalam untuk memahami kebutuhan dan preferensi target customer Anda.";
        }

        // General business advice
        $recommendations[] = "Buat business plan yang matang dan kelola keuangan dengan baik menggunakan aplikasi ini.";
        $recommendations[] = "Selalu catat setiap transaksi untuk monitoring performa bisnis Anda.";

        return implode("\n\n", $recommendations);
    }
    private function call_gemini_response($advisor, $userMessage)
    {
        // Bangun system prompt (peran AI)
        $systemPrompt = "
        Kamu adalah AI Advisor UMKM profesional di Indonesia.
        Tugasmu memberi saran usaha yang realistis, praktis, dan mudah dipahami.

        KONTEKS USER:
        - Modal awal: Rp {$advisor->modal}
        - Lokasi usaha: {$advisor->lokasi}
        - Minat usaha: {$advisor->minat}

        ATURAN:
        - Gunakan bahasa Indonesia
        - Jawaban maksimal 5 paragraf
        - Fokus solusi praktis
        - Jangan menyebut kata 'AI'
        - Berikan jawaban yang BERVARIASI dan KREATIF untuk setiap pertanyaan
        - Hindari pengulangan jawaban yang sama persis
        ";

        // Ambil 5 chat terakhir sebagai konteks
        $historyText = '';
        if (!empty($advisor->riwayat_chat)) {
            $history = json_decode($advisor->riwayat_chat, true);
            if (is_array($history)) {
                $recent = array_slice($history, -5);
                foreach ($recent as $h) {
                    $role = $h['from'] === 'user' ? 'User' : 'Advisor';
                    $historyText .= "{$role}: {$h['message']}\n";
                }
            }
        }

        $finalPrompt = $systemPrompt . "\n"
            . "RIWAYAT CHAT:\n"
            . $historyText . "\n"
            . "PERTANYAAN USER TERAKHIR:\n"
            . $userMessage . "\n"
            . "[Request ID: " . uniqid() . " | Waktu: " . date('Y-m-d H:i:s') . "]";

        $response = $this->gemini->generate($finalPrompt);

        return $response;
    }

    /**
     * Local fallback responder when external API is unavailable.
     * Produces a concise, practical reply based on user's context and question.
     */
    private function local_ai_reply($advisor, $userMessage)
    {
        $modal = $advisor->modal;
        $lokasi = $advisor->lokasi;
        $minat = $advisor->minat;

        // Start with relevance from generate_recommendation
        $base = $this->generate_recommendation($modal, $lokasi, $minat);

        // Short heuristics to answer user question contextually
        $reply = "Berikut jawaban singkat berdasarkan konteks Anda:\n\n";

        // If user asks about pemasaran/marketing
        if (preg_match('/(pasar|marketing|promosi|gofood|instagram|sosial|online)/i', $userMessage)) {
            $reply .= "Mulailah dengan daftar produk/layanan unggulan dan gunakan foto/ deskripsi menarik. Manfaatkan platform lokal (GoFood/GrabFood) dan promo 'diskon pembukaan'. Gunakan Instagram dan WhatsApp untuk membangun pelanggan awal.";
        } elseif (preg_match('/(modal|biaya|harga|investasi)/i', $userMessage)) {
            $reply .= "Kelompokkan biaya menjadi modal awal, biaya operasional, dan cadangan. Prioritaskan pembelian bahan baku yang memberikan margin terbaik. Pertimbangkan model pre-order untuk mengurangi kebutuhan modal.";
        } elseif (preg_match('/(legal|izin|halal|npwp|nib)/i', $userMessage)) {
            $reply .= "Periksa izin usaha dasar: NIB dan izin dari dinas setempat; untuk makanan, pastikan sertifikat HALAL jika pasar membutuhkan. Konsultasikan ke dinas koperasi setempat untuk bantuan pendaftaran.";
        } else {
            // Generic helpful reply: combine base recommendation with targeted tips
            $reply .= $base;
        }

        // Append brief personalized tip
        $reply .= "\n\nTips cepat: fokus pada 1-2 produk pertama, catat pendapatan harian, dan evaluasi setiap minggu.";

        return $reply;
    }

}


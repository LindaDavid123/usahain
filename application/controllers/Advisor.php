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

    /**
     * Clear chat history and start fresh without going back to form
     */
    public function new_chat($id = null)
    {
        // Clean all output buffers
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        header('Content-Type: application/json');
        
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID not provided']);
            return;
        }
        
        $id_user = $this->session->userdata('id_user');
        $advisor = $this->Al_advisor_model->get($id);
        
        if (!$advisor || $advisor->id_user != $id_user) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        // Simpan chat lama ke field history sebelum clear
        $old_chat = [];
        if (!empty($advisor->riwayat_chat)) {
            $decoded = json_decode($advisor->riwayat_chat, true);
            if (is_array($decoded) && count($decoded) > 0) {
                $old_chat = $decoded;
            }
        }
        
        // Ambil existing chat history
        $chat_history = [];
        if (!empty($advisor->chat_history)) {
            $history = json_decode($advisor->chat_history, true);
            if (is_array($history)) {
                $chat_history = $history;
            }
        }
        
        // Tambahkan chat lama ke history jika ada
        if (count($old_chat) > 0) {
            $chat_history[] = [
                'timestamp' => date('Y-m-d H:i:s'),
                'messages' => $old_chat,
                'title' => 'Chat ' . date('d M Y, H:i')
            ];
        }

        // Update database: clear current chat, simpan ke history
        $this->Al_advisor_model->update($id, [
            'riwayat_chat' => json_encode([]),
            'chat_history' => json_encode($chat_history)
        ]);

        echo json_encode([
            'status' => 'ok', 
            'message' => 'Chat baru dimulai',
            'chat_history' => $chat_history
        ]);
    }
    
    /**
     * Get chat history for sidebar
     */
    public function get_chat_history($id = null)
    {
        // Clean all output buffers
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        header('Content-Type: application/json');
        
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID not provided']);
            return;
        }
        
        $id_user = $this->session->userdata('id_user');
        $advisor = $this->Al_advisor_model->get($id);
        
        if (!$advisor || $advisor->id_user != $id_user) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }
        
        $chat_history = [];
        if (!empty($advisor->chat_history)) {
            $history = json_decode($advisor->chat_history, true);
            if (is_array($history)) {
                $chat_history = $history;
            }
        }
        
        echo json_encode([
            'status' => 'ok',
            'chat_history' => $chat_history
        ]);
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
        // Disable error display untuk AJAX endpoint
        @ini_set('display_errors', '0');
        error_reporting(0);
        
        // Clear ALL output buffers to prevent BOM or whitespace
        while (ob_get_level()) {
            ob_end_clean();
        }
        
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

        log_message('info', '[Advisor] Calling Gemini API for advisor id: ' . $id);

        // Gunakan fungsi call_gemini_response yang sudah include riwayat chat
        $reply = $this->call_gemini_response($advisor, $message);

        log_message('info', '[Advisor] Gemini response length: ' . strlen($reply) . ' chars');
        log_message('debug', '[Advisor] Gemini response preview: ' . substr($reply, 0, 200));

        // Accept any non-empty reply from Gemini as valid (lebih permisif: minimal 10 karakter)
        $valid = ($reply && strlen(trim($reply)) > 10);
        $source = 'gemini';

        // If primary failed or reply too short, try one more time
        if (!$valid) {
            log_message('info', 'Gemini primary response empty/short (length: ' . strlen($reply) . '), attempting retry');
            sleep(2); // Wait before retry
            $reply = $this->call_gemini_response($advisor, $message);
            $valid = ($reply && strlen(trim($reply)) > 10);
            
            if ($valid) {
                log_message('info', 'Gemini retry successful');
            }
        }

        // Jika tetap gagal, gunakan fallback LOKAL yang PASTI berhasil
        if (!$valid) {
            log_message('info', 'Gemini failed after retries; using local fallback for advisor id: '.$id);
            // Use a local fallback responder so the user always gets an answer
            $reply = $this->local_ai_reply($advisor, $message);
            $source = 'fallback';
            
            // Pastikan fallback juga tidak kosong
            if (!$reply || strlen(trim($reply)) < 10) {
                $reply = "Terima kasih atas pertanyaan Anda. Saat ini sistem sedang mengalami gangguan. Namun, berdasarkan data yang Anda input (modal: Rp" . number_format($advisor->modal_usaha, 0, ',', '.') . ", lokasi: {$advisor->lokasi_usaha}), saya sarankan untuk fokus pada bisnis yang sesuai dengan kondisi pasar lokal Anda. Silakan coba lagi beberapa saat atau hubungi admin untuk bantuan lebih lanjut.";
                log_message('error', 'Fallback juga gagal, menggunakan response default');
            }
        }

        // PASTIKAN reply tidak pernah kosong sebelum disimpan
        if (empty(trim($reply))) {
            $reply = "Terima kasih atas pertanyaan Anda. Saat ini sistem sedang memproses permintaan tinggi. Silakan coba lagi dalam beberapa saat.";
            $source = 'default';
            log_message('error', 'Reply masih kosong setelah semua retry, menggunakan default message');
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
            'source' => $source // 'gemini', 'fallback', or 'default'
        ];
        
        log_message('info', 'Sending response: ' . json_encode(['status' => $response['status'], 'reply_length' => strlen($reply), 'source' => $source]));
        log_message('debug', 'Full response JSON: ' . substr(json_encode($response, JSON_UNESCAPED_UNICODE), 0, 500));
        
        // Clean all buffers and send only JSON
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        $jsonOutput = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        
        // Pastikan tidak ada karakter aneh sebelum output JSON
        if (ob_get_length()) ob_clean();
        
        echo $jsonOutput;
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

        ATURAN KONTEN:
        - Gunakan bahasa Indonesia yang jelas dan profesional
        - Jawaban maksimal 5 paragraf atau 10 poin
        - Fokus pada solusi praktis dan actionable
        - Jangan menyebut kata 'AI' atau 'Gemini'
        - Berikan jawaban yang BERVARIASI dan KREATIF untuk setiap pertanyaan
        - Hindari pengulangan jawaban yang sama persis
        
        ATURAN FORMATTING (PENTING):
        - WAJIB gunakan Markdown formatting
        - Gunakan **bold** untuk poin-poin PENTING
        - Gunakan bullet points (-) untuk daftar/list
        - Gunakan numbering (1. 2. 3.) untuk langkah-langkah
        - Pisahkan paragraf dengan line break
        - Gunakan ## untuk sub-judul jika perlu
        - Contoh format yang baik:
          
          **Modal Rp 5 juta cocok untuk:**
          1. Warung makan sederhana
          2. Toko kelontong
          3. Usaha jasa
          
          **Tips sukses:**
          - Fokus pada 1-2 produk dulu
          - Catat pendapatan harian
          - Evaluasi setiap minggu
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

        log_message('info', '[Advisor] Prompt length: ' . strlen($finalPrompt) . ' chars');
        
        try {
            $response = $this->gemini->generate($finalPrompt);
            
            if (!$response) {
                log_message('error', '[Advisor] Gemini returned NULL response');
                return '';
            }
            
            log_message('info', '[Advisor] Gemini success, response: ' . strlen($response) . ' chars');
            return $response;
            
        } catch (Exception $e) {
            log_message('error', '[Advisor] Gemini exception: ' . $e->getMessage());
            return '';
        }
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


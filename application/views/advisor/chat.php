<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Chat AI Advisor</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <style>
    :root{--blue1:#0b6ea8;--blue2:#27b0e3;--bg:#f1f8fb;--header-height:86px}
    *{box-sizing:border-box;margin:0;padding:0}
    body{margin:0;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto;background:#f8fafc;color:#0f1724;overflow-x:hidden}
    .hero{background:linear-gradient(90deg,var(--blue1),var(--blue2));padding:20px 28px;color:#fff;display:flex;align-items:center;gap:14px;position:fixed;top:0;left:0;right:0;height:var(--header-height);z-index:100;box-shadow:0 2px 16px rgba(0,0,0,0.1)}
    .robot{width:50px;height:50px;background:#fff;border-radius:12px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(2,6,23,0.08);flex-shrink:0}
    .robot svg{width:30px;height:30px}
    .title{font-size:18px;font-weight:700;margin:0}
    .subtitle{font-size:13px;opacity:0.95;margin:0}
    .logout-btn{background:rgba(255,255,255,0.15);color:#fff;padding:8px 16px;border-radius:8px;text-decoration:none;font-weight:700;border:1px solid rgba(255,255,255,0.2);font-size:13px;transition:all 0.3s;flex-shrink:0}
    .logout-btn:hover{background:#fff;color:var(--blue1);transform:translateY(-1px)}

    .wrap{max-width:920px;margin:20px auto;padding:0 20px}
    .chat-window{background:transparent;padding:20px 12px;min-height:420px}

    .bubble{display:inline-block;max-width:75%;padding:16px 20px;border-radius:16px;margin:0;box-shadow:0 2px 8px rgba(0,0,0,0.04);line-height:1.6;word-wrap:break-word}
    .bubble.ai{background:#fff;border:1px solid #e6eef6;align-self:flex-start;border-bottom-left-radius:4px}
    .bubble.ai p{margin:0 0 12px 0;line-height:1.7}
    .bubble.ai p:last-child{margin-bottom:0}
    .bubble.ai strong{color:#0b6ea8;font-weight:700}
    .bubble.ai em{font-style:italic;color:#64748b}
    .bubble.ai ul,.bubble.ai ol{margin:12px 0;padding-left:24px}
    .bubble.ai li{margin:6px 0;line-height:1.6}
    .bubble.ai code{background:#f1f5f9;padding:2px 6px;border-radius:4px;font-size:13px;font-family:monospace;color:#0b6ea8}
    .bubble.ai pre{background:#f8fafc;padding:12px;border-radius:8px;overflow-x:auto;margin:12px 0}
    .bubble.ai pre code{background:transparent;padding:0}
    .bubble.ai blockquote{border-left:3px solid #27b0e3;padding-left:12px;margin:12px 0;color:#64748b;font-style:italic}
    .bubble.ai h1,.bubble.ai h2,.bubble.ai h3{color:#0f1724;margin:16px 0 8px 0;font-weight:700}
    .bubble.ai h1{font-size:18px}
    .bubble.ai h2{font-size:16px}
    .bubble.ai h3{font-size:14px}
    .bubble.user{background:linear-gradient(135deg,#0b6ea8 0%,#27b0e3 100%);color:#fff;align-self:flex-end;margin-left:auto;border-bottom-right-radius:4px}
    .bubble.user .msg-time{color:rgba(255,255,255,0.85)}

    .chat-list{display:flex;flex-direction:column;gap:16px;padding:20px 0}

    .input-area{position:fixed;left:280px;right:0;bottom:0;display:flex;justify-content:center;background:linear-gradient(180deg,transparent 0%,rgba(248,250,252,0.95) 15%,#f8fafc 100%);padding:20px 24px;backdrop-filter:blur(8px);z-index:90;border-top:1px solid rgba(230,238,246,0.5);transition:left 0.3s ease}
    .input-area.expanded{left:0}
    .input-inner{width:100%;max-width:900px;display:flex;gap:12px;padding:0}
    .input-box{flex:1}
    .input-box input{width:100%;padding:16px 20px;border-radius:12px;border:2px solid #e6eef6;background:#fff;font-size:15px;transition:all 0.3s;box-shadow:0 2px 8px rgba(0,0,0,0.04)}
    .input-box input:focus{outline:none;border-color:#27b0e3;box-shadow:0 4px 16px rgba(39,176,227,0.15)}
    .send-btn{background:linear-gradient(90deg,var(--blue1),var(--blue2));color:#fff;border:none;padding:14px 28px;border-radius:12px;font-weight:700;cursor:pointer;transition:all 0.3s;box-shadow:0 4px 12px rgba(11,110,168,0.2);font-size:15px}
    .send-btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(11,110,168,0.3)}
    .send-btn:disabled{opacity:0.7;cursor:not-allowed;transform:none}

    /* spinner inside send button */
    .send-btn .spinner{width:16px;height:16px;border:2px solid rgba(255,255,255,0.35);border-top-color:#fff;border-radius:50%;display:inline-block;margin-left:10px;vertical-align:middle;opacity:0;transform:scale(0.9);transition:opacity .12s,transform .12s}
    .send-btn.loading .spinner{opacity:1;transform:scale(1);animation:spin 1s linear infinite}
    @keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}

    .msg-time{display:block;font-size:11px;color:#94a3b8;margin-top:6px}

    /* SIDEBAR */
    .layout{display:flex;padding-top:var(--header-height);min-height:100vh;background:#f8fafc}
    .sidebar{width:280px;background:#fff;border-right:1px solid #e6eef6;position:fixed;left:0;top:var(--header-height);bottom:0;overflow-y:auto;padding:20px;z-index:50;transition:transform 0.3s ease,opacity 0.3s ease}
    .sidebar.closed{transform:translateX(-100%);opacity:0}
    .sidebar-title{font-size:12px;font-weight:700;color:#64748b;margin-bottom:12px;display:flex;align-items:center;gap:8px;text-transform:uppercase;letter-spacing:0.5px}
    .chat-history{display:flex;flex-direction:column;gap:6px}
    .history-item{padding:12px 14px;border-radius:10px;background:#f8fafc;cursor:pointer;transition:all 0.2s;border:1px solid transparent}
    .history-item:hover{background:#e9f5fa;border-color:rgba(39,176,227,0.3)}
    .history-item.active{background:linear-gradient(135deg,#e9f5fa 0%,#daf2fb 100%);border-color:#27b0e3;box-shadow:0 2px 8px rgba(39,176,227,0.15)}
    .history-title{font-size:13px;font-weight:600;color:#0f1724;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .history-time{font-size:11px;color:#94a3b8}
    .new-chat-btn{width:100%;padding:12px;border-radius:10px;background:linear-gradient(90deg,var(--blue1),var(--blue2));color:#fff;border:none;font-weight:700;cursor:pointer;margin-bottom:20px;transition:all 0.3s;font-size:14px}
    .new-chat-btn:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(11,110,168,0.25)}
    
    /* MAIN CONTENT */
    .main-content{flex:1;margin-left:280px;display:flex;flex-direction:column;background:#f8fafc;min-height:calc(100vh - var(--header-height));transition:margin-left 0.3s ease}
    .main-content.expanded{margin-left:0}
    
    /* TOGGLE BUTTON */
    .sidebar-toggle{background:rgba(255,255,255,0.15);color:#fff;padding:8px;border-radius:8px;border:1px solid rgba(255,255,255,0.2);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.3s;width:40px;height:40px;flex-shrink:0}
    .sidebar-toggle:hover{background:#fff;color:var(--blue1);transform:scale(1.05)}
    .sidebar-toggle svg{width:20px;height:20px}
    
    /* CHAT AREA */
    .wrap{flex:1;padding:24px 40px 160px 40px;max-width:900px;margin:0 auto;width:100%}
    .chat-window{background:transparent;padding:0;min-height:auto}
    .chat-list{display:flex;flex-direction:column;gap:16px;padding:0}
    
    /* SHARE BUTTON */
    .share-btn{background:rgba(255,255,255,0.12);color:#fff;padding:8px 16px;border-radius:8px;border:1px solid rgba(255,255,255,0.12);font-weight:700;cursor:pointer;display:flex;align-items:center;gap:8px;transition:all 0.3s}
    .share-btn:hover{background:#fff;color:var(--blue1)}
    .share-btn svg{width:18px;height:18px}
    
    /* SHARE MODAL */
    .modal-overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:1000;align-items:center;justify-content:center}
    .modal-overlay.active{display:flex}
    .modal{background:#fff;border-radius:16px;padding:32px;max-width:480px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    .modal-title{font-size:20px;font-weight:700;margin-bottom:8px}
    .modal-subtitle{font-size:14px;color:#64748b;margin-bottom:20px}
    .share-options{display:flex;flex-direction:column;gap:12px}
    .share-option{padding:14px;border-radius:10px;border:2px solid #e6eef6;display:flex;align-items:center;gap:12px;cursor:pointer;transition:all 0.3s}
    .share-option:hover{border-color:var(--blue2);background:#f8f9fa}
    .share-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center}
    .share-whatsapp .share-icon{background:#25D366}
    .share-telegram .share-icon{background:#0088cc}
    .share-copy .share-icon{background:#667eea}
    .share-label{font-weight:600;font-size:15px}
    .modal-close{margin-top:20px;width:100%;padding:12px;border-radius:10px;background:#e9ecef;border:none;font-weight:700;cursor:pointer}
    .modal-close:hover{background:#dee2e6}

    @media (max-width:768px){
      .sidebar{width:100%;position:relative;border-right:none;border-bottom:1px solid #e6eef6;top:0;height:auto;max-height:200px}
      .main-content{margin-left:0}
      .wrap{padding:20px 16px 160px 16px}
      .input-area{left:0}
      .bubble{max-width:85%}
      .layout{flex-direction:column}
      .hero{padding:16px 20px}
      .title{font-size:16px}
      .subtitle{font-size:12px}
    }
  </style>
</head>
<body>
  <div class="hero">
    <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
    <div class="robot">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="7" width="18" height="11" rx="2" stroke="#0b6ea8" stroke-width="1.2"/><circle cx="8.5" cy="12" r="0.9" fill="#0b6ea8"/><circle cx="15.5" cy="12" r="0.9" fill="#0b6ea8"/><rect x="10" y="3" width="4" height="3" rx="1" fill="#fff" stroke="#0b6ea8" stroke-width="1.2"/></svg>
    </div>
    <div style="flex:1">
      <div class="title">AI Business Advisor</div>
      <div class="subtitle">Diskusi hasil rekomendasi dan tanyakan apa saja</div>
    </div>
    <div style="display:flex;gap:12px;align-items:center">
      <button class="share-btn" id="shareBtn">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
        </svg>
        Share
      </button>
      <a href="<?= site_url('auth/dashboard') ?>" class="logout-btn">Dashboard</a>
    </div>
  </div>

  <div class="layout">
    
    <!-- SIDEBAR -->
    <div class="sidebar">
      <button class="new-chat-btn" id="newChatBtn">
        <svg style="width:18px;height:18px;display:inline-block;margin-right:6px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Chat Baru
      </button>
      
      <div class="sidebar-title">
        <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Riwayat Chat
      </div>
      
      <div class="chat-history" id="chatHistory">
        <div class="history-item active">
          <div class="history-title">Chat saat ini</div>
          <div class="history-time"><?= date('d M Y, H:i') ?></div>
        </div>
        <?php 
        $chat_history = [];
        if (!empty($advisor->chat_history)) {
            $history = json_decode($advisor->chat_history, true);
            if (is_array($history)) {
                $chat_history = array_reverse($history); // Terbaru di atas
            }
        }
        foreach ($chat_history as $idx => $hist): 
        ?>
        <div class="history-item" data-index="<?= $idx ?>">
          <div class="history-title"><?= htmlspecialchars($hist['title'] ?? 'Chat Lama') ?></div>
          <div class="history-time"><?= isset($hist['timestamp']) ? date('d M Y, H:i', strtotime($hist['timestamp'])) : '' ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    
    <!-- MAIN CONTENT -->
    <div class="main-content">
      <div class="wrap">
        <div class="chat-window" id="chatWindow">
          <div class="chat-list" id="chatList">
        <?php if (!empty($chat) && is_array($chat)): ?>
          <?php foreach ($chat as $m): ?>
            <?php if ($m['from'] === 'ai'): ?>
              <div class="bubble ai">
                <?php echo nl2br(htmlspecialchars($m['message'])); ?>
                <span class="msg-time"><?php echo isset($m['time']) ? $m['time'] : ''; ?></span>
              </div>
            <?php else: ?>
              <div class="bubble user">
                <?php echo nl2br(htmlspecialchars($m['message'])); ?>
                <span class="msg-time"><?php echo isset($m['time']) ? $m['time'] : ''; ?></span>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="bubble ai">Halo! Saya adalah AI Business Advisor. Silakan tanyakan sesuatu atau pilih <strong>Analisis & Rekomendasi</strong> untuk memulai.</div>
        <?php endif; ?>
          </div>
        </div>
      </div>
      
      <div class="input-area">
    <div class="input-inner">
      <div class="input-box">
        <input type="text" id="chatInput" placeholder="Tanyakan apa saja" aria-label="Tanyakan apa saja">
      </div>
        <button type="button" class="send-btn" id="sendBtn">Kirim <span class="spinner" aria-hidden="true"></span></button>
      </div>
    </div>
    
    </div>
  </div>

  <!-- SHARE MODAL -->
  <div class="modal-overlay" id="shareModal">
    <div class="modal">
      <div class="modal-title">Bagikan Percakapan</div>
      <div class="modal-subtitle">Pilih cara berbagi percakapan dengan AI Advisor</div>
      
      <div class="share-options">
        <div class="share-option share-whatsapp" onclick="shareVia('whatsapp')">
          <div class="share-icon">
            <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
          </div>
          <div class="share-label">WhatsApp</div>
        </div>
        
        <div class="share-option share-telegram" onclick="shareVia('telegram')">
          <div class="share-icon">
            <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
              <path d="m12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
            </svg>
          </div>
          <div class="share-label">Telegram</div>
        </div>
        
        <div class="share-option share-copy" onclick="shareVia('copy')">
          <div class="share-icon">
            <svg width="24" height="24" fill="white" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
          </div>
          <div class="share-label">Salin Link</div>
        </div>
      </div>
      
      <button class="modal-close" onclick="closeShareModal()">Tutup</button>
    </div>
  </div>

 <script>
  (function () {
    var sendBtn = document.getElementById('sendBtn');
    var chatInput = document.getElementById('chatInput');
    var chatList = document.getElementById('chatList');
    var advisorId = '<?php echo $advisor->id_ide; ?>';

    function appendBubble(from, text) {
      var div = document.createElement('div');
      div.className = 'bubble ' + (from === 'ai' ? 'ai' : 'user');
      
      // Render markdown untuk AI, plain text untuk user
      var content = from === 'ai' ? marked.parse(text) : text.replace(/\n/g, '<br>');
      
      div.innerHTML = content +
        '<span class="msg-time">' + new Date().toLocaleString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'}) + '</span>';
      chatList.appendChild(div);
      
      // Smooth scroll ke bawah
      setTimeout(function() {
        div.scrollIntoView({ behavior: 'smooth', block: 'end' });
      }, 100);
    }

    function sendMessageToServer(message, onSuccess, onFailure) {
      return fetch("<?= site_url('advisor/send_message') ?>", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: new URLSearchParams({id: advisorId, message: message})
      }).then(function (res) { return res.json(); });
    }

    // allow Enter key to send without page refresh
    chatInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        sendBtn.click();
      }
    });

    function setLoading(state) {
      sendBtn.disabled = !!state;
      if (state) sendBtn.classList.add('loading'); else sendBtn.classList.remove('loading');
    }

    sendBtn.addEventListener('click', function () {
      var msg = chatInput.value.trim();
      if (!msg) return;
      // show user's message immediately
      appendBubble('user', msg);
      chatInput.value = '';
      setLoading(true);

      // add a temporary AI 'typing' bubble that will be replaced
      var typingBubble = document.createElement('div');
      typingBubble.className = 'bubble ai';
      typingBubble.id = 'pendingAi';
      typingBubble.innerHTML = '<em style="color:#94a3b8">💭 Sedang berpikir...</em>' + '<span class="msg-time"></span>';
      chatList.appendChild(typingBubble);
      setTimeout(function() {
        typingBubble.scrollIntoView({ behavior: 'smooth', block: 'end' });
      }, 100);

      sendMessageToServer(msg).then(function (data) {
        setLoading(false);
        console.log('Response from server:', data); // DEBUG
        console.log('Reply exists:', !!data.reply, 'Length:', data.reply ? data.reply.length : 0); // DEBUG
        console.log('Status:', data.status, 'Source:', data.source); // DEBUG
        
        var pending = document.getElementById('pendingAi');
        
        // Cek apakah response valid - perbaiki kondisi untuk menerima fallback
        if (data.status !== 'ok' || !data.reply || data.reply.trim().length < 5) {
          // replace typing bubble with fallback + retry
          if (pending) pending.parentNode.removeChild(pending);
          var bubble = document.createElement('div');
          bubble.className = 'bubble ai';
          bubble.innerHTML = 'Maaf, AI sedang sibuk. Silakan coba lagi.' +
            ' <button style="margin-left:12px;padding:6px 10px;border-radius:8px;border:none;background:#1C6494;color:#fff;cursor:pointer" id="retryBtn">Coba lagi</button>' +
            '<span class="msg-time">' + new Date().toLocaleString() + '</span>';
          chatList.appendChild(bubble);
          document.getElementById('retryBtn').addEventListener('click', function () {
            this.disabled = true;
            // re-insert typing bubble
            var tb = document.createElement('div');
            tb.className = 'bubble ai';
            tb.id = 'pendingAi';
            tb.innerHTML = '<em>Sedang menulis...</em>' + '<span class="msg-time"></span>';
            chatList.appendChild(tb);
            window.scrollTo(0, document.body.scrollHeight);
            setLoading(true);
            sendMessageToServer(msg).then(function (d2) {
              setLoading(false);
              if (d2.status === 'ok') {
                var p = document.getElementById('pendingAi'); if (p) p.parentNode.removeChild(p);
                appendBubble('ai', d2.reply);
              } else {
                if (document.getElementById('pendingAi')) document.getElementById('pendingAi').parentNode.removeChild(document.getElementById('pendingAi'));
                appendBubble('ai', 'Maaf, AI masih sibuk. Silakan coba beberapa saat lagi.');
              }
            }).catch(function (){
              setLoading(false);
              if (document.getElementById('pendingAi')) document.getElementById('pendingAi').parentNode.removeChild(document.getElementById('pendingAi'));
              appendBubble('ai', 'Maaf, AI masih sibuk. Silakan coba beberapa saat lagi.');
            });
          });
          return;
        }
        // success: replace typing bubble with actual reply
        if (pending) pending.parentNode.removeChild(pending);
        appendBubble('ai', data.reply);
      }).catch(function (err) {
        setLoading(false);
        var pending = document.getElementById('pendingAi'); if (pending) pending.parentNode.removeChild(pending);
        appendBubble('ai', 'Maaf, AI sedang sibuk. Silakan coba lagi.');
        console.error(err);
      });
    });
    
    // SHARE FUNCTIONALITY
    var shareBtn = document.getElementById('shareBtn');
    var shareModal = document.getElementById('shareModal');
    
    shareBtn.addEventListener('click', function() {
      shareModal.classList.add('active');
    });
    
    window.closeShareModal = function() {
      shareModal.classList.remove('active');
    };
    
    shareModal.addEventListener('click', function(e) {
      if (e.target === shareModal) closeShareModal();
    });
    
    window.shareVia = function(platform) {
      var chatText = '';
      var bubbles = document.querySelectorAll('.bubble');
      bubbles.forEach(function(b) {
        var text = b.innerText.replace(/\d{1,2}\/\d{1,2}\/\d{4}.*$/m, '').trim();
        chatText += (b.classList.contains('ai') ? 'AI: ' : 'Saya: ') + text + '\n\n';
      });
      
      var url = window.location.href;
      var text = 'Chat dengan AI Business Advisor:\n\n' + chatText;
      
      if (platform === 'whatsapp') {
        window.open('https://wa.me/?text=' + encodeURIComponent(text + '\n' + url), '_blank');
      } else if (platform === 'telegram') {
        window.open('https://t.me/share/url?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text), '_blank');
      } else if (platform === 'copy') {
        navigator.clipboard.writeText(text + '\n\n' + url).then(function() {
          alert('Link dan percakapan berhasil disalin!');
        });
      }
      closeShareModal();
    };
    
    // NEW CHAT FUNCTIONALITY
    var newChatBtn = document.getElementById('newChatBtn');
    var advisorId = '<?php echo $advisor->id_ide; ?>';
    
    // Function to update chat history sidebar
    function updateChatHistory(history) {
      var chatHistory = document.getElementById('chatHistory');
      if (!chatHistory) return;
      
      // Clear and rebuild
      chatHistory.innerHTML = '<div class="history-item active"><div class="history-title">Chat saat ini</div><div class="history-time">' + new Date().toLocaleString('id-ID', {day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'}) + '</div></div>';
      
      // Add history items (reverse to show newest first)
      var reversed = history.slice().reverse();
      reversed.forEach(function(hist, idx) {
        var item = document.createElement('div');
        item.className = 'history-item';
        item.dataset.index = idx;
        
        var title = document.createElement('div');
        title.className = 'history-title';
        title.textContent = hist.title || 'Chat Lama';
        
        var time = document.createElement('div');
        time.className = 'history-time';
        time.textContent = hist.timestamp ? new Date(hist.timestamp).toLocaleString('id-ID', {day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'}) : '';
        
        item.appendChild(title);
        item.appendChild(time);
        chatHistory.appendChild(item);
      });
    }
    
    newChatBtn.addEventListener('click', function() {
      if (confirm('Mulai chat baru? Riwayat chat saat ini akan disimpan.')) {
        newChatBtn.disabled = true;
        newChatBtn.innerHTML = '<svg style="width:18px;height:18px;display:inline-block;margin-right:6px;animation:spin 1s linear infinite" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" opacity="0.75"/></svg>Loading...';
        
        fetch('<?= site_url('advisor/new_chat') ?>/' + advisorId, {
          method: 'POST'
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
          if (data.status === 'ok') {
            // Update sidebar with new history
            if (data.chat_history && Array.isArray(data.chat_history)) {
              updateChatHistory(data.chat_history);
            }
            // Clear chat display
            chatList.innerHTML = '';
            newChatBtn.disabled = false;
            newChatBtn.innerHTML = '<svg style="width:18px;height:18px;display:inline-block;margin-right:6px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>Chat Baru';
          } else {
            alert('Gagal membuat chat baru: ' + (data.message || 'Unknown error'));
            newChatBtn.disabled = false;
            newChatBtn.innerHTML = '<svg style="width:18px;height:18px;display:inline-block;margin-right:6px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>Chat Baru';
          }
        })
        .catch(function(err) {
          alert('Error: ' + err.message);
          newChatBtn.disabled = false;
          newChatBtn.innerHTML = '<svg style="width:18px;height:18px;display:inline-block;margin-right:6px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>Chat Baru';
        });
      }
    });
    
    // SIDEBAR TOGGLE FUNCTIONALITY
    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebar = document.querySelector('.sidebar');
    var mainContent = document.querySelector('.main-content');
    var inputArea = document.querySelector('.input-area');
    var sidebarOpen = true;
    
    // Load sidebar state from localStorage
    var savedState = localStorage.getItem('sidebarOpen');
    if (savedState === 'false') {
      sidebar.classList.add('closed');
      mainContent.classList.add('expanded');
      inputArea.classList.add('expanded');
      sidebarOpen = false;
    }
    
    sidebarToggle.addEventListener('click', function() {
      sidebarOpen = !sidebarOpen;
      
      if (sidebarOpen) {
        sidebar.classList.remove('closed');
        mainContent.classList.remove('expanded');
        inputArea.classList.remove('expanded');
      } else {
        sidebar.classList.add('closed');
        mainContent.classList.add('expanded');
        inputArea.classList.add('expanded');
      }
      
      // Save state to localStorage
      localStorage.setItem('sidebarOpen', sidebarOpen);
    });
  })();
</script>
</body>
</html>

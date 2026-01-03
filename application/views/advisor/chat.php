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
  <style>
    :root{--blue1:#0b6ea8;--blue2:#27b0e3;--bg:#f1f8fb}
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto;background:linear-gradient(180deg,#e9f5fa 0%,#f6fbfc 100%);color:#0f1724}
    .hero{background:linear-gradient(90deg,var(--blue1),var(--blue2));padding:28px;border-radius:0 0 12px 12px;color:#fff;display:flex;align-items:center;gap:14px}
    .robot{width:56px;height:56px;background:#fff;border-radius:12px;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 18px rgba(2,6,23,0.12)}
    .robot svg{width:34px;height:34px}
    .title{font-size:20px;font-weight:700}
    .subtitle{font-size:14px;opacity:0.9}
    .logout-btn{background:rgba(255,255,255,0.12);color:#fff;padding:8px 12px;border-radius:8px;text-decoration:none;font-weight:700;border:1px solid rgba(255,255,255,0.12)}
    .logout-btn:hover{background:#fff;color:var(--blue1)}

    .wrap{max-width:920px;margin:20px auto;padding:0 20px}
    .chat-window{background:transparent;padding:20px 12px;min-height:420px}

    .bubble{display:inline-block;max-width:70%;padding:14px 18px;border-radius:12px;margin:8px 0;box-shadow:0 4px 12px rgba(2,6,23,0.04)}
    .bubble.ai{background:#fff;border:1px solid rgba(2,6,23,0.04);align-self:flex-start}
    .bubble.user{background:#fff;width:auto;border:1px solid rgba(2,6,23,0.04);align-self:flex-end;margin-left:auto}

    .chat-list{display:flex;flex-direction:column;gap:8px}

    .input-area{position:fixed;left:0;right:0;bottom:18px;display:flex;justify-content:center}
    .input-inner{width:100%;max-width:820px;display:flex;gap:12px;padding:12px;background:transparent}
    .input-box{flex:1}
    .input-box input{width:100%;padding:16px;border-radius:12px;border:1px solid #e6eef6;background:#fff;font-size:15px}
    .send-btn{background:linear-gradient(90deg,var(--blue1),var(--blue2));color:#fff;border:none;padding:12px 18px;border-radius:12px;font-weight:700;cursor:pointer}

    /* spinner inside send button */
    .send-btn .spinner{width:16px;height:16px;border:2px solid rgba(255,255,255,0.35);border-top-color:#fff;border-radius:50%;display:inline-block;margin-left:10px;vertical-align:middle;opacity:0;transform:scale(0.9);transition:opacity .12s,transform .12s}
    .send-btn.loading .spinner{opacity:1;transform:scale(1);animation:spin 1s linear infinite}
    @keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}

    .msg-time{display:block;font-size:11px;color:#94a3b8;margin-top:6px}

    @media (max-width:640px){.bubble{max-width:86%}.hero{padding:18px}}
  </style>
</head>
<body>
  <div class="hero">
    <div class="robot">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="7" width="18" height="11" rx="2" stroke="#0b6ea8" stroke-width="1.2"/><circle cx="8.5" cy="12" r="0.9" fill="#0b6ea8"/><circle cx="15.5" cy="12" r="0.9" fill="#0b6ea8"/><rect x="10" y="3" width="4" height="3" rx="1" fill="#fff" stroke="#0b6ea8" stroke-width="1.2"/></svg>
    </div>
    <div>
      <div class="title">AI Business Advisor</div>
      <div class="subtitle">Diskusi hasil rekomendasi dan tanyakan apa saja</div>
    </div>
    <div style="margin-left:auto">
      <a href="<?= site_url('landing') ?>" class="logout-btn">Logout</a>
    </div>
  </div>

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

 <script>
  (function () {
    var sendBtn = document.getElementById('sendBtn');
    var chatInput = document.getElementById('chatInput');
    var chatList = document.getElementById('chatList');
    var advisorId = '<?php echo $advisor->id_ide; ?>';

    function appendBubble(from, text) {
      var div = document.createElement('div');
      div.className = 'bubble ' + (from === 'ai' ? 'ai' : 'user');
      div.innerHTML = text.replace(/\n/g, '<br>') +
        '<span class="msg-time">' + new Date().toLocaleString() + '</span>';
      chatList.appendChild(div);
      window.scrollTo(0, document.body.scrollHeight);
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
      typingBubble.innerHTML = '<em>Sedang menulis...</em>' + '<span class="msg-time"></span>';
      chatList.appendChild(typingBubble);
      window.scrollTo(0, document.body.scrollHeight);

      sendMessageToServer(msg).then(function (data) {
        setLoading(false);
        console.log('Response from server:', data); // DEBUG
        var pending = document.getElementById('pendingAi');
        if (data.status !== 'ok' || !data.reply) {
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
  })();
</script>
</body>
</html>

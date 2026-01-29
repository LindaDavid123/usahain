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
    .hero{background:linear-gradient(135deg,#0b6ea8 0%,#1a8dd5 50%,#27b0e3 100%);padding:16px 32px;color:#fff;display:flex;align-items:center;gap:16px;position:fixed;top:0;left:0;right:0;height:var(--header-height);z-index:100;box-shadow:0 4px 24px rgba(11,110,168,0.25),inset 0 1px 0 rgba(255,255,255,0.1);backdrop-filter:blur(12px);border-bottom:2px solid rgba(255,255,255,0.08)}
    .title{font-size:19px;font-weight:800;margin:0;letter-spacing:-0.5px;text-shadow:0 2px 4px rgba(0,0,0,0.15);animation:slideInTitle 0.6s ease-out;position:relative}
    @keyframes slideInTitle{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}
    .subtitle{font-size:12px;opacity:0.92;margin:3px 0 0 0;font-weight:500;letter-spacing:0.3px;animation:slideInSubtitle 0.8s ease-out;position:relative}
    @keyframes slideInSubtitle{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}
    .logout-btn{background:rgba(255,255,255,0.12);color:#fff;padding:8px;border-radius:10px;text-decoration:none;font-weight:500;border:1px solid rgba(255,255,255,0.2);font-size:13px;transition:all 0.3s ease;flex-shrink:0;display:flex;align-items:center;justify-content:center;width:40px;height:40px;backdrop-filter:blur(8px)}
    .logout-btn:hover{background:rgba(255,255,255,0.2);border-color:rgba(255,255,255,0.4);transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,0.15)}
    .logout-btn:active{transform:translateY(0)}
    .logout-btn svg{width:18px;height:18px}

    .wrap{max-width:920px;margin:20px auto;padding:0 20px}
    .chat-window{background:transparent;padding:20px 12px;min-height:420px}

    .bubble{display:inline-block;max-width:75%;padding:14px 18px;border-radius:16px;margin:0;box-shadow:0 2px 8px rgba(0,0,0,0.04);line-height:1.6;word-wrap:break-word;animation:slideUp 0.3s ease}
    @keyframes slideUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
    .bubble.ai{background:#fff;border:1px solid #e6eef6;align-self:flex-start;border-bottom-left-radius:4px}
    .bubble.ai p{margin:0 0 12px 0;line-height:1.7;color:#0f1724}
    .bubble.ai p:last-child{margin-bottom:0}
    .bubble.ai strong{color:#0b6ea8;font-weight:700}
    .bubble.ai em{font-style:italic;color:#64748b}
    .bubble.ai ul,.bubble.ai ol{margin:12px 0;padding-left:24px}
    .bubble.ai li{margin:6px 0;line-height:1.6;color:#0f1724}
    .bubble.ai code{background:#f1f5f9;padding:3px 8px;border-radius:4px;font-size:13px;font-family:'Monaco','Courier New',monospace;color:#0b6ea8;font-weight:600}
    .bubble.ai pre{background:#f8fafc;padding:14px;border-radius:8px;overflow-x:auto;margin:12px 0;border:1px solid #e6eef6}
    .bubble.ai pre code{background:transparent;padding:0;font-weight:400}
    .bubble.ai blockquote{border-left:4px solid #27b0e3;padding-left:14px;margin:12px 0;color:#64748b;font-style:italic;background:rgba(39,176,227,0.05);padding:10px 14px;border-radius:4px}
    .bubble.ai h1,.bubble.ai h2,.bubble.ai h3{color:#0f1724;margin:16px 0 8px 0;font-weight:700}
    .bubble.ai h1{font-size:18px}
    .bubble.ai h2{font-size:16px}
    .bubble.ai h3{font-size:14px}
    .bubble.user{background:linear-gradient(135deg,#0b6ea8 0%,#27b0e3 100%);color:#fff;align-self:flex-end;margin-left:auto;border-bottom-right-radius:4px;box-shadow:0 4px 12px rgba(11,110,168,0.15)}
    .bubble.user .msg-time{color:rgba(255,255,255,0.85)}

    .chat-list{display:flex;flex-direction:column;gap:16px;padding:20px 0}

    .input-area{position:fixed;left:280px;right:0;bottom:0;display:flex;justify-content:center;background:linear-gradient(180deg,transparent 0%,rgba(248,250,252,0.95) 15%,#f8fafc 100%);padding:20px 24px;backdrop-filter:blur(12px);z-index:90;border-top:2px solid rgba(230,238,246,0.6);transition:left 0.3s ease}
    .input-area.expanded{left:0}
    .input-inner{width:100%;max-width:900px;display:flex;gap:12px;padding:0}
    .input-box{flex:1}
    .input-box input{width:100%;padding:14px 18px;border-radius:12px;border:2px solid #e6eef6;background:#fff;font-size:15px;transition:all 0.3s;box-shadow:0 2px 8px rgba(0,0,0,0.04);font-weight:500}
    .input-box input::placeholder{color:#a0aec0;font-weight:500}
    .input-box input:focus{outline:none;border-color:#27b0e3;box-shadow:0 4px 16px rgba(39,176,227,0.15);background:#fff}
    .send-btn{background:linear-gradient(135deg,#0b6ea8 0%,#27b0e3 100%);color:#fff;border:none;padding:14px;border-radius:12px;font-weight:700;cursor:pointer;transition:all 0.3s;box-shadow:0 4px 12px rgba(11,110,168,0.2);display:flex;align-items:center;justify-content:center;width:50px;height:50px;flex-shrink:0;position:relative;overflow:hidden}
    .send-btn svg{width:22px;height:22px;transition:all 0.3s}
    .send-btn:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 6px 20px rgba(11,110,168,0.3);background:linear-gradient(135deg,#084f8a 0%,#1f9dd1 100%)}
    .send-btn:active:not(:disabled){transform:translateY(0)}
    .send-btn:disabled{opacity:0.65;cursor:not-allowed;transform:none}

    /* spinner inside send button */
    .send-btn .spinner{width:16px;height:16px;border:2px solid rgba(255,255,255,0.35);border-top-color:#fff;border-radius:50%;display:none;vertical-align:middle;opacity:0;transform:scale(0.9);transition:opacity .12s,transform .12s}
    .send-btn.loading .spinner{display:inline-block;opacity:1;transform:scale(1);animation:spin 1s linear infinite}
    @keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}

    .msg-time{display:block;font-size:11px;color:#94a3b8;margin-top:6px}

    /* SIDEBAR */
    .layout{display:flex;padding-top:var(--header-height);min-height:100vh;background:#f8fafc}
    .sidebar{width:280px;background:#fff;border-right:1px solid #e6eef6;position:fixed;left:0;top:var(--header-height);bottom:0;overflow-y:auto;padding:0;z-index:50;transition:transform 0.3s ease,opacity 0.3s ease;box-shadow:2px 0 12px rgba(0,0,0,0.04);display:flex;flex-direction:column}
    .sidebar.closed{transform:translateX(-100%);opacity:0}
    .new-chat-btn{width:calc(100% - 28px);padding:10px;border-radius:8px;background:linear-gradient(135deg,#0b6ea8 0%,#27b0e3 100%);color:#fff;border:none;font-weight:700;cursor:pointer;margin:14px;transition:all 0.3s;font-size:13px;box-shadow:0 4px 12px rgba(11,110,168,0.15);display:flex;align-items:center;justify-content:center;gap:6px}
    .new-chat-btn:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(11,110,168,0.25)}
    
    /* SIDEBAR MENU */
    .sidebar-menu{padding:0}
    .menu-item{width:100%;padding:12px 14px;background:none;border:none;color:#0f1724;font-size:14px;cursor:pointer;transition:all 0.2s;display:flex;align-items:center;gap:10px;font-weight:600;text-align:left}
    .menu-item:hover{background:#f5f8fb;color:#0b6ea8}
    .menu-item svg{width:18px;height:18px;flex-shrink:0}
    
    /* CHATS LABEL & HISTORY */
    .chats-label{padding:12px 14px;font-size:12px;font-weight:700;color:#64748b;margin-top:4px}
    
    /* BOTTOM SECTION */
    .sidebar-bottom{border-top:1px solid #e6eef6;padding:16px;display:flex;flex-direction:row;gap:12px;background:#fff;align-items:center}
    .user-profile{display:flex;align-items:center;gap:12px;padding:0;background:transparent;border-radius:0;color:#0f1724;box-shadow:none;transition:all 0.2s;flex:1;min-width:0;border:none}
    .user-profile:hover{background:linear-gradient(135deg,#dff4fb 0%,#d0ecf8 100%);box-shadow:0 4px 12px rgba(11,110,168,0.12)}
    .profile-avatar-small{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#0b6ea8,#27b0e3);display:flex;align-items:center;justify-content:center;font-size:16px;color:#fff;flex-shrink:0;font-weight:700}
    .profile-info{flex:1;min-width:0}
    .profile-name-small{font-size:13px;font-weight:700;color:#0f1724;margin-bottom:2px}
    .profile-plan{font-size:11px;color:#64748b;font-weight:500}
    .upgrade-btn{padding:10px 12px;border-radius:10px;background:linear-gradient(135deg,#fbbf24 0%,#f59e0b 100%);color:#fff;border:none;font-weight:700;cursor:pointer;font-size:12px;transition:all 0.3s;box-shadow:0 2px 8px rgba(251,191,36,0.15);display:flex;align-items:center;justify-content:center;gap:4px;white-space:nowrap;flex-shrink:0}
    .upgrade-btn:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(251,191,36,0.25)}
    .upgrade-btn:active{transform:translateY(0)}
    .sidebar-title{display:none}
    
    /* PROFILE SECTION */
    .profile-card{background:#0b6ea8;border-radius:10px;padding:6px;margin-bottom:6px;color:#fff;text-align:center}
    .profile-avatar{width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,0.2);margin:0 auto 2px;display:flex;align-items:center;justify-content:center;font-size:14px}
    .profile-name{font-weight:700;font-size:9px;margin-bottom:0}
    .profile-email{font-size:7px;opacity:0.85;word-break:break-all}
    
    /* QUICK ACTIONS */
    .quick-actions{display:grid;grid-template-columns:1fr 1fr;gap:3px;margin-bottom:6px}
    .quick-action-btn{padding:4px 2px;border-radius:6px;border:1px solid #cbd5e1;background:#f5f8fb;color:#0b6ea8;font-weight:600;font-size:7px;cursor:pointer;transition:all 0.2s;display:flex;flex-direction:column;align-items:center;gap:1px;text-align:center}
    .quick-action-btn:hover{background:#e0f2fe;border-color:#0b6ea8}
    .quick-action-btn svg{width:11px;height:11px}
    
    /* STATS SECTION */
    .stats-grid{display:grid;grid-template-columns:1fr 1fr;gap:3px;margin-bottom:6px}
    .stat-card{background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:4px;text-align:center}
    .stat-value{font-size:12px;font-weight:700;color:#0b6ea8}
    .stat-label{font-size:7px;color:#0884c7;margin-top:0}
    
    /* SEARCH BOX */
    .search-box{width:100%;padding:4px 6px;border-radius:6px;border:1px solid #cbd5e1;font-size:8px;margin-bottom:6px;transition:all 0.2s;background:#f5f8fb}
    .search-box:focus{outline:none;border-color:#0b6ea8;background:#fff;box-shadow:0 2px 6px rgba(11,110,168,0.1)}
    
    /* SUGGESTIONS/TIPS */
    .tips-section{background:#fffbeb;border:1px solid #fce7f3;border-radius:8px;padding:4px;margin-bottom:6px}
    .tips-title{font-size:7px;font-weight:700;color:#b45309;margin-bottom:1px}
    .tips-title svg{width:9px;height:9px;display:inline;margin-right:2px}
    .tips-text{font-size:8px;color:#92400e;line-height:1.2}
    .tips-refresh{font-size:6px;color:#b45309;cursor:pointer;margin-top:1px;font-weight:600;opacity:0.7;transition:opacity 0.2s}
    .tips-refresh:hover{opacity:1}
    
    /* TAGS/CATEGORIES */
    .tags-container{display:flex;flex-wrap:wrap;gap:2px;margin-bottom:6px}
    .tag{padding:2px 4px;border-radius:5px;background:#f5f8fb;border:1px solid #cbd5e1;font-size:7px;color:#0f1724;font-weight:600;cursor:pointer;transition:all 0.2s}
    .tag:hover,.tag.active{background:#0b6ea8;color:#fff;border-color:#0b6ea8}
    
    /* FAVORITES */
    .favorites-section{margin-bottom:6px}
    .favorite-item{padding:3px;border-radius:6px;background:#f5f8fb;border:1px solid #cbd5e1;cursor:pointer;transition:all 0.2s;margin-bottom:2px;display:flex;align-items:center;gap:2px;font-size:8px}
    .favorite-item:hover{background:#e0f2fe;border-color:#0b6ea8}
    .favorite-star{width:10px;height:10px;color:#fbbf24;cursor:pointer}
    
    /* SETTINGS SECTION */
    .settings-menu{background:#f5f8fb;border-radius:8px;border:1px solid #cbd5e1;padding:2px;margin-bottom:6px}
    .settings-item{padding:4px;border-radius:5px;cursor:pointer;font-size:8px;color:#0f1724;transition:all 0.2s;display:flex;align-items:center;gap:3px;font-weight:600}
    .settings-item:hover{background:#e0f2fe;color:#0b6ea8}
    .settings-item svg{width:10px;height:10px}
    
    /* USER INFO CARD */
    .user-info-card{background:#e0f2fe;border:1px solid #7dd3fc;border-radius:8px;padding:5px;margin-bottom:6px}
    .user-info-title{font-size:7px;font-weight:700;color:#0b6ea8;margin-bottom:3px}
    .user-info-title svg{width:10px;height:10px;display:inline;margin-right:1px}
    .info-grid{display:flex;flex-direction:column;gap:2px}
    .info-item{padding:2px;background:rgba(255,255,255,0.8);border-radius:6px;display:flex;flex-direction:column;gap:0;border:1px solid rgba(11,110,168,0.1)}
    .info-label{font-size:6px;color:#475569;font-weight:600}
    .info-value{font-size:8px;color:#0b6ea8;font-weight:700;word-wrap:break-word}
    
    .chat-history{display:flex;flex-direction:column;gap:0;padding:0}
    .history-item{padding:10px 14px;border-radius:0;background:transparent;cursor:pointer;transition:all 0.2s;border:none;line-height:1.3;font-size:13px;color:#0f1724;border-left:3px solid transparent}
    .history-item:hover{background:#f5f8fb;border-left-color:#0b6ea8}
    .history-item.active{background:#e0f2fe;border-left-color:#0b6ea8;color:#0b6ea8;font-weight:600}
    .history-title{font-size:13px;font-weight:500;color:inherit;margin-bottom:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .history-time{display:none}
    
    /* MAIN CONTENT */
    .main-content{flex:1;margin-left:280px;display:flex;flex-direction:column;background:#f8fafc;min-height:calc(100vh - var(--header-height));transition:margin-left 0.3s ease}
    .main-content.expanded{margin-left:0}
    
    /* TOGGLE BUTTON */
    .sidebar-toggle{background:transparent;color:#fff;padding:6px;border-radius:8px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.3s;width:40px;height:40px;flex-shrink:0;position:relative}
    .sidebar-toggle:hover{background:rgba(255,255,255,0.15);transform:scale(1.05)}
    .sidebar-toggle img{width:28px;height:28px;transition:all 0.3s ease}
    .sidebar-toggle .toggle-indicator{position:absolute;right:-4px;bottom:-4px;width:12px;height:12px;border-radius:50%;background:#27b0e3;border:2px solid #fff;transition:all 0.3s ease;box-shadow:0 2px 6px rgba(11,110,168,0.3)}
    .sidebar-toggle.closed .toggle-indicator{background:#fbbf24;box-shadow:0 2px 6px rgba(245,158,11,0.4)}
    
    /* CHAT AREA */
    .wrap{flex:1;padding:24px 40px 160px 40px;max-width:900px;margin:0 auto;width:100%}
    .chat-window{background:transparent;padding:0;min-height:auto}
    .chat-list{display:flex;flex-direction:column;gap:16px;padding:0}
    
    /* SHARE BUTTON */
    .share-btn{background:rgba(255,255,255,0.12);color:#fff;padding:8px;border-radius:10px;border:1px solid rgba(255,255,255,0.2);font-weight:500;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0;transition:all 0.3s ease;font-size:13px;width:40px;height:40px;backdrop-filter:blur(8px)}
    .share-btn:hover{background:rgba(255,255,255,0.2);border-color:rgba(255,255,255,0.4);transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,0.15)}
    .share-btn:active{transform:translateY(0)}
    .share-btn svg{width:18px;height:18px}
    
    /* SHARE MODAL */
    .modal-overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:1000;align-items:center;justify-content:center;animation:fadeIn 0.2s ease}
    @keyframes fadeIn{from{opacity:0}to{opacity:1}}
    .modal-overlay.active{display:flex}
    .modal{background:#fff;border-radius:18px;padding:36px;max-width:480px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.3);animation:slideUp 0.3s ease}
    .modal-title{font-size:22px;font-weight:700;margin-bottom:8px;color:#0f1724}
    .modal-subtitle{font-size:14px;color:#64748b;margin-bottom:24px;line-height:1.5}
    .share-options{display:flex;flex-direction:column;gap:12px}
    .share-option{padding:16px;border-radius:12px;border:2px solid #e6eef6;display:flex;align-items:center;gap:14px;cursor:pointer;transition:all 0.3s;background:#f8fafc}
    .share-option:hover{border-color:#27b0e3;background:#e9f5fa;transform:translateX(4px)}
    .share-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .share-whatsapp .share-icon{background:#25D366}
    .share-telegram .share-icon{background:#0088cc}
    .share-copy .share-icon{background:#667eea}
    .share-label{font-weight:700;font-size:15px;color:#0f1724}
    .modal-close{margin-top:24px;width:100%;padding:12px;border-radius:12px;background:#e9ecef;border:none;font-weight:700;cursor:pointer;color:#0f1724;transition:all 0.3s}
    .modal-close:hover{background:#dee2e6;transform:translateY(-1px)}
    
    /* TYPING INDICATOR */
    .typing-indicator{display:flex;align-items:center;gap:6px;padding:16px 18px;background:#fff;border:1px solid #e6eef6;border-radius:16px;border-bottom-left-radius:4px;width:fit-content;box-shadow:0 2px 8px rgba(0,0,0,0.04)}
    .typing-dot{width:8px;height:8px;border-radius:50%;background:#a0aec0;animation:typing 1.4s infinite}
    .typing-dot:nth-child(2){animation-delay:0.2s}
    .typing-dot:nth-child(3){animation-delay:0.4s}
    @keyframes typing{0%,60%,100%{opacity:0.5;transform:translateY(0)}30%{opacity:1;transform:translateY(-8px)}}

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
    <button class="sidebar-toggle" id="sidebarToggle" title="Tutup Sidebar">
      <img src="<?= site_url('assets/icons/robot.png') ?>" alt="Robot AI" style="width:28px;height:28px">
      <span class="toggle-indicator" title="Sidebar: Open"></span>
    </button>
    <div style="flex:1">
      <div class="title">AI Business Advisor</div>
      <div class="subtitle">Tanya & diskusikan strategi bisnis Anda</div>
    </div>
    <div style="display:flex;gap:12px;align-items:center">
      <button class="share-btn" id="shareBtn" title="Bagikan">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
        </svg>
      </button>
      <a href="<?= site_url('advisor/index') ?>" class="logout-btn" title="Kembali ke Dashboard">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
      </a>
    </div>
  </div>

  <div class="layout">
    
    <!-- SIDEBAR -->
    <div class="sidebar">
      <div style="flex:1;overflow-y:auto;padding-bottom:20px">
        <!-- NEW CHAT -->
        <button class="new-chat-btn" id="newChatBtn">
          <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Chat Baru
        </button>
        
        <!-- MENU ITEMS -->
        <div class="sidebar-menu">
          <button class="menu-item" id="searchChatsBtn">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            Cari Chat
          </button>
          <button class="menu-item" id="analysisBtn">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Analisis
          </button>
          <button class="menu-item" id="tipsBtn">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Tips
          </button>
          <button class="menu-item" id="exportBtn">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Export
          </button>
        </div>
        
        <!-- CHATS SECTION -->
        <div class="chats-label">Chat Anda</div>
        <div class="chat-history" id="chatHistory">
          <div class="history-item active">
            <div class="history-title">Chat saat ini</div>
          </div>
        </div>
      </div>
      
      <!-- BOTTOM SECTION - PROFILE & UPGRADE -->
      <div class="sidebar-bottom">
        <!-- USER PROFILE -->
        <div class="user-profile">
          <div class="profile-avatar-small">👤</div>
          <div class="profile-info">
            <div class="profile-name-small"><?= htmlspecialchars($this->session->userdata('name') ?? 'User') ?></div>
            <div class="profile-plan">Free</div>
          </div>
        </div>
        
        <!-- UPGRADE BUTTON -->
        <button class="upgrade-btn">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
          </svg>
          Upgrade AI
        </button>
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
          <div class="bubble ai">Halo! Saya adalah AI Business Advisor Anda. Silakan tanyakan sesuatu tentang strategi bisnis, analisis pasar, atau tips pengembangan bisnis Anda.</div>
        <?php endif; ?>
          </div>
        </div>
      </div>
      
      <div class="input-area">
    <div class="input-inner">
      <div class="input-box">
        <input type="text" id="chatInput" placeholder="Tanyakan apa saja" aria-label="Tanyakan apa saja">
      </div>
        <button type="button" class="send-btn" id="sendBtn" title="Kirim pesan">
          <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M16.6915026,12.4744748 L3.50612381,13.2599618 C3.19218622,13.2599618 3.03521743,13.4170592 3.03521743,13.5741566 L1.15159189,20.0151496 C0.8376543,20.8006365 0.99,21.89 1.77946707,22.52 C2.41,22.99 3.50612381,23.1 4.13399899,22.9429026 L21.714504,14.0454487 C22.6563168,13.5741566 23.1272231,12.6315722 22.9702544,11.6889879 L4.13399899,1.16346272 C3.34915502,0.9 2.40734225,1.00636533 1.77946707,1.4776575 C0.994623095,2.10604706 0.837654326,3.0486314 1.15159189,3.99021575 L3.03521743,10.4310088 C3.03521743,10.5881061 3.34915502,10.7452035 3.50612381,10.7452035 L16.6915026,11.5306905 C16.6915026,11.5306905 17.1624089,11.5306905 17.1624089,12.0019827 C17.1624089,12.4744748 16.6915026,12.4744748 16.6915026,12.4744748 Z"/>
          </svg>
          <span class="spinner" aria-hidden="true"></span>
        </button>
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
    
    // === TIPS DATA ===
    var businessTips = [
      "Mulai dengan riset pasar yang mendalam untuk memahami target customer Anda.",
      "Kelola cashflow dengan baik - ini adalah jantung dari bisnis yang sehat.",
      "Bangun hubungan baik dengan supplier dan customer untuk pertumbuhan jangka panjang.",
      "Catat setiap transaksi - accounting yang baik adalah kunci kesuksesan.",
      "Jangan takut untuk pivot jika strategi awal tidak berjalan sesuai rencana.",
      "Investasi dalam pengembangan SDM adalah investasi terbaik untuk bisnis.",
      "Gunakan teknologi untuk meningkatkan efisiensi operasional bisnis Anda.",
      "Bangun personal brand atau brand awareness untuk produk/layanan Anda.",
      "Networking adalah aset berharga - jangan abaikan hubungan bisnis.",
      "Fokus pada customer satisfaction - mereka adalah aset terbesar Anda."
    ];
    var currentTipIndex = 0;

    function updateStats() {
      // Count chat messages
      var messages = document.querySelectorAll('.bubble:not(#pendingAi)').length;
      var chatCountEl = document.getElementById('chatCount');
      if (chatCountEl) chatCountEl.textContent = messages;
      
      // Count days since creation
      var createdDate = new Date('<?= date('Y-m-d', strtotime($advisor->created_at ?? 'now')) ?>');
      var now = new Date();
      var daysElapsed = Math.floor((now - createdDate) / (1000 * 60 * 60 * 24)) + 1;
      var dayCountEl = document.getElementById('dayCount');
      if (dayCountEl) dayCountEl.textContent = daysElapsed;
    }
    
    window.refreshTips = function() {
      currentTipIndex = (currentTipIndex + 1) % businessTips.length;
      document.getElementById('tipsText').textContent = businessTips[currentTipIndex];
    };

    function appendBubble(from, text) {
      var div = document.createElement('div');
      div.className = 'bubble ' + (from === 'ai' ? 'ai' : 'user');
      
      var timestamp = new Date().toLocaleString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'});
      
      // Render markdown untuk AI, plain text untuk user
      var content = from === 'ai' ? marked.parse(text) : text.replace(/\n/g, '<br>');
      
      div.innerHTML = content +
        '<span class="msg-time">' + timestamp + '</span>';
      chatList.appendChild(div);
      
      // Simpan message ke localStorage
      var chatKey = 'chat_' + advisorId;
      var existingChat = JSON.parse(localStorage.getItem(chatKey)) || [];
      existingChat.push({
        from: from,
        message: text,
        time: timestamp
      });
      localStorage.setItem(chatKey, JSON.stringify(existingChat));
      
      // Smooth scroll ke bawah
      setTimeout(function() {
        div.scrollIntoView({ behavior: 'smooth', block: 'end' });
      }, 100);
    }
    
    // Load chat history from localStorage on page load
    function loadChatHistory() {
      var chatKey = 'chat_' + advisorId;
      var savedChat = JSON.parse(localStorage.getItem(chatKey));
      
      if (savedChat && savedChat.length > 0) {
        chatList.innerHTML = '';
        savedChat.forEach(function(msg) {
          var div = document.createElement('div');
          div.className = 'bubble ' + (msg.from === 'ai' ? 'ai' : 'user');
          var content = msg.from === 'ai' ? marked.parse(msg.message) : msg.message.replace(/\n/g, '<br>');
          div.innerHTML = content + '<span class="msg-time">' + msg.time + '</span>';
          chatList.appendChild(div);
        });
      }
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
      typingBubble.innerHTML = '<div class="typing-indicator">' +
        '<div class="typing-dot"></div>' +
        '<div class="typing-dot"></div>' +
        '<div class="typing-dot"></div>' +
        '</div>' +
        '<span class="msg-time"></span>';
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
          // Refresh history dari backend
          loadChatHistoryFromBackend();
          // replace typing bubble with fallback + retry
          if (pending) pending.parentNode.removeChild(pending);
          var bubble = document.createElement('div');
          bubble.className = 'bubble ai';
          bubble.innerHTML = 'Maaf, AI sedang sibuk. Silakan coba lagi.' +
            ' <button style="margin-left:12px;padding:8px 14px;border-radius:8px;border:none;background:linear-gradient(135deg,#0b6ea8,#27b0e3);color:#fff;cursor:pointer;font-weight:700;transition:all 0.3s" id="retryBtn">Coba lagi</button>' +
            '<span class="msg-time">' + new Date().toLocaleString() + '</span>';
          chatList.appendChild(bubble);
          document.getElementById('retryBtn').addEventListener('click', function () {
            this.disabled = true;
            // re-insert typing bubble
            var tb = document.createElement('div');
            tb.className = 'bubble ai';
            tb.id = 'pendingAi';
            tb.innerHTML = '<div class="typing-indicator">' +
              '<div class="typing-dot"></div>' +
              '<div class="typing-dot"></div>' +
              '<div class="typing-dot"></div>' +
              '</div>' +
              '<span class="msg-time"></span>';
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
        // Update sidebar history langsung dari response jika ada
        if (data.chat_history && Array.isArray(data.chat_history)) {
          updateChatHistory(data.chat_history);
        } else {
          // Fallback: Refresh sidebar history dari backend setelah pesan baru
          setTimeout(function() {
            loadChatHistoryFromBackend();
          }, 500);
        }
      }).catch(function (err) {
        setLoading(false);
        var pending = document.getElementById('pendingAi'); if (pending) pending.parentNode.removeChild(pending);
        appendBubble('ai', 'Maaf, AI sedang sibuk. Silakan coba lagi.');
        console.error(err);
      });
    });
    
    // === SEARCH CHATS ===
    var searchChatsBtn = document.getElementById('searchChatsBtn');
    if (searchChatsBtn) {
      searchChatsBtn.addEventListener('click', function() {
        var query = prompt('Cari chat (ketik kata kunci):');
        if (query) {
          var messages = document.querySelectorAll('.bubble');
          messages.forEach(function(msg) {
            var text = msg.innerText.toLowerCase();
            msg.style.opacity = text.includes(query.toLowerCase()) ? '1' : '0.3';
          });
        }
      });
    }
    
    // === QUICK ACTIONS (MENU ITEMS) ===
    var analysisBtn = document.getElementById('analysisBtn');
    if (analysisBtn) {
      analysisBtn.addEventListener('click', function() {
        chatInput.value = 'Analisis bisnis saya berdasarkan data yang sudah saya berikan. Apa kekuatan, kelemahan, peluang, dan ancaman bisnis saya?';
        sendBtn.click();
      });
    }
    
    var tipsBtn = document.getElementById('tipsBtn');
    if (tipsBtn) {
      tipsBtn.addEventListener('click', function() {
        chatInput.value = 'Bagikan tips dan best practices untuk jenis bisnis saya agar lebih berkembang.';
        sendBtn.click();
      });
    }
    
    var exportBtn = document.getElementById('exportBtn');
    if (exportBtn) {
      exportBtn.addEventListener('click', function() {
        var chatText = '';
        var bubbles = document.querySelectorAll('.bubble');
        bubbles.forEach(function(b) {
          var text = b.innerText.replace(/\d{1,2}\/\d{1,2}\/\d{4}.*$/m, '').trim();
          chatText += (b.classList.contains('ai') ? 'AI: ' : 'Saya: ') + text + '\n\n';
        });
        
        var element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(chatText));
        element.setAttribute('download', 'chat-advisor-' + new Date().getTime() + '.txt');
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
      });
    }
    
    // === INITIALIZE ===
    
    // Load chat history from localStorage on startup
    loadChatHistory();
    
    // Load chat history from backend on startup
    function loadChatHistoryFromBackend() {
      fetch('<?= site_url('advisor/get_chat_history') ?>/' + advisorId, {
        method: 'GET'
      })
      .then(function(res) { return res.json(); })
      .then(function(data) {
        if (data.status === 'ok' && data.chat_history && Array.isArray(data.chat_history)) {
          updateChatHistory(data.chat_history);
          // Juga reload chat messages dari backend jika ada current messages
          // Ini ensure messages selalu tersinkronisasi dengan backend
        }
      })
      .catch(function(err) {
        console.error('Error loading chat history:', err);
      });
    }
    
    // Call this on page load
    loadChatHistoryFromBackend();
    
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
    
    // Function to load a specific chat from history
    function loadChatFromHistory(chatIndex) {
      fetch('<?= site_url('advisor/load_chat') ?>/' + advisorId + '?index=' + chatIndex, {
        method: 'GET'
      })
      .then(function(res) { return res.json(); })
      .then(function(data) {
        if (data.status === 'ok' && data.messages) {
          // Clear chat list
          chatList.innerHTML = '';
          // Load messages from the specific chat
          data.messages.forEach(function(msg) {
            var div = document.createElement('div');
            div.className = 'bubble ' + (msg.from === 'ai' ? 'ai' : 'user');
            var content = msg.from === 'ai' ? marked.parse(msg.message) : msg.message.replace(/\n/g, '<br>');
            div.innerHTML = content + '<span class="msg-time">' + (msg.time || '') + '</span>';
            chatList.appendChild(div);
          });
        } else {
          alert('Gagal memuat chat: ' + (data.message || 'Unknown error'));
        }
      })
      .catch(function(err) {
        console.error('Error loading chat:', err);
        alert('Gagal memuat chat history');
      });
    }
    
    // Function to update chat history sidebar
    function updateChatHistory(history) {
      var chatHistory = document.getElementById('chatHistory');
      if (!chatHistory) return;
      
      // Clear and rebuild
      chatHistory.innerHTML = '<div class="history-item active"><div class="history-title">Chat saat ini</div><div class="history-time">' + new Date().toLocaleString('id-ID', {day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'}) + '</div></div>';
      
      // Add history items (reverse to show newest first)
      var reversed = history.slice().reverse();
      reversed.forEach(function(hist, idx) {
        var actualIndex = history.length - 1 - idx; // Convert back to original index
        var item = document.createElement('div');
        item.className = 'history-item';
        item.dataset.index = actualIndex;
        
        var title = document.createElement('div');
        title.className = 'history-title';
        title.textContent = hist.title || 'Chat Lama';
        
        var time = document.createElement('div');
        time.className = 'history-time';
        time.textContent = hist.timestamp ? new Date(hist.timestamp).toLocaleString('id-ID', {day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'}) : '';
        
        item.appendChild(title);
        item.appendChild(time);
        
        // Add click handler to load this chat
        item.addEventListener('click', function() {
          var chatIndex = parseInt(this.dataset.index);
          loadChatFromHistory(chatIndex);
          // Update active state
          document.querySelectorAll('.history-item').forEach(function(el) {
            el.classList.remove('active');
          });
          item.classList.add('active');
        });
        
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
            // Clear chat display and localStorage
            chatList.innerHTML = '';
            localStorage.removeItem('chat_' + advisorId);
            newChatBtn.disabled = false;
            newChatBtn.innerHTML = '<svg style="width:18px;height:18px;display:inline-block;margin-right:6px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>Chat Baru';
            updateStats();
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
      sidebarToggle.classList.add('closed');
      sidebarToggle.title = 'Buka Sidebar';
      document.querySelector('.toggle-indicator').title = 'Sidebar: Closed';
      sidebarOpen = false;
    } else {
      sidebarToggle.title = 'Tutup Sidebar';
      document.querySelector('.toggle-indicator').title = 'Sidebar: Open';
    }
    
    sidebarToggle.addEventListener('click', function() {
      sidebarOpen = !sidebarOpen;
      var indicator = document.querySelector('.toggle-indicator');
      
      if (sidebarOpen) {
        sidebar.classList.remove('closed');
        mainContent.classList.remove('expanded');
        inputArea.classList.remove('expanded');
        sidebarToggle.classList.remove('closed');
        sidebarToggle.title = 'Tutup Sidebar';
        indicator.title = 'Sidebar: Open';
      } else {
        sidebar.classList.add('closed');
        mainContent.classList.add('expanded');
        inputArea.classList.add('expanded');
        sidebarToggle.classList.add('closed');
        sidebarToggle.title = 'Buka Sidebar';
        indicator.title = 'Sidebar: Closed';
      }
      
      // Save state to localStorage
      localStorage.setItem('sidebarOpen', sidebarOpen);
    });
  })();
</script>
</body>
</html>

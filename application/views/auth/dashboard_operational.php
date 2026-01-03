<?php
$user = array_merge([
    'nama'  => 'User',
    'email' => '-',
    'role'  => '-',
    'usaha' => 'Bisnis Anda',
    'type'  => 'UMKM'
], $user ?? []);

$summary = array_merge([
    'today_sales'   => 0,
    'today_expense' => 0,
    'today_profit'  => 0
], $summary ?? []);

$transactions = $transactions ?? [];
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5,user-scalable=yes">
<meta name="theme-color" content="#1C6494">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<title>Dashboard <?= htmlspecialchars($user['nama']); ?></title>

<style>
/* === THEME COLOR VARIABLES === */
:root {
    --primary-color: #4A90E2;
    --primary-dark: #357ABD;
    --primary-light: #6BA4EC;
    --secondary-color: #7EC8E3;
    --secondary-light: #A5D8E8;
    --accent-color: #87CEEB;
    --accent-dark: #48C9B0;
    --success: #52D79A;
    --success-light: #81E9B8;
    --warning: #FFA76C;
    --warning-light: #FFC49A;
    --danger: #F57C7C;
    --danger-light: #FF9D9D;
    --background: #F5F8FA;
    --card-bg: #FFFFFF;
    --text-primary: #2D3748;
    --text-secondary: #718096;
    --text-muted: #A0AEC0;
    --border-color: #E2E8F0;
    --shadow-xs: 0 1px 3px rgba(74,144,226,0.06);
    --shadow-sm: 0 2px 6px rgba(74,144,226,0.08);
    --shadow-md: 0 4px 12px rgba(74,144,226,0.10);
    --shadow-lg: 0 8px 20px rgba(74,144,226,0.12);
    --shadow-xl: 0 12px 28px rgba(74,144,226,0.15);
}

*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Inter,Segoe UI,Arial;background:var(--background);color:var(--text-primary)}

/* HEADER / NAVBAR */
.header{
    background:linear-gradient(135deg, #4A90E2 0%, #6BA4EC 100%);
    padding:28px 36px;
    color:#fff;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 12px rgba(74,144,226,0.12);
    position:relative;
    overflow:hidden;
    border-bottom:1px solid rgba(255,255,255,0.15)
}
.header::before{
    content:'';
    position:absolute;
    top:-60%;
    right:-8%;
    width:450px;
    height:450px;
    background:radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    border-radius:50%
}
.header h3{
    font-size:21px;
    font-weight:700;
    position:relative;
    z-index:2;
    letter-spacing:-0.3px
}
.header small{
    opacity:.92;
    font-size:13px;
    position:relative;
    z-index:2;
    font-weight:500
}

.header-right{
    display:flex;
    align-items:center;
    gap:14px
}

.avatar{
    width:46px;height:46px;border-radius:50%;
    background:var(--card-bg);
    color:var(--primary-color);
    display:flex;align-items:center;justify-content:center;
    font-weight:700;
    box-shadow:var(--shadow-sm);
    border:2px solid rgba(255,255,255,0.3)
}

.logout-btn{
    background:rgba(255,255,255,.20);
    color:#fff;
    padding:10px 20px;
    border-radius:28px;
    font-size:13px;
    text-decoration:none;
    font-weight:600;
    transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border:1px solid rgba(255,255,255,0.35);
    backdrop-filter:blur(10px)
}
.logout-btn:hover{
    background:rgba(255,255,255,.32);
    border-color:rgba(255,255,255,0.55);
    transform:translateY(-2px);
    box-shadow:0 4px 12px rgba(0,0,0,0.12)
}

.change-dashboard-btn{
    background:rgba(255,255,255,.18);
    color:#fff;
    padding:9px 18px;
    border-radius:24px;
    font-size:12px;
    text-decoration:none;
    font-weight:600;
    transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border:1px solid rgba(255,255,255,0.3);
    backdrop-filter:blur(10px)
}
.change-dashboard-btn:hover{
    background:rgba(255,255,255,.32);
    transform:translateY(-2px);
    border-color:rgba(255,255,255,0.5)
}

/* LAYOUT */
.container{max-width:1150px;margin:28px auto;padding:0 24px}

/* BISNIS CARD */
.biz-card{
    background:linear-gradient(135deg, #87CEEB 0%, #4A90E2 100%);
    border-radius:28px;
    padding:40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:36px;
    box-shadow:var(--shadow-lg);
    border:1px solid rgba(255,255,255,0.35);
    position:relative;
    overflow:hidden;
    transition:all 0.35s cubic-bezier(0.4, 0, 0.2, 1)
}
.biz-card::before{
    content:'';
    position:absolute;
    top:-55%;
    right:-18%;
    width:350px;
    height:350px;
    background:radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 65%);
    border-radius:50%
}
.biz-card:hover{
    transform:translateY(-3px);
    box-shadow:var(--shadow-xl)
}
.biz-left{display:flex;gap:20px;align-items:center;position:relative;z-index:2}
.biz-info h2{font-size:26px;font-weight:800;color:#fff;margin-bottom:10px}
.biz-info span{
    background:rgba(255,255,255,0.95);
    color:var(--primary-color);
    padding:6px 14px;
    border-radius:24px;
    font-size:12px;
    margin-right:10px;
    font-weight:700;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
    display:inline-block;
    transition:all 0.3s
}
.biz-info span:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 16px rgba(0,0,0,0.2)
}
.biz-profit{text-align:right;color:#fff;position:relative;z-index:2}
.biz-profit small{opacity:.95;font-size:14px;font-weight:600;display:block;margin-bottom:8px}
.biz-profit h2{margin-top:0;font-size:32px;font-weight:800;text-shadow:0 2px 10px rgba(0,0,0,0.2)}

/* SECTION */
.section-title{
    font-weight:800;
    margin:40px 0 20px;
    display:flex;
    align-items:center;
    gap:12px;
    color:var(--text-primary);
    font-size:20px;
    position:relative;
    padding-bottom:12px
}
.section-title::after{
    content:'';
    position:absolute;
    bottom:0;
    left:0;
    width:60px;
    height:4px;
    background:linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius:2px
}

/* AKSI CEPAT - Action Buttons */
.actions{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
    margin-bottom:36px
}
.action{
    border-radius:24px;
    padding:32px 24px;
    color:#fff;
    font-weight:650;
    font-size:15px;
    text-align:center;
    text-decoration:none;
    transition:all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow:var(--shadow-md);
    border:1px solid rgba(255,255,255,0.25);
    position:relative;
    overflow:hidden;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:10px
}
.action::before{
    content:'';
    position:absolute;
    top:50%;left:50%;
    width:0;height:0;
    border-radius:50%;
    background:rgba(255,255,255,0.2);
    transform:translate(-50%, -50%);
    transition:width 0.5s, height 0.5s;
    z-index:1
}
.action:hover::before{
    width:300px;
    height:300px
}
.action:hover{
    transform:translateY(-6px) scale(1.03);
    box-shadow:var(--shadow-xl);
    border-color:rgba(255,255,255,0.45)
}
.action span{
    font-size:32px;
    z-index:2;
    transition:transform 0.3s
}
.action:hover span{
    transform:scale(1.2) rotate(10deg)
}
.action-text{
    z-index:2;
    font-size:15px
}
.sale{background:linear-gradient(135deg, #52D79A 0%, #48C9B0 100%)}
.expense{background:linear-gradient(135deg, #F57C7C 0%, #FF9D9D 100%)}
.stock{background:linear-gradient(135deg, #6BA4EC 0%, #4A90E2 100%)}
.report{background:linear-gradient(135deg, #FFA76C 0%, #FFC49A 100%);color:#fff}

/* SUMMARY CARDS */
.summary{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:36px
}
.sum-card{
    background:linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
    border-radius:20px;
    padding:28px 24px;
    box-shadow:var(--shadow-sm);
    transition:all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    border:1px solid var(--border-color);
    position:relative;
    overflow:hidden
}
.sum-card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:5px;
    transform:scaleX(0);
    transition:transform 0.4s;
    border-radius:24px 24px 0 0
}
.sum-card::after{
    content:'';
    position:absolute;
    bottom:-30%;
    right:-20%;
    width:150px;
    height:150px;
    border-radius:50%;
    background:radial-gradient(circle, rgba(28,100,148,0.04) 0%, transparent 70%);
    transition:all 0.5s
}
.sum-card:hover::after{
    transform:translate(-10%, -10%) scale(1.2)
}
.sum-card:hover::before{
    transform:scaleX(1)
}
.sum-card:hover{
    transform:translateY(-4px) scale(1.01);
    box-shadow:var(--shadow-lg);
    border-color:var(--primary-light)
}
.sum-card small{
    color:var(--text-secondary);
    font-weight:700;
    font-size:13px;
    text-transform:uppercase;
    letter-spacing:0.5px;
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:14px;
    position:relative;
    z-index:2
}
.sum-card small::before{
    content:'';
    display:inline-block;
    width:6px;
    height:6px;
    border-radius:50%;
    transition:transform 0.3s
}
.sum-card:hover small::before{
    transform:scale(1.5)
}
.sum-card h3{
    margin-top:0;
    font-size:32px;
    font-weight:800;
    line-height:1.2;
    position:relative;
    z-index:2;
    text-shadow:0 2px 8px rgba(0,0,0,0.05)
}
.sum-card .green::before,
.sum-card:has(.green)::before{background:linear-gradient(90deg, #52D79A, #48C9B0)}
.sum-card .red::before,
.sum-card:has(.red)::before{background:linear-gradient(90deg, #F57C7C, #FF9D9D)}
.sum-card .blue::before,
.sum-card:has(.blue)::before{background:linear-gradient(90deg, #6BA4EC, var(--primary-color))}
.sum-card:has(.green) small::before{background:#52D79A}
.sum-card:has(.red) small::before{background:#F57C7C}
.sum-card:has(.blue) small::before{background:#6BA4EC}
.green{color:#48C9B0;text-shadow:0 1px 6px rgba(82,215,154,0.15)}
.red{color:#F57C7C;text-shadow:0 1px 6px rgba(245,124,124,0.15)}
.blue{color:var(--primary-color);text-shadow:0 1px 6px rgba(74,144,226,0.15)}

/* TRANSAKSI */
.transaksi{
    background:var(--card-bg);
    border-radius:14px;
    padding:20px;
    box-shadow:var(--shadow-sm);
    margin-bottom:30px
}
.tx{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(135deg, #f8fbfd 0%, #f0f6f9 100%);
    padding:16px;
    border-radius:10px;
    margin-bottom:10px;
    border-left:4px solid transparent;
    transition:.3s ease
}
.tx:hover{
    background:linear-gradient(135deg, #e8f4f8 0%, #deeef5 100%);
    transform:translateX(4px)
}
.tx small{color:var(--text-secondary);font-size:12px}
.tx strong{color:var(--text-primary)}
.tx.plus{border-left-color:var(--accent-dark);color:var(--accent-dark)}
.tx.minus{border-left-color:#e74c3c;color:#e74c3c}

/* TOOLS BISNIS */
.tools-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:24px;
    margin-bottom:48px
}
.tool-box{
    background:linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
    border-radius:20px;
    padding:28px 24px;
    box-shadow:var(--shadow-sm);
    transition:all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    cursor:pointer;
    border:1px solid var(--border-color);
    position:relative;
    overflow:hidden
}
.tool-box::before{
    content:'';
    position:absolute;
    top:0;left:0;right:0;
    height:5px;
    background:linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--primary-light));
    transform:scaleX(0);
    transition:transform 0.4s
}
.tool-box::after{
    content:'';
    position:absolute;
    top:-50%;
    right:-50%;
    width:200px;
    height:200px;
    background:radial-gradient(circle, rgba(28,100,148,0.05) 0%, transparent 70%);
    transition:all 0.5s
}
.tool-box:hover::after{
    transform:translate(-20%, 20%)
}
.tool-box:hover{
    transform:translateY(-4px) scale(1.01);
    box-shadow:var(--shadow-lg);
    border-color:var(--primary-light);
    background:linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%)
}
.tool-box:hover::before{
    transform:scaleX(1)
}
.tool-icon{
    width:54px;
    height:54px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
    margin-bottom:14px;
    box-shadow:var(--shadow-sm);
    position:relative;
    z-index:2;
    transition:all 0.35s cubic-bezier(0.4, 0, 0.2, 1)
}
.tool-box:hover .tool-icon{
    transform:scale(1.08) rotate(3deg);
    box-shadow:var(--shadow-md)
}
.tool-icon.hpp{background:linear-gradient(135deg, #6BA4EC, #4A90E2)}
.tool-icon.keuangan{background:linear-gradient(135deg, #52D79A, #48C9B0)}
.tool-icon.risiko{background:linear-gradient(135deg, #FFA76C, #FFC49A)}
.tool-icon.analisis{background:linear-gradient(135deg, #A78BFA, #8B7BC8)}
.tool-icon.info{background:linear-gradient(135deg, #F687B3, #ED64A6)}
.tool-icon.advisor{background:linear-gradient(135deg, #67D6E8, #4FC3F7)}
.tool-title{
    font-weight:800;
    margin-bottom:12px;
    font-size:18px;
    color:var(--text-primary);
    position:relative;
    z-index:2
}
.tool-desc{
    font-size:14px;
    color:var(--text-secondary);
    margin-bottom:16px;
    line-height:1.6;
    position:relative;
    z-index:2
}
.tool-box a{
    color:var(--primary-color);
    text-decoration:none;
    font-weight:700;
    font-size:14px;
    transition:all 0.3s;
    position:relative;
    z-index:2;
    display:inline-flex;
    align-items:center;
    gap:6px
}
.tool-box a::after{
    content:'→';
    transition:transform 0.3s
}
.tool-box:hover a{
    color:var(--primary-dark)
}
.tool-box:hover a::after{
    transform:translateX(4px)
}

/* RESPONSIVE DESIGN */

/* === DESKTOP & LARGE SCREENS (>1200px) === */
@media(min-width:1200px){
    .container{max-width:1200px}
}

/* === LAPTOP & MEDIUM SCREENS (992px - 1199px) === */
@media(max-width:1199px){
    .container{max-width:1000px}
    .tools-grid{grid-template-columns:repeat(4,1fr)}
}

/* === TABLET LANDSCAPE & SMALL LAPTOP (768px - 991px) === */
@media(max-width:991px){
    .container{padding:0 20px}
    
    /* Header adjustments */
    .header{padding:18px 24px}
    .header h3{font-size:18px}
    .avatar{width:42px;height:42px}
    
    /* Bisnis card */
    .biz-card{padding:24px;flex-direction:column;text-align:center}
    .biz-left{flex-direction:column;width:100%}
    .biz-profit{text-align:center;margin-top:16px}
    .biz-icon{font-size:36px}
    
    /* Actions - 2 columns */
    .actions{grid-template-columns:repeat(2,1fr);gap:12px}
    .action{padding:16px;font-size:14px}
    
    /* Summary - stack vertically */
    .summary{grid-template-columns:1fr;gap:12px}
    
    /* Chart & Insight - stack vertically */
    .chart-insight-wrapper{grid-template-columns:1fr}
    .chart-section{margin-bottom:20px}
    #salesChart{height:200px}
    
    /* Tools - 2 columns */
    .tools-grid{grid-template-columns:repeat(2,1fr);gap:14px}
    .tool-box{padding:20px}
}

/* === TABLET PORTRAIT & LARGE PHONES (576px - 767px) === */
@media(max-width:767px){
    .container{padding:0 16px;margin:20px auto}
    
    /* Header - responsive */
    .header{
        padding:16px 20px;
        flex-direction:row;
        gap:12px
    }
    .header h3{font-size:16px}
    .header small{font-size:12px}
    .header-right{gap:10px}
    .avatar{width:38px;height:38px;font-size:16px}
    .logout-btn{padding:7px 14px;font-size:12px}
    
    /* Bisnis card */
    .biz-card{padding:20px;margin-bottom:20px}
    .biz-info h2{font-size:18px}
    .biz-info span{font-size:11px;padding:4px 10px}
    .biz-profit h2{font-size:22px}
    
    /* Section titles */
    .section-title{font-size:15px;margin:20px 0 12px}
    
    /* Filter periode - full width buttons */
    .filter-periode{
        justify-content:stretch;
        gap:8px
    }
    .filter-btn{
        flex:1;
        text-align:center;
        font-size:12px;
        padding:8px 12px
    }
    
    /* Summary cards */
    .sum-card{padding:16px}
    .sum-card small{font-size:12px}
    .sum-card h3{font-size:20px}
    
    /* Chart */
    .chart-section{padding:20px}
    .chart-header{flex-direction:column;align-items:flex-start;gap:12px}
    .chart-header h4{font-size:15px}
    .chart-legend{flex-wrap:wrap;gap:12px;font-size:11px}
    #salesChart{height:180px}
    
    /* Insight */
    .insight-section{padding:20px}
    .insight-section h4{font-size:15px}
    .insight-item{padding:12px}
    .insight-item strong{font-size:13px}
    .insight-item p{font-size:12px}
    
    /* Transaksi */
    .transaksi{padding:16px}
    .tx{padding:12px;flex-direction:column;align-items:flex-start;gap:8px}
    .tx div:last-child{align-self:flex-end;font-size:16px;font-weight:700}
    
    /* Tools - still 2 columns but smaller */
    .tool-box{padding:18px}
    .tool-icon{font-size:32px;margin-bottom:10px}
    .tool-title{font-size:14px}
    .tool-desc{font-size:12px}
}

/* === SMARTPHONE (320px - 575px) === */
@media(max-width:575px){
    .container{padding:0 12px;margin:16px auto}
    
    /* Header - compact mobile */
    .header{
        padding:14px 16px;
        flex-wrap:nowrap
    }
    .header div:first-child{flex:1;min-width:0}
    .header h3{
        font-size:15px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis
    }
    .header small{display:none}
    .avatar{width:36px;height:36px;font-size:15px}
    .logout-btn{
        padding:6px 12px;
        font-size:11px;
        white-space:nowrap
    }
    
    /* Bisnis card - compact */
    .biz-card{padding:16px;margin-bottom:16px}
    .biz-icon{font-size:32px}
    .biz-info h2{font-size:16px}
    .biz-info span{font-size:10px;padding:3px 8px;margin-right:4px}
    .biz-profit{margin-top:12px}
    .biz-profit small{font-size:11px}
    .biz-profit h2{font-size:20px}
    
    /* Actions - single column on very small screens */
    .actions{grid-template-columns:1fr;gap:10px}
    .action{padding:14px;font-size:15px}
    
    /* Section titles */
    .section-title{font-size:14px;margin:16px 0 10px}
    
    /* Filter - stack on small phones */
    .filter-periode{gap:6px}
    .filter-btn{font-size:11px;padding:7px 10px}
    
    /* Summary */
    .sum-card{padding:14px}
    .sum-card small{font-size:11px}
    .sum-card h3{font-size:18px;margin-top:6px}
    
    /* Chart */
    .chart-section{padding:16px}
    .chart-header h4{font-size:14px}
    .chart-legend{gap:10px;font-size:10px}
    .legend-color{width:10px;height:10px}
    #salesChart{height:160px}
    
    /* Insight */
    .insight-section{padding:16px}
    .insight-section h4{font-size:14px;margin-bottom:12px}
    .insight-item{padding:10px;margin-bottom:10px}
    .insight-icon{font-size:20px;margin-bottom:6px}
    .insight-item strong{font-size:12px;margin-bottom:4px}
    .insight-item p{font-size:11px;line-height:1.4}
    
    /* Transaksi */
    .transaksi{padding:14px}
    .tx{padding:10px}
    .tx strong{font-size:13px}
    .tx small{font-size:11px}
    .tx div:last-child{font-size:15px}
    
    /* Tools - single column */
    .tools-grid{grid-template-columns:1fr;gap:12px;margin-bottom:30px}
    .tool-box{padding:16px}
    .tool-icon{font-size:28px}
    .tool-title{font-size:14px;margin-bottom:4px}
    .tool-desc{font-size:11px;margin-bottom:8px}
    .tool-box a{font-size:12px}
}

/* === EXTRA SMALL DEVICES (< 375px) === */
@media(max-width:374px){
    .header h3{font-size:14px}
    .biz-info h2{font-size:15px}
    .filter-periode{flex-direction:column}
    .filter-btn{width:100%}
    #salesChart{height:150px}
}

/* Touch-friendly improvements for all mobile devices */
@media(max-width:991px){
    /* Larger touch targets */
    .action, .filter-btn, .logout-btn, .tool-box{
        min-height:44px;
        display:flex;
        align-items:center;
        justify-content:center
    }
    
    /* Prevent text selection on buttons */
    .action, .filter-btn, .logout-btn{
        -webkit-tap-highlight-color:transparent;
        user-select:none
    }
    
    /* Smooth scrolling */
    html{scroll-behavior:smooth}
    
    /* Remove hover effects on touch devices */
    .tool-box:hover::before{transform:scaleX(0)}
}

/* ===== MODAL STYLES ===== */
.modal-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:999;align-items:center;justify-content:center}
.modal-overlay.active{display:flex}
.modal-container{background:#fff;border-radius:20px;width:90%;max-width:480px;box-shadow:0 20px 60px rgba(0,0,0,0.3);animation:modalSlideIn 0.3s ease-out}
@keyframes modalSlideIn{from{opacity:0;transform:translateY(-30px)}to{opacity:1;transform:translateY(0)}}
.modal-header{padding:24px 24px 16px;border-bottom:1px solid #e9ecef}
.modal-title{font-size:22px;font-weight:700;color:#222;margin:0}
.modal-subtitle{font-size:14px;color:#6c757d;margin:6px 0 0}
.modal-body{padding:24px}
.modal-form-group{margin-bottom:20px}
.modal-label{display:block;font-size:14px;font-weight:600;color:#333;margin-bottom:8px}
.modal-input{width:100%;padding:12px 16px;border:2px solid #e0e4e8;border-radius:10px;font-size:15px;transition:border-color 0.2s;font-family:inherit}
.modal-input:focus{outline:none;border-color:#2fb12f}
.modal-input::placeholder{color:#adb5bd}
.modal-select{width:100%;padding:12px 16px;border:2px solid #e0e4e8;border-radius:10px;font-size:15px;background:#fff;cursor:pointer;transition:border-color 0.2s}
.modal-select:focus{outline:none;border-color:#2fb12f}
.modal-textarea{width:100%;padding:12px 16px;border:2px solid #e0e4e8;border-radius:10px;font-size:15px;font-family:inherit;resize:vertical;min-height:80px;transition:border-color 0.2s}
.modal-textarea:focus{outline:none;border-color:#2fb12f}
.modal-footer{padding:16px 24px 24px;display:flex;gap:12px;justify-content:flex-end}
.modal-btn{padding:12px 24px;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;transition:all 0.2s}
.modal-btn-primary{background:#2fb12f;color:#fff}
.modal-btn-primary:hover{background:#27a127;transform:translateY(-1px);box-shadow:0 4px 12px rgba(47,177,47,0.3)}
.modal-btn-danger{background:#e74c3c;color:#fff}
.modal-btn-danger:hover{background:#c0392b;transform:translateY(-1px);box-shadow:0 4px 12px rgba(231,76,60,0.3)}
.modal-btn-secondary{background:#e9ecef;color:#495057}
.modal-btn-secondary:hover{background:#dee2e6}
@media(max-width:576px){.modal-container{width:95%;border-radius:16px}.modal-header,.modal-body,.modal-footer{padding:16px}.modal-title{font-size:20px}}

/* Modal Risiko Styles */
.modal-container.wide{max-width:800px}
.risk-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-bottom:24px}
.risk-card{background:#fff;border-radius:12px;padding:16px;border:2px solid;transition:all 0.2s}
.risk-card:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,0.1)}
.risk-card.red{border-color:#e74c3c;background:linear-gradient(135deg,#fff 0%,#ffe8e6 100%)}
.risk-card.yellow{border-color:#f39c12;background:linear-gradient(135deg,#fff 0%,#fff8e6 100%)}
.risk-card.green{border-color:#2ecc71;background:linear-gradient(135deg,#fff 0%,#e8f8f0 100%)}
.risk-card.blue{border-color:#3498db;background:linear-gradient(135deg,#fff 0%,#e8f4f8 100%)}
.risk-card-header{display:flex;align-items:center;gap:10px;margin-bottom:12px;font-weight:700;font-size:15px}
.risk-icon{font-size:24px;width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center}
.risk-card.red .risk-icon{background:#e74c3c;color:#fff}
.risk-card.yellow .risk-icon{background:#f39c12;color:#fff}
.risk-card.green .risk-icon{background:#2ecc71;color:#fff}
.risk-card.blue .risk-icon{background:#3498db;color:#fff}
.risk-checklist{display:flex;flex-direction:column;gap:8px}
.risk-checkbox{display:flex;align-items:center;gap:8px;padding:8px;border-radius:6px;cursor:pointer;transition:background 0.2s}
.risk-checkbox:hover{background:rgba(0,0,0,0.03)}
.risk-checkbox input[type="checkbox"]{width:18px;height:18px;cursor:pointer;accent-color:#3498db}
.risk-checkbox label{cursor:pointer;font-size:13px;flex:1}
.score-section{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;border-radius:12px;padding:20px;margin-bottom:20px}
.score-header{font-size:16px;font-weight:700;margin-bottom:12px;display:flex;align-items:center;gap:8px}
.score-bar-container{background:rgba(255,255,255,0.2);border-radius:10px;height:24px;overflow:hidden;margin-bottom:12px}
.score-bar{background:#2ecc71;height:100%;border-radius:10px;transition:width 0.3s ease;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px}
.score-text{font-size:32px;font-weight:700;margin-bottom:4px}
.score-desc{font-size:13px;opacity:0.95}
@media(max-width:768px){.risk-grid{grid-template-columns:1fr}.modal-container.wide{max-width:95%}}

/* FILTER PERIODE */
.filter-periode{
    display:flex;
    gap:10px;
    margin-bottom:20px;
    justify-content:flex-end;
    flex-wrap:wrap
}
.filter-btn{
    padding:8px 16px;
    border-radius:20px;
    border:2px solid var(--secondary-light);
    background:var(--card-bg);
    color:var(--primary-color);
    font-weight:600;
    font-size:13px;
    cursor:pointer;
    transition:.3s ease;
    text-decoration:none;
    display:inline-block
}
.filter-btn:hover{
    background:var(--secondary-light);
    color:#fff;
    transform:translateY(-2px)
}
.filter-btn.active{
    background:var(--primary-color);
    color:#fff;
    border-color:var(--primary-color)
}

/* CHART & INSIGHT WRAPPER */
.chart-insight-wrapper{
    display:grid;
    grid-template-columns:7fr 3fr;
    gap:20px;
    margin-bottom:30px
}

/* CHART SECTION */
.chart-section{
    background:var(--card-bg);
    border-radius:14px;
    padding:24px;
    box-shadow:var(--shadow-sm)
}
.chart-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px
}
.chart-header h4{
    color:var(--primary-color);
    font-size:16px
}
.chart-legend{
    display:flex;
    gap:16px;
    font-size:12px
}
.legend-item{
    display:flex;
    align-items:center;
    gap:6px
}
.legend-color{
    width:12px;
    height:12px;
    border-radius:3px
}
.legend-sales{background:var(--accent-dark)}
.legend-expense{background:#e74c3c}
.legend-profit{background:var(--primary-color)}
#salesChart{
    width:100%;
    height:240px
}

/* INSIGHT SECTION */
.insight-section{
    background:linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius:14px;
    padding:24px;
    color:#fff;
    box-shadow:var(--shadow-md)
}
.insight-section h4{
    font-size:16px;
    margin-bottom:16px;
    display:flex;
    align-items:center;
    gap:8px
}
.insight-item{
    background:rgba(255,255,255,0.15);
    padding:14px;
    border-radius:10px;
    margin-bottom:12px;
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.2)
}
.insight-item strong{
    display:block;
    margin-bottom:6px;
    font-size:14px
}
.insight-item p{
    font-size:13px;
    opacity:.95;
    line-height:1.5
}
.insight-icon{
    font-size:24px;
    margin-bottom:8px
}

/* FOOTER SIMPLE */
.footer-simple {
    width: 100%;
    background: #f8fbfd;
    border-top: 1px solid #e6eef5;
    padding: 12px 0;
    font-size: 13px;
    color: #6c757d;
}

/* INI KUNCI CENTER */
.footer-inner {
    max-width: 1200px;
    margin: 0 auto; /* ← CENTER HORIZONTAL */
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}
@media (max-width: 576px) {
    .footer-inner {
        flex-direction: column;
        text-align: center;
    }

    .footer-left,
    .footer-right {
        width: 100%;
        text-align: center;
    }
}
</style>
</head>

<body>
<!-- HEADER -->
<div class="header">
    <div>
        <h3>Dashboard Operasional</h3>
        <small>Kelola Bisnis yang Sudah Berjalan</small>
    </div>

    <div class="header-right">
        <a href="<?= site_url('auth/dashboard_planning'); ?>" class="change-dashboard-btn">Dashboard perencanaan</a>
        <div class="avatar"><?= strtoupper(substr($user['nama'],0,1)); ?></div>
        <a href="<?= site_url('auth/logout'); ?>" 
           class="logout-btn"
           onclick="return confirm('Yakin ingin logout?')">
           Logout
        </a>
    </div>
</div>

<div class="container">

    <!-- BISNIS -->
    <div class="biz-card">
        <div class="biz-left">
            <div class="biz-info">
                <h2><?= htmlspecialchars($user['usaha']); ?></h2>
                <span><?= $user['type']; ?></span>
                <span>Aktif Beroperasi</span>
            </div>
        </div>
        <div class="biz-profit">
            <small>Hari Ini</small>
            <h2 id="labaBersihHeader">Rp <?= number_format($summary['today_profit'],0,',','.'); ?></h2>
            <small>Laba Bersih</small>
        </div>
    </div>

    <!-- TOOLS -->
    <div class="section-title">Tools Bisnis Lainnya</div>
    <div class="tools-grid">
        
        <!-- AI Advisor -->
        <div class="tool-box">
            <div class="tool-icon advisor">🤖</div>
            <div class="tool-title">AI Advisor</div>
            <div class="tool-desc">Konsultasi strategi bisnis dengan AI yang cerdas dan responsif</div>
            <a href="<?= site_url('advisor'); ?>">Coba Sekarang →</a>
        </div>

        <!-- Kalkulator HPP -->
        <div class="tool-box">
            <div class="tool-icon hpp">🧮</div>
            <div class="tool-title">Kalkulator HPP</div>
            <div class="tool-desc">Hitung harga pokok produksi dan tentukan margin keuntungan optimal</div>
            <a href="<?= site_url('hpp'); ?>">Hitung HPP →</a>
        </div>

        <!-- Pencatatan Keuangan -->
        <div class="tool-box">
            <div class="tool-icon keuangan">💰</div>
            <div class="tool-title">Pencatatan Keuangan</div>
            <div class="tool-desc">Catat & kelola pemasukan serta pengeluaran bisnis dengan mudah</div>
            <a href="<?= site_url('keuangan'); ?>">Kelola Keuangan →</a>
        </div>

        <!-- Manajemen Risiko -->
        <div class="tool-box">
            <div class="tool-icon risiko">⚠️</div>
            <div class="tool-title">Manajemen Risiko</div>
            <div class="tool-desc">Identifikasi, evaluasi & mitigasi risiko usaha secara sistematis</div>
            <a href="<?= site_url('risiko'); ?>">Kelola Risiko →</a>
        </div>

        <!-- Analisis Produk -->
        <div class="tool-box">
            <div class="tool-icon analisis">📊</div>
            <div class="tool-title">Analisis Produk</div>
            <div class="tool-desc">Analisa mendalam performa dan profitabilitas produk Anda</div>
            <a href="<?= site_url('analisis'); ?>">Mulai Analisis →</a>
        </div>

        <!-- Rekomendasi Informasi Bisnis -->
        <div class="tool-box">
            <div class="tool-icon info">💡</div>
            <div class="tool-title">Rekomendasi Informasi Bisnis</div>
            <div class="tool-desc">Dapatkan tips, tren, dan informasi UMKM terkini untuk sukses</div>
            <a href="<?= site_url('advisor/rekomendasi'); ?>">Lihat Info →</a>
        </div>

    </div>

    <!-- AKSI CEPAT -->
    <div class="section-title">⚡ Aksi Cepat</div>
    <div class="actions">
        <a href="#" onclick="openModalPenjualan(); return false;" class="action sale">
            <span>🛒</span>
            <span class="action-text">Catat Penjualan</span>
        </a>
        <a href="#" onclick="openModalPengeluaran(); return false;" class="action expense">
            <span>💸</span>
            <span class="action-text">Catat Pengeluaran</span>
        </a>
        <a href="<?= base_url('hpp'); ?>" class="action stock">
            <span>🧮</span>
            <span class="action-text">Kalkulator HPP</span>
        </a>
        <a href="<?= base_url('risiko'); ?>" onclick="openModalRisiko(); return false;" class="action report">
            <span>⚠️</span>
            <span class="action-text">Manajemen Risiko</span>
        </a>
    </div>

    <!-- RINGKASAN -->
    <div class="section-title">📊 Ringkasan Keuangan</div>
    
    <!-- FILTER PERIODE -->
    <div class="filter-periode">
        <a href="?periode=hari" class="filter-btn active">Hari Ini</a>
        <a href="?periode=minggu" class="filter-btn">Minggu Ini</a>
        <a href="?periode=bulan" class="filter-btn">Bulan Ini</a>
        <a href="?periode=tahun" class="filter-btn">Tahun Ini</a>
    </div>
    
    <div class="summary">
        <div class="sum-card">
            <small>Penjualan</small>
            <h3 class="green" id="totalPenjualan">Rp <?= number_format($summary['today_sales'],0,',','.'); ?></h3>
            <small id="jumlahPenjualan">1 transaksi</small>
        </div>
        <div class="sum-card">
            <small>Pengeluaran</small>
            <h3 class="red" id="totalPengeluaran">Rp <?= number_format($summary['today_expense'],0,',','.'); ?></h3>
            <small id="jumlahPengeluaran">1 transaksi</small>
        </div>
        <div class="sum-card">
            <small>Laba Bersih</small>
            <h3 class="blue" id="labaBersih">Rp <?= number_format($summary['today_profit'],0,',','.'); ?></h3>
            <small id="marginProfit">Margin: <?= ($summary['today_sales']>0)?round(($summary['today_profit']/$summary['today_sales'])*100,1):0; ?>%</small>
        </div>
    </div>

    <!-- GRAFIK & INSIGHT -->
<div class="chart-insight-wrapper">

    <!-- GRAFIK -->
    <div class="chart-section">
        <div class="chart-header">
            <h4>Tren Keuangan (7 Hari Terakhir)</h4>
            <div class="chart-legend">
                <div class="legend-item">
                    <div class="legend-color legend-sales"></div>
                    <span>Penjualan</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color legend-expense"></div>
                    <span>Pengeluaran</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color legend-profit"></div>
                    <span>Laba</span>
                </div>
            </div>
        </div>

        <!-- WRAPPER WAJIB -->
        <div class="chart-canvas-wrapper">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- INSIGHT -->
    <div class="insight-section">
        <h4>Insight Bisnis</h4>

        <div class="insight-item">
            <strong>Performa Baik</strong>
            <p>Penjualan hari ini meningkat dibanding hari sebelumnya.</p>
        </div>

        <div class="insight-item">
            <strong>Efisiensi Biaya</strong>
            <p>Pengeluaran relatif stabil dan terkontrol.</p>
        </div>

        <div class="insight-item">
            <strong>Rekomendasi</strong>
            <p>Tambahkan stok produk favorit untuk memaksimalkan penjualan.</p>
        </div>
    </div>

</div>


    <!-- TRANSAKSI -->
    <div class="section-title">Transaksi Terbaru <span style="font-size:13px;font-weight:normal;margin-left:10px;color:#999" id="jumlahTransaksi"><?= count($transactions); ?> transaksi</span></div>
    <div class="transaksi" id="transaksiList">
        <?php if($transactions): foreach($transactions as $tx): $neg = ($tx['amount'] < 0); ?>
        <div class="tx <?= $neg?'minus':'plus'; ?>">
            <div>
                <strong><?= htmlspecialchars($tx['title']); ?></strong><br>
                <small><?= $tx['type']; ?></small>
            </div>
            <div><?= $neg?'-':'+'; ?> Rp <?= number_format(abs($tx['amount']),0,',','.'); ?></div>
        </div>
        <?php endforeach; else: ?>
        <p class="text-muted">Belum ada transaksi</p>
        <?php endif; ?>
    </div>

</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Data dummy untuk demo (nanti bisa diambil dari backend)
const chartData = {
    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
    sales: [2500000, 3200000, 2800000, 4100000, 3600000, 4800000, 3900000],
    expense: [1200000, 1500000, 1100000, 1800000, 1400000, 2000000, 1600000],
    profit: [1300000, 1700000, 1700000, 2300000, 2200000, 2800000, 2300000]
};

// Initialize Chart
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData.labels,
        datasets: [
            {
                label: 'Penjualan',
                data: chartData.sales,
                borderColor: '#2ecc71',
                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#2ecc71',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            },
            {
                label: 'Pengeluaran',
                data: chartData.expense,
                borderColor: '#e74c3c',
                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#e74c3c',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            },
            {
                label: 'Laba Bersih',
                data: chartData.profit,
                borderColor: '#1C6494',
                backgroundColor: 'rgba(28, 100, 148, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#1C6494',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        return label;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + (value / 1000000) + 'jt';
                    },
                    font: {
                        size: 11
                    }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 11,
                        weight: '600'
                    }
                }
            }
        }
    }
});

// Filter periode functionality
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Update active state
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Get periode parameter
        const periode = this.href.split('periode=')[1];
        
        // Update chart title based on periode
        const titles = {
            'hari': '7 Hari Terakhir',
            'minggu': '4 Minggu Terakhir',
            'bulan': '12 Bulan Terakhir',
            'tahun': '5 Tahun Terakhir'
        };
        
        document.querySelector('.chart-header h4').innerHTML = 
            '📊 Tren Keuangan (' + titles[periode] + ')';
        
        // Here you can add AJAX call to fetch new data based on periode
        // For demo, we'll just keep the same data
        console.log('Filter changed to:', periode);
    });
});
</script>

<!-- FOOTER SIMPLE -->
<footer class="footer-simple">
    <div class="footer-inner">
        <div class="footer-left">
            © 2025 <span class="brand">Usahain</span> · Platform Manajemen UMKM Terpadu
        </div>
        <div class="footer-right">
            <a href="#">Tentang</a>
            <span>•</span>
            <a href="#">Fitur</a>
            <span>•</span>
            <a href="#">Kebijakan Privasi</a>
            <span>•</span>
            <a href="#">Bantuan</a>
        </div>
    </div>
</footer>

<!-- MODAL CATAT PENJUALAN -->
<div class="modal-overlay" id="modalPenjualan" onclick="if(event.target===this) closeModalPenjualan()">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">💰 Catat Penjualan</h3>
            <p class="modal-subtitle">Masukkan detail penjualan Anda</p>
        </div>
        <form id="formPenjualan" onsubmit="submitPenjualan(event)">
            <div class="modal-body">
                <div class="modal-form-group">
                    <label class="modal-label" for="inputJumlah">Jumlah (Rp)</label>
                    <input 
                        type="text" 
                        id="inputJumlah" 
                        class="modal-input" 
                        placeholder="150.000"
                        oninput="formatRupiah(this)"
                        required
                    >
                </div>
                <div class="modal-form-group">
                    <label class="modal-label" for="inputKategori">Kategori</label>
                    <select id="inputKategori" class="modal-select" required>
                        <option value="" disabled selected>Pilih kategori</option>
                        <option value="Makanan & Minuman">Makanan & Minuman</option>
                        <option value="Produk">Produk</option>
                        <option value="Jasa">Jasa</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="modal-form-group">
                    <label class="modal-label" for="inputDeskripsi">Deskripsi</label>
                    <textarea 
                        id="inputDeskripsi" 
                        class="modal-textarea" 
                        placeholder="Penjualan nasi ayam 10 porsi"
                        required
                    ></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-secondary" onclick="closeModalPenjualan()">Batal</button>
                <button type="submit" class="modal-btn modal-btn-primary">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL CATAT PENGELUARAN -->
<div class="modal-overlay" id="modalPengeluaran" onclick="if(event.target===this) closeModalPengeluaran()">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">🧾 Catat Pengeluaran</h3>
            <p class="modal-subtitle">Masukkan detail pengeluaran Anda</p>
        </div>
        <form id="formPengeluaran" onsubmit="submitPengeluaran(event)">
            <div class="modal-body">
                <div class="modal-form-group">
                    <label class="modal-label" for="inputJumlahPengeluaran">Jumlah (Rp)</label>
                    <input 
                        type="text" 
                        id="inputJumlahPengeluaran" 
                        class="modal-input" 
                        placeholder="75.000"
                        oninput="formatRupiah(this)"
                        required
                    >
                </div>
                <div class="modal-form-group">
                    <label class="modal-label" for="inputKategoriPengeluaran">Kategori</label>
                    <select id="inputKategoriPengeluaran" class="modal-select" required>
                        <option value="" disabled selected>Pilih kategori</option>
                        <option value="Bahan Baku">Bahan Baku</option>
                        <option value="Operasional">Operasional</option>
                        <option value="Gaji Karyawan">Gaji Karyawan</option>
                        <option value="Utilitas">Utilitas (Listrik, Air)</option>
                        <option value="Transport">Transport</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="modal-form-group">
                    <label class="modal-label" for="inputDeskripsiPengeluaran">Deskripsi</label>
                    <textarea 
                        id="inputDeskripsiPengeluaran" 
                        class="modal-textarea" 
                        placeholder="Pembelian beras 25kg"
                        required
                    ></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-secondary" onclick="closeModalPengeluaran()">Batal</button>
                <button type="submit" class="modal-btn modal-btn-danger">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL MANAJEMEN RISIKO -->
<div class="modal-overlay" id="modalRisiko" onclick="if(event.target===this) closeModalRisiko()">
    <div class="modal-container wide">
        <div class="modal-header">
            <h3 class="modal-title">⚠️ Manajemen Risiko Bisnis</h3>
            <p class="modal-subtitle">Identifikasi dan kelola risiko untuk melindungi bisnis Anda</p>
        </div>
        <form id="formRisiko" onsubmit="submitRisiko(event)">
            <div class="modal-body">
                
                <!-- SKOR RISIKO -->
                <div class="score-section">
                    <div class="score-header">📊 Skor Kesehatan Bisnis</div>
                    <div class="score-text" id="riskScore">0%</div>
                    <div class="score-bar-container">
                        <div class="score-bar" id="riskScoreBar" style="width:0%">0%</div>
                    </div>
                    <div class="score-desc" id="riskDesc">Mulai centang item di bawah untuk menilai risiko bisnis Anda</div>
                </div>

                <!-- RISK CARDS GRID -->
                <div class="risk-grid">
                    
                    <!-- RISIKO TINGGI -->
                    <div class="risk-card red">
                        <div class="risk-card-header">
                            <div class="risk-icon">🔴</div>
                            <div>Risiko Tinggi</div>
                        </div>
                        <div class="risk-checklist">
                            <div class="risk-checkbox">
                                <input type="checkbox" id="risk1" onchange="calculateRiskScore()">
                                <label for="risk1">Tidak ada asuransi bisnis</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="risk2" onchange="calculateRiskScore()">
                                <label for="risk2">Hanya 1 supplier utama</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="risk3" onchange="calculateRiskScore()">
                                <label for="risk3">Tidak ada dana darurat</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="risk4" onchange="calculateRiskScore()">
                                <label for="risk4">Lokasi rawan bencana</label>
                            </div>
                        </div>
                    </div>

                    <!-- RISIKO SEDANG -->
                    <div class="risk-card yellow">
                        <div class="risk-card-header">
                            <div class="risk-icon">🟡</div>
                            <div>Risiko Sedang</div>
                        </div>
                        <div class="risk-checklist">
                            <div class="risk-checkbox">
                                <input type="checkbox" id="risk5" onchange="calculateRiskScore()">
                                <label for="risk5">Fluktuasi harga bahan</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="risk6" onchange="calculateRiskScore()">
                                <label for="risk6">Kompetitor baru muncul</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="risk7" onchange="calculateRiskScore()">
                                <label for="risk7">Bisnis musiman</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="risk8" onchange="calculateRiskScore()">
                                <label for="risk8">Karyawan kunci resign</label>
                            </div>
                        </div>
                    </div>

                    <!-- MITIGASI RISIKO -->
                    <div class="risk-card green">
                        <div class="risk-card-header">
                            <div class="risk-icon">🟢</div>
                            <div>Mitigasi Risiko</div>
                        </div>
                        <div class="risk-checklist">
                            <div class="risk-checkbox">
                                <input type="checkbox" id="mitigasi1" onchange="calculateRiskScore()">
                                <label for="mitigasi1">Kontrak supplier jangka panjang</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="mitigasi2" onchange="calculateRiskScore()">
                                <label for="mitigasi2">Diversifikasi produk/layanan</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="mitigasi3" onchange="calculateRiskScore()">
                                <label for="mitigasi3">Dana darurat 6 bulan</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="mitigasi4" onchange="calculateRiskScore()">
                                <label for="mitigasi4">SOP tertulis lengkap</label>
                            </div>
                        </div>
                    </div>

                    <!-- RENCANA KONTINJENSI -->
                    <div class="risk-card blue">
                        <div class="risk-card-header">
                            <div class="risk-icon">🔵</div>
                            <div>Rencana Kontinjensi</div>
                        </div>
                        <div class="risk-checklist">
                            <div class="risk-checkbox">
                                <input type="checkbox" id="kontinjensi1" onchange="calculateRiskScore()">
                                <label for="kontinjensi1">Backup supplier tersedia</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="kontinjensi2" onchange="calculateRiskScore()">
                                <label for="kontinjensi2">Sistem pembayaran digital</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="kontinjensi3" onchange="calculateRiskScore()">
                                <label for="kontinjensi3">Kemampuan WFH/remote</label>
                            </div>
                            <div class="risk-checkbox">
                                <input type="checkbox" id="kontinjensi4" onchange="calculateRiskScore()">
                                <label for="kontinjensi4">Asuransi bisnis aktif</label>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-secondary" onclick="closeModalRisiko()">Batal</button>
                <button type="submit" class="modal-btn modal-btn-primary">Simpan Assessment</button>
            </div>
        </form>
    </div>
</div>

<script>
// Data tracking
let dataKeuangan = {
    penjualan: <?= $summary['today_sales']; ?>,
    pengeluaran: <?= $summary['today_expense']; ?>,
    jumlahTransaksiPenjualan: 1,
    jumlahTransaksiPengeluaran: 1,
    totalTransaksi: <?= count($transactions); ?>
};

// Format number to Rupiah
function formatRupiahDisplay(number) {
    return 'Rp ' + parseInt(number).toLocaleString('id-ID');
}

// Update all displays
function updateDisplay() {
    const labaBersih = dataKeuangan.penjualan - dataKeuangan.pengeluaran;
    const margin = dataKeuangan.penjualan > 0 ? ((labaBersih / dataKeuangan.penjualan) * 100).toFixed(1) : 0;

    console.log('Updating displays...');
    console.log('Penjualan:', dataKeuangan.penjualan);
    console.log('Pengeluaran:', dataKeuangan.pengeluaran);
    console.log('Laba Bersih:', labaBersih);

    // Update header
    const headerEl = document.getElementById('labaBersihHeader');
    if (headerEl) {
        headerEl.textContent = formatRupiahDisplay(labaBersih);
        console.log('✓ Header updated');
    }

    // Update summary cards
    const penjualanEl = document.getElementById('totalPenjualan');
    if (penjualanEl) {
        penjualanEl.textContent = formatRupiahDisplay(dataKeuangan.penjualan);
        console.log('✓ Penjualan updated');
    }

    const pengeluaranEl = document.getElementById('totalPengeluaran');
    if (pengeluaranEl) {
        pengeluaranEl.textContent = formatRupiahDisplay(dataKeuangan.pengeluaran);
        console.log('✓ Pengeluaran updated');
    }

    const labaBersihEl = document.getElementById('labaBersih');
    if (labaBersihEl) {
        labaBersihEl.textContent = formatRupiahDisplay(labaBersih);
        console.log('✓ Laba Bersih updated');
    }
    
    const jumlahPenjualanEl = document.getElementById('jumlahPenjualan');
    if (jumlahPenjualanEl) {
        jumlahPenjualanEl.textContent = dataKeuangan.jumlahTransaksiPenjualan + ' transaksi';
    }
    
    const jumlahPengeluaranEl = document.getElementById('jumlahPengeluaran');
    if (jumlahPengeluaranEl) {
        jumlahPengeluaranEl.textContent = dataKeuangan.jumlahTransaksiPengeluaran + ' transaksi';
    }
    
    const marginEl = document.getElementById('marginProfit');
    if (marginEl) {
        marginEl.textContent = 'Margin: ' + margin + '%';
    }
    
    // Update total transaksi
    const totalTxEl = document.getElementById('jumlahTransaksi');
    if (totalTxEl) {
        totalTxEl.textContent = dataKeuangan.totalTransaksi + ' transaksi';
    }

    console.log('All displays updated successfully!');
}

// Add transaction to list
function addTransactionToList(title, kategori, amount) {
    const transaksiList = document.getElementById('transaksiList');
    
    // Remove "belum ada transaksi" message if exists
    const emptyMsg = transaksiList.querySelector('.text-muted');
    if (emptyMsg) {
        emptyMsg.remove();
    }

    // Create new transaction element
    const newTx = document.createElement('div');
    newTx.className = 'tx plus';
    newTx.style.animation = 'slideIn 0.3s ease-out';
    newTx.innerHTML = `
        <div>
            <strong>${title}</strong><br>
            <small>Baru saja • ${kategori}</small>
        </div>
        <div>+ Rp ${parseInt(amount).toLocaleString('id-ID')}</div>
    `;

    // Add to top of list
    transaksiList.insertBefore(newTx, transaksiList.firstChild);
}

// Add expense transaction to list
function addExpenseToList(title, kategori, amount) {
    const transaksiList = document.getElementById('transaksiList');
    
    // Remove "belum ada transaksi" message if exists
    const emptyMsg = transaksiList.querySelector('.text-muted');
    if (emptyMsg) {
        emptyMsg.remove();
    }

    // Create new transaction element
    const newTx = document.createElement('div');
    newTx.className = 'tx minus';
    newTx.style.animation = 'slideIn 0.3s ease-out';
    newTx.innerHTML = `
        <div>
            <strong>${title}</strong><br>
            <small>Baru saja • ${kategori}</small>
        </div>
        <div>- Rp ${parseInt(amount).toLocaleString('id-ID')}</div>
    `;

    // Add to top of list
    transaksiList.insertBefore(newTx, transaksiList.firstChild);
}

// Open Modal Penjualan
function openModalPenjualan() {
    document.getElementById('modalPenjualan').classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Close Modal Penjualan
function closeModalPenjualan() {
    document.getElementById('modalPenjualan').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('formPenjualan').reset();
}

// Open Modal Pengeluaran
function openModalPengeluaran() {
    document.getElementById('modalPengeluaran').classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Close Modal Pengeluaran
function closeModalPengeluaran() {
    document.getElementById('modalPengeluaran').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('formPengeluaran').reset();
}

// Open Modal Risiko
function openModalRisiko() {
    document.getElementById('modalRisiko').classList.add('active');
    document.body.style.overflow = 'hidden';
    calculateRiskScore(); // Calculate initial score
}

// Close Modal Risiko
function closeModalRisiko() {
    document.getElementById('modalRisiko').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('formRisiko').reset();
}

// Calculate Risk Score
function calculateRiskScore() {
    // Count checked items in each category
    const risikoTinggi = [1,2,3,4].filter(i => document.getElementById('risk'+i)?.checked).length;
    const risikoSedang = [5,6,7,8].filter(i => document.getElementById('risk'+i)?.checked).length;
    const mitigasi = [1,2,3,4].filter(i => document.getElementById('mitigasi'+i)?.checked).length;
    const kontinjensi = [1,2,3,4].filter(i => document.getElementById('kontinjensi'+i)?.checked).length;
    
    // Calculate score (lower risk = higher score)
    // Negative points for risks, positive points for mitigations
    const negativePoints = (risikoTinggi * 10) + (risikoSedang * 5);
    const positivePoints = (mitigasi * 8) + (kontinjensi * 7);
    
    // Score from 0-100
    let score = 50 + positivePoints - negativePoints;
    score = Math.max(0, Math.min(100, score)); // Clamp between 0-100
    
    // Update UI
    const scoreText = document.getElementById('riskScore');
    const scoreBar = document.getElementById('riskScoreBar');
    const scoreDesc = document.getElementById('riskDesc');
    
    if (scoreText && scoreBar && scoreDesc) {
        scoreText.textContent = Math.round(score) + '%';
        scoreBar.style.width = score + '%';
        scoreBar.textContent = Math.round(score) + '%';
        
        // Change color based on score
        if (score >= 75) {
            scoreBar.style.background = '#2ecc71';
            scoreDesc.textContent = '✅ Excellent! Bisnis Anda memiliki manajemen risiko yang baik';
        } else if (score >= 50) {
            scoreBar.style.background = '#f39c12';
            scoreDesc.textContent = '⚠️ Cukup baik, namun masih ada area yang perlu diperbaiki';
        } else if (score >= 25) {
            scoreBar.style.background = '#e67e22';
            scoreDesc.textContent = '⚠️ Perlu perhatian! Risiko bisnis cukup tinggi';
        } else {
            scoreBar.style.background = '#e74c3c';
            scoreDesc.textContent = '🚨 Urgent! Bisnis Anda memiliki risiko tinggi yang perlu segera ditangani';
        }
    }
    
    console.log('Risk Assessment:', {
        risikoTinggi,
        risikoSedang,
        mitigasi,
        kontinjensi,
        score: Math.round(score)
    });
}

// Format Rupiah
function formatRupiah(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    if (value) {
        value = parseInt(value).toLocaleString('id-ID');
    }
    input.value = value;
}

// Submit Form Penjualan
function submitPenjualan(e) {
    e.preventDefault();
    
    const jumlahRaw = document.getElementById('inputJumlah').value.replace(/[^0-9]/g, '');
    const jumlah = parseInt(jumlahRaw);
    const kategori = document.getElementById('inputKategori').value;
    const deskripsi = document.getElementById('inputDeskripsi').value;
    
    console.log('=== SUBMIT PENJUALAN ===');
    console.log('Jumlah:', jumlah);
    console.log('Kategori:', kategori);
    console.log('Deskripsi:', deskripsi);
    
    // Validasi
    if (!jumlah || isNaN(jumlah) || jumlah <= 0) {
        alert('⚠️ Masukkan jumlah yang valid!');
        return;
    }
    
    // Update data keuangan
    dataKeuangan.penjualan += jumlah;
    dataKeuangan.jumlahTransaksiPenjualan++;
    dataKeuangan.totalTransaksi++;
    
    // Add to transaction list
    addTransactionToList(deskripsi, kategori, jumlah);
    
    // Update all displays
    updateDisplay();
    
    // Show success notification
    showNotification('✅ Penjualan berhasil dicatat! Rp ' + parseInt(jumlah).toLocaleString('id-ID'), 'success');
    
    closeModalPenjualan();
}

// Submit Form Pengeluaran
function submitPengeluaran(e) {
    e.preventDefault();
    
    const jumlahRaw = document.getElementById('inputJumlahPengeluaran').value.replace(/[^0-9]/g, '');
    const jumlah = parseInt(jumlahRaw);
    const kategori = document.getElementById('inputKategoriPengeluaran').value;
    const deskripsi = document.getElementById('inputDeskripsiPengeluaran').value;
    
    console.log('=== SUBMIT PENGELUARAN ===');
    console.log('Jumlah:', jumlah);
    console.log('Kategori:', kategori);
    console.log('Deskripsi:', deskripsi);
    
    // Validasi
    if (!jumlah || isNaN(jumlah) || jumlah <= 0) {
        alert('⚠️ Masukkan jumlah yang valid!');
        return;
    }
    
    // Update data keuangan
    dataKeuangan.pengeluaran += jumlah;
    dataKeuangan.jumlahTransaksiPengeluaran++;
    dataKeuangan.totalTransaksi++;
    
    // Add to transaction list
    addExpenseToList(deskripsi, kategori, jumlah);
    
    // Update all displays
    updateDisplay();
    
    // Show success notification
    showNotification('✅ Pengeluaran berhasil dicatat! Rp ' + parseInt(jumlah).toLocaleString('id-ID'), 'error');
    
    closeModalPengeluaran();
}

// Submit Form Risiko
function submitRisiko(e) {
    e.preventDefault();
    
    // Get score
    const scoreText = document.getElementById('riskScore').textContent;
    const scoreDesc = document.getElementById('riskDesc').textContent;
    
    console.log('=== SUBMIT RISK ASSESSMENT ===');
    console.log('Score:', scoreText);
    console.log('Description:', scoreDesc);
    
    // Count items
    const totalChecked = document.querySelectorAll('#formRisiko input[type="checkbox"]:checked').length;
    
    // Show success notification
    showNotification('✅ Assessment risiko berhasil disimpan! Skor: ' + scoreText + ' (' + totalChecked + ' item teridentifikasi)', 'success');
    
    closeModalRisiko();
}

// Show notification
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#2fb12f' : '#e74c3c'};
        color: white;
        padding: 16px 24px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideInRight 0.3s ease-out;
        font-weight: 600;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModalPenjualan();
        closeModalPengeluaran();
        closeModalRisiko();
    }
});

// Add CSS animations
const styleAnimations = document.createElement('style');
styleAnimations.textContent = `
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(100px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideOutRight {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(100px); }
    }
`;
document.head.appendChild(styleAnimations);
</script>

</body>
</html>


<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HPP Calculator - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #0b6ea8;
            --primary-dark: #084f8a;
            --primary-light: #ecf9ff;
            --secondary: #27b0e3;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --text: #1E293B;
            --text-secondary: #64748B;
            --bg: #f8fafc;
            --card: #FFFFFF;
            --border: #E2E8F0;
            --shadow: 0 4px 12px rgba(11,110,168,0.1);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Inter', Arial, sans-serif; 
            background: linear-gradient(180deg, #F8FBFD 0%, #F7FAFC 100%);
            color: var(--text); 
            min-height: 100vh;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(11,110,168,0.02) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(39,176,227,0.02) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        .sidebar-menu {
            background: none;
            box-shadow: none;
            backdrop-filter: none;
            border-bottom: none;
        }
        .breadcrumb-nav {
            margin-bottom: 20px;
        }
        .breadcrumb-nav .breadcrumb {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .breadcrumb-nav a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 0;
            display: inline;
            background: none;
        }
        .breadcrumb-nav a:hover {
            color: #fff;
            background: none;
        }
        .container { 
            max-width: 1400px; 
            margin: 32px auto; 
            padding: 0 18px;
            position: relative;
            z-index: 1;
        }
        
        /* Header/Hero Section */
        .page-header {
            margin-bottom: 32px;
            background: linear-gradient(135deg, #0b6ea8 0%, #084f8a 50%, #0a3d6f 100%);
            border-radius: 20px;
            padding: 56px 48px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(11,110,168,0.25);
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .page-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .header-content {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 50px;
            align-items: center;
        }
        .header-text h1 {
            font-size: 3.2rem;
            font-weight: 800;
            margin-bottom: 16px;
            letter-spacing: -1px;
            text-shadow: 0 4px 20px rgba(0,0,0,0.2);
            background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.95) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .header-text p {
            font-size: 1.15rem;
            color: rgba(255,255,255,0.95);
            margin: 0;
            line-height: 1.8;
            max-width: 520px;
            font-weight: 300;
        }
        .header-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-top: 24px;
        }
        .header-stat {
            background: linear-gradient(135deg, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.10) 100%);
            backdrop-filter: blur(25px);
            border-radius: 16px;
            padding: 28px 32px;
            border: 2px solid rgba(255,255,255,0.35);
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .header-stat .label {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.85);
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
            font-family: 'Inter', sans-serif;
        }
        .header-stat .value {
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            position: relative;
            z-index: 1;
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.3px;
        }
        .header-actions {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 18px;
            margin-top: 28px;
            grid-column: 1 / -1;
            flex-wrap: wrap;
            align-items: center;
        }
        .btn-header {
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 800;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 1.05rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: visible;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
            white-space: nowrap;
            text-shadow: 0 2px 4px rgba(0,0,0,0.15);
            letter-spacing: 0.3px;
            min-height: 50px;
            pointer-events: auto;
            z-index: 10;
        }
        .btn-header span {
            position: relative;
            z-index: 3;
            pointer-events: none;
        }
        .btn-header::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.4);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            pointer-events: none;
        }

        .btn-header.primary {
            background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
            color: #fff;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        }
        .btn-header.primary:active {
            
        }
        .btn-header.secondary {
            background: linear-gradient(135deg, #0b6ea8 0%, #27b0e3 100%);
            color: #fff;
            border: 2px solid rgba(255,255,255,0.3);
            box-shadow: 0 8px 24px rgba(11, 110, 168, 0.3);
        }
        .btn-header.secondary:active {
            
        }
        .breadcrumb {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            font-size: 0.9rem;
            opacity: 0.9;
            list-style: none;
        }
        .breadcrumb a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }
        .breadcrumb a:hover {
            color: #fff;
        }
        .breadcrumb span {
            color: rgba(255,255,255,0.6);
        }
        
        /* Main Grid Layout */
        .dashboard-grid { 
            display: grid; 
            grid-template-columns: 2fr 1fr; 
            gap: 28px; 
            margin-bottom: 28px;
        }
        
        /* Top Summary Cards */
        .summary-cards { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 18px; 
            margin-bottom: 28px;
        }

        .summary-card { 
            background: linear-gradient(135deg, var(--card) 0%, #f8fafb 100%);
            border-radius: 16px; 
            padding: 28px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-top: 5px solid var(--primary);
            position: relative;
            overflow: hidden;
        }
        .summary-card::before {
            content: '';
            position: absolute;
            top: -100%;
            right: -100%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(11,110,168,0.05) 0%, transparent 70%);
            border-radius: 50%;
        }
        .summary-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(11,110,168,0.12);
        }
        .summary-card:hover::before {
            top: -50%;
            right: -50%;
        }
        .summary-card.success { border-top-color: var(--success); }
        .summary-card.danger { border-top-color: var(--danger); }
        .summary-card.warning { border-top-color: var(--warning); }
        .summary-card .label { 
            color: var(--text-secondary); 
            font-size: 0.85rem; 
            font-weight: 600; 
            margin-bottom: 10px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .summary-card .value { 
            font-size: 1.9rem; 
            font-weight: 800; 
            color: var(--primary); 
            line-height: 1;
        }
        .summary-card .change { 
            font-size: 0.85rem; 
            color: var(--success); 
            margin-top: 10px;
            font-weight: 600;
        }
        .summary-card .change.negative { color: var(--danger); }
        
        /* Charts */
        .chart-container { 
            background: linear-gradient(135deg, var(--card) 0%, #f8fafb 100%);
            border-radius: 16px; 
            padding: 28px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 28px;
        }
        .chart-title { 
            font-size: 1.25rem; 
            font-weight: 750; 
            margin-bottom: 24px; 
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .chart-wrapper { 
            position: relative; 
            height: 300px;
        }
        
        /* Right Sidebar */
        .sidebar { 
            display: flex; 
            flex-direction: column; 
            gap: 28px;
        }
        .card { 
            background: linear-gradient(135deg, var(--card) 0%, #f8fafb 100%);
            border-radius: 16px; 
            padding: 28px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .card-title { 
            font-size: 1.15rem; 
            font-weight: 750; 
            margin-bottom: 18px; 
            color: var(--primary); 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
        }
        .card-title .action { 
            font-size: 1.2rem; 
            cursor: pointer; 
        }
        
        /* Transaction List */
        .transaction-list { 
            display: flex; 
            flex-direction: column; 
            gap: 12px; 
            max-height: 400px; 
            overflow-y: auto;
        }
        .transaction-list::-webkit-scrollbar {
            width: 6px;
        }
        .transaction-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .transaction-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .transaction-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .transaction-item { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 14px; 
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            border-left: 4px solid transparent;
        }
        .transaction-item:hover {
            background: linear-gradient(135deg, #ecf9ff 0%, #e0f2fe 100%);
            border-left-color: var(--secondary);
        }
        .transaction-item .icon { 
            width: 40px; 
            height: 40px; 
            border-radius: 10px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .transaction-item .details { flex: 1; }
        .transaction-item .name { 
            font-weight: 700; 
            font-size: 0.95rem; 
            color: var(--primary);
        }
        .transaction-item .time { 
            font-size: 0.8rem; 
            color: var(--text-secondary); 
            margin-top: 3px;
        }
        .transaction-item .amount { 
            font-weight: 800; 
            color: var(--primary);
            font-size: 0.9rem;
        }
        
        /* Data Table */
        .table-container { 
            background: linear-gradient(135deg, var(--card) 0%, #f8fafb 100%);
            border-radius: 16px; 
            padding: 28px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .table-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }
        .table-header h2 { 
            font-size: 1.25rem; 
            font-weight: 750; 
            color: var(--primary);
        }
        .filter-row { 
            display: flex; 
            gap: 12px;
            flex-wrap: wrap;
        }
        .filter-row input, .filter-row select { 
            padding: 11px 16px; 
            border-radius: 10px; 
            border: 2px solid var(--border);
            font-size: 0.9rem; 
            background: #fff;
            font-family: 'Inter', sans-serif;
        }
        .filter-row input:focus, .filter-row select:focus { 
            outline: none; 
            border-color: var(--primary); 
            box-shadow: 0 0 0 4px rgba(11,110,168,0.1);
        }
        .filter-row input::placeholder {
            color: #999;
        }
        .filter-row input:active {
            border-color: var(--primary);
        }
        
        .table-wrapper { 
            overflow-x: auto; 
            border-radius: 12px;
        }
        table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0; 
            font-size: 0.9rem;
        }
        thead { 
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }
        th { 
            padding: 16px 14px; 
            color: #fff; 
            font-weight: 700; 
            text-align: left; 
            border: none;
        }
        th:first-child { border-radius: 12px 0 0 0; }
        th:last-child { border-radius: 0 12px 0 0; }
        tbody tr { 
            border-bottom: 1px solid var(--border); 
        }
        tbody tr:hover { 
            background: #f0f9fc;
            box-shadow: inset 0 0 0 1px rgba(11,110,168,0.1);
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:last-child td:first-child { border-radius: 0 0 0 12px; }
        tbody tr:last-child td:last-child { border-radius: 0 0 12px 0; }
        td { 
            padding: 14px; 
            color: var(--text); 
            border: none;
        }
        td:first-child { 
            font-weight: 700; 
            color: var(--primary);
        }
        .currency { 
            text-align: right; 
            font-weight: 700; 
            color: var(--primary);
            font-family: 'Courier New', monospace;
        }
        .badge { 
            display: inline-block; 
            padding: 6px 14px; 
            border-radius: 20px; 
            font-size: 0.8rem; 
            font-weight: 700;
        }
        .badge.success { 
            background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
            color: #065F46;
        }
        .badge.danger { 
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            color: #991B1B;
        }
        .badge.warning { 
            background: linear-gradient(135deg, #FEF3C7 0%, #FCD34D 100%);
            color: #92400E;
        }
        
        .action-buttons { 
            display: flex; 
            gap: 8px;
            align-items: center;
            justify-content: center;
        }
        .action-btn { 
            padding: 8px 12px; 
            border-radius: 8px; 
            background: linear-gradient(135deg, var(--primary), var(--secondary)); 
            color: #fff; 
            border: none; 
            cursor: pointer; 
            font-size: 1rem; 
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            min-width: 35px;
            justify-content: center;
        }
        .action-btn:hover { 
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(11,110,168,0.25);
        }
        .action-btn.view {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }
        .action-btn.view:hover {
            box-shadow: 0 6px 16px rgba(11,110,168,0.25);
        }
        .action-btn.edit { 
            background: linear-gradient(135deg, var(--warning), #FBBF24);
        }
        .action-btn.edit:hover {
            box-shadow: 0 6px 16px rgba(245,158,11,0.25);
        }
        .action-btn.delete { 
            background: linear-gradient(135deg, var(--danger), #F87171);
        }
        .action-btn.delete:hover {
            box-shadow: 0 6px 16px rgba(239,68,68,0.25);
        }
        
        /* Margin Analysis Section */
        .margin-analysis-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin: 24px 0;
        }
        .margin-analysis-card {
            background: linear-gradient(135deg, #FFFFFF, #F8FAFC);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(11,110,168,0.08);
            border: 1px solid rgba(11,110,168,0.1);
            position: relative;
            overflow: hidden;
        }
        .margin-analysis-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--success), #34D399);
        }
        .margin-analysis-card.warning::before {
            background: linear-gradient(90deg, var(--warning), #FBBF24);
        }
        .margin-analysis-card.danger::before {
            background: linear-gradient(90deg, var(--danger), #F87171);
        }
        .margin-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .margin-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 12px;
            font-family: 'Courier New', monospace;
        }
        .margin-analysis-card.success .margin-value {
            color: var(--success);
        }
        .margin-analysis-card.warning .margin-value {
            color: var(--warning);
        }
        .margin-analysis-card.danger .margin-value {
            color: var(--danger);
        }
        .margin-change {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 10px;
            border-radius: 6px;
            display: inline-block;
            background: rgba(16,185,129,0.1);
            color: var(--success);
        }
        .margin-change.negative {
            background: rgba(239,68,68,0.1);
            color: var(--danger);
        }
        .margin-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--success);
            margin-right: 6px;
        }
        .margin-indicator.warning {
            background: var(--warning);
        }
        .margin-indicator.danger {
            background: var(--danger);
        }

        /* Real-time update notification */
        .update-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, var(--success), #34D399);
            color: white;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(16,185,129,0.3);
            opacity: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .update-notification.show {
            opacity: 1;
        }
        .update-notification.error {
            background: linear-gradient(135deg, var(--danger), #F87171);
        }
        


        .btn-success { 
            background: linear-gradient(135deg, var(--success), #34D399); 
            color: #fff;
        }
        .btn-success:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 8px 20px rgba(16,185,129,0.3);
        }
        
        .empty-state { 
            padding: 60px 20px; 
            text-align: center; 
            color: var(--text-secondary);
        }
        .empty-state p { 
            margin-bottom: 20px;
            font-size: 1.05rem;
        }
        
        @media (max-width: 1200px) {
            .dashboard-grid { grid-template-columns: 1fr; }
            .summary-cards { grid-template-columns: repeat(2, 1fr); }
            .header-content { grid-template-columns: 1fr; gap: 30px; }
            .header-stats { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 768px) {
            .summary-cards { grid-template-columns: 1fr; }
            .chart-wrapper { height: 200px; }
            .header-stats { grid-template-columns: 1fr; }
            .header-text h1 { font-size: 2.2rem; }
            .page-header { padding: 36px 24px; }
            .table-header { flex-direction: column; align-items: flex-start; }
            .filter-row { width: 100%; }
            .filter-row input, .filter-row select { width: 100%; }
            table { font-size: 0.8rem; }
            td, th { padding: 10px 8px; }
            .action-btn { padding: 6px 10px; font-size: 0.7rem; }
        }
        @media (max-width: 480px) {
            .summary-cards { grid-template-columns: 1fr; }
            .header-text h1 { font-size: 1.8rem; }
            .header-actions { flex-direction: column; }
            .btn-header { width: 100%; justify-content: center; }
            .page-header { padding: 24px 16px; }
            .container { padding: 0 12px; margin: 20px auto; }
            th { padding: 12px 8px; font-size: 0.75rem; }
            td { padding: 8px; }
            .action-buttons { gap: 4px; }
            .action-btn { padding: 6px 10px; font-size: 0.9rem; min-width: 32px; }
            .table-header { flex-direction: column; gap: 12px; }
            .filter-row { width: 100%; flex-direction: column; }
            .filter-row input, .filter-row select { width: 100%; }
            .card, .chart-container, .table-container { padding: 20px; }
            .header-stat { padding: 16px 12px; }
            .summary-card { padding: 20px; }
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--primary);
            font-weight: 700;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 28px;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: var(--text);
        }

        #hppForm {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text);
            font-size: 0.95rem;
        }

        .required {
            color: #dc2626;
            font-weight: bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            color: var(--text);
            background: white;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
            font-size: 0.95rem;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(11, 110, 168, 0.1);
        }

        .form-group input:read-only {
            background: var(--bg);
            color: var(--text-secondary);
            cursor: not-allowed;
        }

        .form-group select {
            cursor: pointer;
        }

        .form-hint {
            display: block;
            margin-top: 6px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .modal-large {
            max-width: 600px;
            width: 95%;
        }

        .modal-footer {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 18px;
            border-top: 1px solid var(--border);
        }

        .btn-cancel {
            padding: 10px 24px;
            border: 2px solid var(--border);
            background: white;
            color: var(--text);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .btn-cancel:hover {
            background: var(--bg);
        }

        .btn-submit {
            padding: 10px 24px;
            border: none;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                max-height: 80vh;
            }
        }

        /* ===== SIDEBAR STYLES ===== */
        .app-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: var(--card);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 999;
            box-shadow: 0 4px 16px rgba(11,110,168,0.08);
            transition: all 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .app-sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #1E293B;
            font-weight: 800;
            font-size: 16px;
            flex: 1;
            white-space: nowrap;
        }

        .sidebar-logo img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }

        .app-sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar-toggle-btn {
            display: none;
            width: 36px;
            height: 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg);
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s;
        }

        .sidebar-toggle-btn:hover {
            background: #F1F5F9;
            color: #1E293B;
            border-color: #CBD5E1;
        }

        .sidebar-menu {
            flex: 1;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            overflow-y: auto;
        }

        .menu-section {
            margin-bottom: 8px;
        }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #94A3B8;
            padding: 12px 16px 8px;
            letter-spacing: 0.5px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            text-decoration: none;
            color: #475569;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 14px;
            position: relative;
        }

        .menu-item:hover {
            background: #F1F5F9;
            color: #1E293B;
            transform: translateX(4px);
        }

        .menu-item.active {
            background: #1E293B;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.2);
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .app-sidebar.collapsed .menu-text {
            display: none;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .footer-item {
            padding: 10px 12px;
            border: none;
            border-radius: 8px;
            background: var(--bg);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
        }

        .footer-item:hover {
            background: #F1F5F9;
            color: #1E293B;
        }

        .footer-item.logout {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            color: #fff;
        }

        .footer-item.logout:hover {
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }

        .app-wrapper {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        .app-sidebar.collapsed ~ .app-wrapper {
            margin-left: 80px;
        }

        body.sidebar-collapsed .app-sidebar {
            width: 80px;
        }

        body.sidebar-collapsed .app-wrapper {
            margin-left: 80px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .app-sidebar {
                position: fixed;
                left: 0;
                transform: translateX(-100%);
                z-index: 999;
                width: 280px;
                height: 100vh;
                background: white;
                box-shadow: 2px 0 8px rgba(0,0,0,0.1);
                transition: transform 0.3s ease;
            }

            .app-sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar-toggle-btn {
                display: flex !important;
            }

            .app-wrapper {
                margin-left: 0;
            }

            .main-navbar {
                padding: 12px 16px !important;
            }
        }
    </style>
</head>
<body>
    <!-- SIDEBAR KIRI -->
    <aside class="app-sidebar">
        <div class="sidebar-header">
            <a href="<?= site_url('dashboard'); ?>" class="sidebar-logo">
                <img src="<?= base_url('assets/logo.png'); ?>" alt="Usahain">
                <span class="logo-text">Usahain</span>
            </a>
            <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
        </div>
        
        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="section-title">Dashboard</div>
                <a href="<?= site_url('auth/dashboard_operasional'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-grid-1x2"></i></span>
                    <span class="menu-text">Dashboard Utama</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="section-title">Tools Bisnis</div>
                <a href="<?= site_url('hpp'); ?>" class="menu-item active">
                    <span class="menu-icon"><i class="bi bi-calculator"></i></span>
                    <span class="menu-text">Kalkulator HPP</span>
                </a>
                <a href="<?= site_url('advisor'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-chat-square-text"></i></span>
                    <span class="menu-text">AI Advisor</span>
                </a>
                <a href="<?= site_url('keuangan'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-wallet2"></i></span>
                    <span class="menu-text">Keuangan</span>
                </a>
                <a href="<?= site_url('analisis'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-bar-chart-line"></i></span>
                    <span class="menu-text">Analisis Produk</span>
                </a>
                <a href="<?= site_url('risiko'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-shield-check"></i></span>
                    <span class="menu-text">Manajemen Risiko</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="section-title">Informasi</div>
                <a href="<?= site_url('auth/info_bisnis'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-book"></i></span>
                    <span class="menu-text">Informasi Bisnis</span>
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= site_url('user/profile'); ?>" class="footer-item"><i class="bi bi-person-circle"></i> Profil</a>
            <a href="<?= site_url('auth/logout'); ?>" class="footer-item logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
        </div>
    </aside>

    <div class="app-wrapper">

    <div class="container">

        <!-- Page Header with Hero Design -->
        <div class="page-header">
            <div class="header-content">
                <div>
                    <div class="header-text">
                        <h1>HPP Calculator</h1>
                        <p>Kelola biaya produksi dengan akurat dan analisis margin keuntungan bisnis Anda secara real-time</p>
                    </div>
                    <div class="header-actions">
                        <button type="button" id="addHppBtn" class="btn-header primary" title="Tambah HPP Baru" onclick="openHppModal()">
                            <span>+ Tambah HPP Baru</span>
                        </button>
                        <button class="btn-header secondary" id="exportBtn" type="button" title="Export data ke CSV" onclick="exportTableToCSV()">
                            <span>Export Data</span>
                        </button>
                        <button class="btn-header secondary" id="printBtn" type="button" title="Cetak data (Ctrl+P)" onclick="printTable()">
                            <span><i class="bi bi-printer"></i> Cetak</span>
                        </button>
                        <button class="btn-header secondary" id="recalculateBtn" type="button" title="Hitung ulang semua margin" onclick="recalculateMargins()">
                            <span><i class="bi bi-arrow-clockwise"></i> Hitung Ulang</span>
                        </button>
                    </div>
                </div>
                
                <div class="header-stats">
                    <div class="header-stat">
                        <div class="label">Total Produk</div>
                        <div class="value"><?= isset($hpp_list) ? count($hpp_list) : 0 ?></div>
                    </div>
                    <div class="header-stat">
                        <div class="label">Total Penjualan</div>
                        <div class="value">Rp <?php
                            $total_jual = 0;
                            if (!empty($hpp_list)) {
                                foreach ($hpp_list as $hpp) {
                                    $total_jual += $hpp->harga_jual;
                                }
                            }
                            echo number_format($total_jual / 1000000, 1, ',', '.') . 'M';
                        ?></div>
                    </div>
                    <div class="header-stat">
                        <div class="label">Total Biaya</div>
                        <div class="value">Rp <?php
                            $total_biaya = 0;
                            if (!empty($hpp_list)) {
                                foreach ($hpp_list as $hpp) {
                                    $total_biaya += $hpp->total_biaya;
                                }
                            }
                            echo number_format($total_biaya / 1000000, 1, ',', '.') . 'M';
                        ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-container">
            <div class="table-header">
                <h2>Daftar Lengkap HPP</h2>
                <div class="filter-row">
                    <input type="text" id="searchInput" placeholder="Cari data..." autocomplete="off">
                    <select id="marginFilter">
                        <option value="">Semua Margin</option>
                        <option value="plus">Margin Positif</option>
                        <option value="minus">Margin Negatif</option>
                    </select>
                </div>
            </div>

            <?php if (empty($hpp_list)): ?>
                <div class="empty-state">
                    <p style="font-size: 1.15rem; font-weight: 600; color: var(--text); margin-bottom: 8px;">Belum ada data HPP</p>
                    <p style="margin-bottom: 24px;">Mulai buat perhitungan HPP pertama Anda untuk memantau biaya produksi</p>
                </div>
            <?php else: ?>
                <div class="table-wrapper">
                    <table id="hppTable">
                        <thead>
                            <tr>
                                <th style="width: 40px;">No</th>
                                <th>Biaya Bahan</th>
                                <th>Biaya Tenaga Kerja</th>
                                <th>Total Biaya</th>
                                <th>Harga Jual</th>
                                <th>Margin</th>
                                <th style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($hpp_list as $hpp): ?>
                                <?php $margin = $hpp->harga_jual - $hpp->total_biaya; ?>
                                <tr data-margin="<?= $margin >= 0 ? 'plus' : 'minus' ?>" data-search="<?= strtolower($no . ' ' . $hpp->bahan . ' ' . $hpp->tenaga_kerja . ' ' . $hpp->total_biaya . ' ' . $hpp->harga_jual . ' ' . $margin) ?>">
                                    <td><?= $no++; ?></td>
                                    <td class="currency">Rp <?= number_format($hpp->bahan, 0, ',', '.'); ?></td>
                                    <td class="currency">Rp <?= number_format($hpp->tenaga_kerja, 0, ',', '.'); ?></td>
                                    <td class="currency"><strong>Rp <?= number_format($hpp->total_biaya, 0, ',', '.'); ?></strong></td>
                                    <td class="currency">Rp <?= number_format($hpp->harga_jual, 0, ',', '.'); ?></td>
                                    <td>
                                        <span class="badge <?= $margin > 0 ? 'success' : ($margin < 0 ? 'danger' : 'warning') ?>">
                                            <?= $margin > 0 ? '+' : '' ?>Rp <?= number_format($margin, 0, ',', '.'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?= site_url('hpp/view/'.$hpp->id_hpp); ?>" class="action-btn view" title="Lihat"><i class="bi bi-eye"></i></a>
                                            <a href="<?= site_url('hpp/edit/'.$hpp->id_hpp); ?>" class="action-btn edit" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <a href="<?= site_url('hpp/delete/'.$hpp->id_hpp); ?>" class="action-btn delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash3"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <div class="margin-analysis-container" id="marginAnalysisContainer">
            <?php if (!empty($hpp_list)): ?>
                <?php
                    // Calculate margin statistics
                    $margins = [];
                    $margin_percentages = [];
                    $total_margin_amount = 0;
                    $positive_count = 0;
                    $negative_count = 0;
                    
                    foreach ($hpp_list as $hpp) {
                        $margin = $hpp->harga_jual - $hpp->total_biaya;
                        $margin_percentage = ($hpp->total_biaya > 0) ? (($margin / $hpp->harga_jual) * 100) : 0;
                        
                        $margins[] = $margin;
                        $margin_percentages[] = $margin_percentage;
                        $total_margin_amount += $margin;
                        
                        if ($margin > 0) $positive_count++;
                        if ($margin < 0) $negative_count++;
                    }
                    
                    $avg_margin = count($margins) > 0 ? round(array_sum($margins) / count($margins), 0) : 0;
                    $max_margin = count($margins) > 0 ? max($margins) : 0;
                    $min_margin = count($margins) > 0 ? min($margins) : 0;
                    $avg_margin_percentage = count($margin_percentages) > 0 ? round(array_sum($margin_percentages) / count($margin_percentages), 1) : 0;
                ?>
                
                <!-- Average Margin -->
                <div class="margin-analysis-card <?= $avg_margin > 0 ? 'success' : ($avg_margin < 0 ? 'danger' : 'warning') ?>">
                    <div class="margin-label">
                        <span class="margin-indicator <?= $avg_margin > 0 ? '' : ($avg_margin < 0 ? 'danger' : 'warning') ?>"></span>
                        Margin Rata-Rata
                    </div>
                    <div class="margin-value">Rp <?= number_format($avg_margin, 0, ',', '.') ?></div>
                    <div class="margin-change <?= $avg_margin > 0 ? '' : 'negative' ?>">
                        <i class="bi bi-<?= $avg_margin > 0 ? 'arrow-up' : 'arrow-down' ?>"></i> <?= abs($avg_margin_percentage) ?>%
                    </div>
                </div>
                
                <!-- Maximum Margin -->
                <div class="margin-analysis-card success">
                    <div class="margin-label">
                        <span class="margin-indicator"></span>
                        Margin Tertinggi
                    </div>
                    <div class="margin-value">Rp <?= number_format($max_margin, 0, ',', '.') ?></div>
                    <div class="margin-change">
                        <i class="bi bi-trophy"></i> Produk Terbaik
                    </div>
                </div>
                
                <!-- Minimum Margin -->
                <div class="margin-analysis-card <?= $min_margin < 0 ? 'danger' : 'warning' ?>">
                    <div class="margin-label">
                        <span class="margin-indicator <?= $min_margin < 0 ? 'danger' : 'warning' ?>"></span>
                        Margin Terendah
                    </div>
                    <div class="margin-value">Rp <?= number_format($min_margin, 0, ',', '.') ?></div>
                    <div class="margin-change <?= $min_margin < 0 ? 'negative' : '' ?>">
                        <i class="bi bi-exclamation-triangle"></i> <?= $min_margin < 0 ? 'Rugi' : 'Rendah' ?>
                    </div>
                </div>
                
                <!-- Profitability Stats -->
                <div class="margin-analysis-card success">
                    <div class="margin-label">
                        <span class="margin-indicator"></span>
                        Status Profitabilitas
                    </div>
                    <div class="margin-value" style="font-size: 1.4rem;"><?= $positive_count ?>/<?= count($hpp_list) ?></div>
                    <div class="margin-change">
                        <i class="bi bi-check-circle"></i> <?= $positive_count ?> Untung | <?= $negative_count ?> Rugi
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Charts and Sidebar -->
        <div class="dashboard-grid">
            <!-- Left Column -->
            <div>
                <!-- Profit Chart -->
                <div class="chart-container">
                    <div class="chart-title">Analisis Margin Keuntungan</div>
                    <div class="chart-wrapper">
                        <canvas id="marginChart"></canvas>
                    </div>
                </div>
                <!-- Cost Breakdown -->
                <div class="chart-container">
                    <div class="chart-title">Breakdown Biaya Produksi</div>
                    <div class="chart-wrapper">
                        <canvas id="costChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Right Sidebar -->
            <div class="sidebar">
                <div class="card">
                    <div class="card-title">Panduan Cepat</div>
                    <div style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.8;">
                        <p style="margin-bottom: 12px;"><strong>1. Buat HPP Baru</strong><br/>Klik tombol "+ Tambah HPP Baru" untuk menambahkan data produk dengan biaya bahan dan tenaga kerja.</p>
                        <p style="margin-bottom: 12px;"><strong>2. Analisis Margin</strong><br/>Pantau margin keuntungan dan identifikasi produk yang paling menguntungkan.</p>
                        <p><strong>3. Kelola Data</strong><br/>Edit atau hapus data produk sesuai kebutuhan. Lihat breakdown biaya secara detail.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Form -->
        <div class="modal-overlay" id="hppModal">
            <div class="modal-content modal-large">
                <div class="modal-header">
                    <h2 id="modalTitle">Tambah HPP Baru</h2>
                    <button type="button" class="modal-close" id="closeModalBtn" onclick="closeHppModal()">&times;</button>
                </div>
                <form id="hppForm" method="POST">
                    <!-- Row 1: Nama Produk & Kategori -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Produk <span class="required">*</span></label>
                            <input type="text" name="nama_produk" id="nama_produk" placeholder="Misal: Kemeja Batik" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori <span class="required">*</span></label>
                            <select name="kategori" id="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Garmen">Garmen</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Kerajinan">Kerajinan</option>
                                <option value="Elektronik">Elektronik</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 2: Jumlah Produksi & Satuan -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>Jumlah Produksi <span class="required">*</span></label>
                            <input type="number" name="jumlah_produksi" id="jumlah_produksi" placeholder="Berapa unit?" required min="1">
                        </div>
                        <div class="form-group">
                            <label>Satuan <span class="required">*</span></label>
                            <select name="satuan" id="satuan" required>
                                <option value="">Pilih Satuan</option>
                                <option value="Pcs">Pcs (Piece)</option>
                                <option value="Buah">Buah</option>
                                <option value="Set">Set</option>
                                <option value="Kg">Kg</option>
                                <option value="L">L (Liter)</option>
                                <option value="Box">Box</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 3: Biaya Produksi -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>Biaya Bahan <span class="required">*</span></label>
                            <input type="number" name="bahan" id="bahan" placeholder="Rp 0" required min="0">
                            <small class="form-hint">Total biaya untuk semua bahan baku</small>
                        </div>
                        <div class="form-group">
                            <label>Biaya Tenaga Kerja <span class="required">*</span></label>
                            <input type="number" name="tenaga_kerja" id="tenaga_kerja" placeholder="Rp 0" required min="0">
                            <small class="form-hint">Upah/gaji untuk produksi</small>
                        </div>
                    </div>

                    <!-- Row 4: Biaya Overhead & Harga Jual -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>Biaya Overhead (Opsional)</label>
                            <input type="number" name="overhead" id="overhead" placeholder="Rp 0" min="0" value="0">
                            <small class="form-hint">Listrik, air, sewa, dll</small>
                        </div>
                        <div class="form-group">
                            <label>Harga Jual <span class="required">*</span></label>
                            <input type="number" name="harga_jual" id="harga_jual" placeholder="Rp 0" required min="0">
                            <small class="form-hint">Harga jual per unit/produk</small>
                        </div>
                    </div>

                    <!-- Row 5: Margin Display & Deskripsi -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>Margin Keuntungan (Otomatis)</label>
                            <input type="text" id="marginDisplay" placeholder="Rp 0" readonly>
                            <small class="form-hint">Dihitung otomatis dari harga jual - total biaya</small>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" placeholder="Catatan atau keterangan produk" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeHppModal()">Batal</button>
                        <button type="submit" class="btn-submit"><i class="bi bi-check-lg"></i> Simpan HPP</button>
                    </div>
                </form>
            </div>
        </div>

    <script>
    // Global modal functions
    function openHppModal() {
        const hppModal = document.getElementById('hppModal');
        const hppForm = document.getElementById('hppForm');
        if (hppForm) hppForm.reset();
        const modalTitle = document.getElementById('modalTitle');
        if (modalTitle) modalTitle.textContent = 'Tambah HPP Baru';
        if (hppForm) hppForm.dataset.id = '';
        if (hppModal) hppModal.classList.add('show');
        console.log('Modal opened');
    }

    function closeHppModal() {
        const hppModal = document.getElementById('hppModal');
        if (hppModal) hppModal.classList.remove('show');
        console.log('Modal closed');
    }

    // Show notification
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `update-notification ${type}`;
        notification.innerHTML = `
            <span>${message}</span>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Print table function
    function printTable() {
        const table = document.getElementById('hppTable');
        if (!table) {
            showNotification('Tidak ada data untuk dicetak', 'error');
            return;
        }
        
        const printWindow = window.open('', '', 'width=900,height=600');
        const html = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>HPP Calculator - Laporan Cetak</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    h1 { color: #0b6ea8; text-align: center; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                    th { background-color: #0b6ea8; color: white; font-weight: bold; }
                    tr:nth-child(even) { background-color: #f8fafc; }
                    .currency { text-align: right; }
                    .badge { padding: 4px 8px; border-radius: 4px; }
                    .success { background-color: #D1FAE5; color: #065F46; }
                    .danger { background-color: #FEE2E2; color: #991B1B; }
                    .warning { background-color: #FEF3C7; color: #92400E; }
                    .footer { margin-top: 30px; text-align: center; color: #666; font-size: 12px; }
                </style>
            </head>
            <body>
                <h1>Laporan HPP Calculator</h1>
                <p style="text-align: center; color: #666;">Tanggal Cetak: ${new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                ${table.outerHTML}
                <div class="footer">
                    <p>Dokumen ini dicetak dari Usahain HPP Calculator</p>
                    <p>© ${new Date().getFullYear()} - Semua Hak Dilindungi</p>
                </div>
            </body>
            </html>
        `;
        
        printWindow.document.write(html);
        printWindow.document.close();
        
        printWindow.onload = function() {
            printWindow.print();
        };
        
        showNotification('Siap untuk dicetak');
    }
    
    // Recalculate margins function
    function recalculateMargins() {
        const table = document.getElementById('hppTable');
        if (!table) return;
        
        const rows = table.querySelectorAll('tbody tr');
        if (rows.length === 0) {
            showNotification('Tidak ada data untuk dihitung', 'error');
            return;
        }
        
        let updatedCount = 0;
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 6) {
                const bahan = parseFloat(cells[1].innerText.replace(/\D/g, '') || 0);
                const tk = parseFloat(cells[2].innerText.replace(/\D/g, '') || 0);
                const harga_jual = parseFloat(cells[4].innerText.replace(/\D/g, '') || 0);
                
                const total_biaya = bahan + tk;
                const margin = harga_jual - total_biaya;
                
                // Update cells
                cells[3].innerHTML = '<strong>Rp ' + number_format(total_biaya) + '</strong>';
                
                // Update margin badge
                let badgeClass = 'success';
                let marginText = '+Rp ' + number_format(margin);
                if (margin < 0) {
                    badgeClass = 'danger';
                    marginText = 'Rp ' + number_format(margin);
                } else if (margin === 0) {
                    badgeClass = 'warning';
                    marginText = 'Rp 0';
                }
                
                cells[5].innerHTML = `<span class="badge ${badgeClass}">${marginText}</span>`;
                updatedCount++;
            }
        });
        
        showNotification(`${updatedCount} data berhasil dihitung ulang`);
    }
    
    // Format number function
    function number_format(num) {
        return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    
    // Update margin analysis in real-time
    function updateMarginAnalysis() {
        const table = document.getElementById('hppTable');
        if (!table) return;
        
        const rows = table.querySelectorAll('tbody tr:not(#noResults)');
        if (rows.length === 0) return;
        
        const margins = [];
        const margin_percentages = [];
        let positive_count = 0;
        let negative_count = 0;
        let total_margin = 0;
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 6) {
                const bahan = parseFloat(cells[1].innerText.replace(/\D/g, '') || 0);
                const tk = parseFloat(cells[2].innerText.replace(/\D/g, '') || 0);
                const harga_jual = parseFloat(cells[4].innerText.replace(/\D/g, '') || 0);
                
                const total_biaya = bahan + tk;
                const margin = harga_jual - total_biaya;
                const margin_percentage = (harga_jual > 0) ? ((margin / harga_jual) * 100) : 0;
                
                margins.push(margin);
                margin_percentages.push(margin_percentage);
                total_margin += margin;
                
                if (margin > 0) positive_count++;
                if (margin < 0) negative_count++;
            }
        });
        
        if (margins.length === 0) return;
        
        const avg_margin = Math.round(total_margin / margins.length);
        const max_margin = Math.max(...margins);
        const min_margin = Math.min(...margins);
        const avg_margin_percentage = (margin_percentages.reduce((a, b) => a + b, 0) / margin_percentages.length).toFixed(1);
        
        // Update cards with animation
        const container = document.getElementById('marginAnalysisContainer');
        if (!container) return;
        
        const cards = container.querySelectorAll('.margin-analysis-card');
        if (cards.length > 0) {
            // Update average margin card
            const avgCard = cards[0];
            avgCard.classList.remove('success', 'warning', 'danger');
            avgCard.classList.add(avg_margin > 0 ? 'success' : (avg_margin < 0 ? 'danger' : 'warning'));
            avgCard.querySelector('.margin-value').textContent = 'Rp ' + number_format(avg_margin);
            avgCard.querySelector('.margin-change').innerHTML = '<i class="bi bi-' + (avg_margin > 0 ? 'arrow-up' : 'arrow-down') + '"></i> ' + Math.abs(avg_margin_percentage) + '%';
            avgCard.style.animation = 'none';
            setTimeout(() => avgCard.style.animation = 'slideInUp 0.3s ease', 10);
        }
        if (cards.length > 1) {
            // Update max margin card
            cards[1].querySelector('.margin-value').textContent = 'Rp ' + number_format(max_margin);
        }
        if (cards.length > 2) {
            // Update min margin card
            const minCard = cards[2];
            minCard.classList.remove('danger', 'warning');
            minCard.classList.add(min_margin < 0 ? 'danger' : 'warning');
            minCard.querySelector('.margin-value').textContent = 'Rp ' + number_format(min_margin);
            minCard.querySelector('.margin-change').innerHTML = '<i class="bi bi-exclamation-triangle"></i> ' + (min_margin < 0 ? 'Rugi' : 'Rendah');
        }
        if (cards.length > 3) {
            // Update profitability stats
            cards[3].querySelector('.margin-value').textContent = positive_count + '/' + margins.length;
            cards[3].querySelector('.margin-change').innerHTML = '<i class="bi bi-check-circle"></i> ' + positive_count + ' Untung | ' + negative_count + ' Rugi';
        }
    }
    
    // Margin Chart
    const marginCtx = document.getElementById('marginChart');
    if (marginCtx) {
        const marginLabels = [<?php 
            if (!empty($hpp_list)) { 
                $count = 0; 
                foreach ($hpp_list as $h) { 
                    echo "'Produk " . (++$count) . "'"; 
                    if ($count < count($hpp_list)) echo ", "; 
                } 
            } else { 
                echo "'Tidak Ada Data'"; 
            } 
        ?>];
        
        const marginValues = [<?php 
            if (!empty($hpp_list)) { 
                $values = [];
                foreach ($hpp_list as $h) { 
                    $values[] = ($h->harga_jual - $h->total_biaya);
                }
                echo implode(', ', $values);
            } else { 
                echo "0"; 
            } 
        ?>];
        
        console.log('Margin Labels:', marginLabels);
        console.log('Margin Values:', marginValues);
        
        const marginData = {
            labels: marginLabels,
            datasets: [{
                label: 'Margin Keuntungan',
                data: marginValues,
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        };
        new Chart(marginCtx, {
            type: 'line',
            data: marginData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                            }
                        }
                    }
                }
            }
        });
    }

    // Cost Chart
    const costCtx = document.getElementById('costChart');
    if (costCtx) {
        <?php 
            $total_bahan = 0; 
            $total_tk = 0; 
            $total_margin = 0; 
            if (!empty($hpp_list)) { 
                foreach ($hpp_list as $h) { 
                    $total_bahan += $h->bahan; 
                    $total_tk += $h->tenaga_kerja; 
                    $total_margin += ($h->harga_jual - $h->total_biaya); 
                } 
            } 
        ?>
        const costData = {
            labels: ['Biaya Bahan', 'Biaya Tenaga Kerja', 'Margin'],
            datasets: [{
                data: [<?= $total_bahan ?>, <?= $total_tk ?>, <?= $total_margin ?>],
                backgroundColor: ['#0b6ea8', '#27b0e3', '#10B981']
            }]
        };
        
        console.log('Cost Data:', {bahan: <?= $total_bahan ?>, tk: <?= $total_tk ?>, margin: <?= $total_margin ?>});
        new Chart(costCtx, {
            type: 'doughnut',
            data: costData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Enhanced Filter & Search Function
    function filterTable() {
        var searchInput = document.getElementById('searchInput');
        var marginFilter = document.getElementById('marginFilter');
        var table = document.getElementById('hppTable');
        
        if (!table || !searchInput || !marginFilter) return;
        
        var searchText = searchInput.value.toLowerCase().trim();
        var filterValue = marginFilter.value;
        var tbody = table.getElementsByTagName('tbody')[0];
        
        if (!tbody) return;
        
        var rows = tbody.getElementsByTagName('tr');
        var visibleCount = 0;
        
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var searchAttr = row.getAttribute('data-search') || '';
            var marginAttr = row.getAttribute('data-margin') || '';
            
            // Search filter
            var matchSearch = true;
            if (searchText) {
                matchSearch = searchAttr.toLowerCase().indexOf(searchText) !== -1;
            }
            
            // Margin filter
            var matchMargin = true;
            if (filterValue) {
                matchMargin = marginAttr === filterValue;
            }
            
            // Show or hide row
            if (matchSearch && matchMargin) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
        
        // Show empty message if no results
        var emptyMsg = document.getElementById('noResults');
        if (visibleCount === 0) {
            if (!emptyMsg) {
                emptyMsg = document.createElement('tr');
                emptyMsg.id = 'noResults';
                emptyMsg.innerHTML = '<td colspan="7" style="text-align: center; padding: 40px; color: #999;">Tidak ada data yang sesuai</td>';
                tbody.appendChild(emptyMsg);
            }
            emptyMsg.style.display = '';
        } else if (emptyMsg) {
            emptyMsg.style.display = 'none';
        }
        
        // Update margin analysis after filter
        updateMarginAnalysis();
    }

    // Export Table to CSV
    function exportTableToCSV(filename = 'hpp_calculator.csv') {
        var table = document.getElementById('hppTable');
        if (!table) {
            showNotification('Tidak ada data untuk diekspor', 'error');
            return;
        }
        
        var csv = [];
        var rows = table.querySelectorAll('tr');
        
        rows.forEach(function(row) {
            var cols = row.querySelectorAll('td, th');
            var rowData = [];
            cols.forEach(function(col, index) {
                // Skip action column
                if (index !== cols.length - 1) {
                    rowData.push('"' + col.innerText.trim().replace(/"/g, '""') + '"');
                }
            });
            if (rowData.length > 0) {
                csv.push(rowData.join(','));
            }
        });
        
        var csvContent = csv.join('\n');
        var link = document.createElement('a');
        link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvContent);
        link.download = filename;
        link.click();
        
        showNotification('Data berhasil diekspor ke CSV');
    }

    // Real-time search on input
    document.addEventListener('DOMContentLoaded', function() {
        // Search and filter functionality
        var searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                filterTable();
            });
            searchInput.addEventListener('keyup', function() {
                filterTable();
            });
        }
        
        var marginFilter = document.getElementById('marginFilter');
        if (marginFilter) {
            marginFilter.addEventListener('change', function() {
                filterTable();
            });
        }
        
        const refreshBtn = document.getElementById('refreshBtn');
        if (refreshBtn) {
            refreshBtn.removeAttribute('onclick');
            refreshBtn.addEventListener('click', function(e) {
                e.preventDefault();
                location.reload();
            });
        }
        
        // Animate table rows on load
        var rows = document.querySelectorAll('#hppTable tbody tr');
        rows.forEach(function(row, index) {
            row.style.opacity = '1';
        });
        
        // Initial margin analysis update
        updateMarginAnalysis();
        
        // Update margin analysis every 2 seconds
        setInterval(updateMarginAnalysis, 2000);

        // Modal Management
        const hppModal = document.getElementById('hppModal');
        const addHppBtn = document.getElementById('addHppBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const hppForm = document.getElementById('hppForm');
        const bahanInput = document.getElementById('bahan');
        const tenagaKerjaInput = document.getElementById('tenaga_kerja');
        const overheadInput = document.getElementById('overhead');
        const hargaJualInput = document.getElementById('harga_jual');
        const marginDisplay = document.getElementById('marginDisplay');

        // Update margin display on input
        function updateMarginDisplay() {
            const bahan = parseFloat(bahanInput.value) || 0;
            const tk = parseFloat(tenagaKerjaInput.value) || 0;
            const overhead = parseFloat(overheadInput.value) || 0;
            const jual = parseFloat(hargaJualInput.value) || 0;
            const totalBiaya = bahan + tk + overhead;
            const margin = jual - totalBiaya;
            
            if (marginDisplay) {
                marginDisplay.value = 'Rp ' + number_format(margin);
                // Change color berdasarkan margin
                if (margin > 0) {
                    marginDisplay.style.borderColor = '#10B981';
                    marginDisplay.style.backgroundColor = 'rgba(16, 185, 129, 0.05)';
                } else if (margin < 0) {
                    marginDisplay.style.borderColor = '#ef4444';
                    marginDisplay.style.backgroundColor = 'rgba(239, 68, 68, 0.05)';
                } else {
                    marginDisplay.style.borderColor = 'var(--border)';
                    marginDisplay.style.backgroundColor = 'var(--bg)';
                }
            }
        }

        if (bahanInput) bahanInput.addEventListener('input', updateMarginDisplay);
        if (tenagaKerjaInput) tenagaKerjaInput.addEventListener('input', updateMarginDisplay);
        if (overheadInput) overheadInput.addEventListener('input', updateMarginDisplay);
        if (hargaJualInput) hargaJualInput.addEventListener('input', updateMarginDisplay);

        // Close modal when clicking outside
        hppModal.addEventListener('click', function(e) {
            if (e.target === hppModal) {
                closeHppModal();
            }
        });

        // Form submission
        if (hppForm) {
            hppForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const bahan = bahanInput.value;
                const tenagaKerja = tenagaKerjaInput.value;
                const hargaJual = hargaJualInput.value;
                const id = hppForm.dataset.id || '';

                const formData = new FormData();
                formData.append('bahan', bahan);
                formData.append('tenaga_kerja', tenagaKerja);
                formData.append('harga_jual', hargaJual);

                const url = id ? '<?= site_url("hpp/edit/") ?>' + id : '<?= site_url("hpp/create") ?>';
                const method = id ? 'POST' : 'POST';

                fetch(url, {
                    method: method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    // Parse JSON response
                    return response.json().then(data => ({
                        status: response.status,
                        ok: response.ok,
                        data: data
                    }));
                })
                .then(({ status, ok, data }) => {
                    console.log('Response:', { status, ok, data });
                    
                    if (ok && data.status === 'success') {
                        showNotification(data.message || (id ? 'Data berhasil diupdate!' : 'Data HPP berhasil ditambahkan!'), 'success');
                        closeHppModal();
                        // Reload page to update table and charts
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        const errorMsg = data.message || (id ? 'Gagal mengupdate data' : 'Gagal menyimpan data');
                        showNotification(errorMsg, 'error');
                        console.error('Error response:', data);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    showNotification('Gagal menyimpan data. Periksa koneksi Anda.', 'error');
                });
            });
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + E = Export
            if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                e.preventDefault();
                exportTableToCSV();
            }
            // Ctrl/Cmd + F = Focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                if (searchInput) searchInput.focus();
            }
            // Ctrl/Cmd + P = Print
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                printTable();
            }
            // Ctrl/Cmd + R = Recalculate
            if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                e.preventDefault();
                recalculateMargins();
            }
        });
    });
    </script>
    </div><!-- app-wrapper -->
</body>
</html>

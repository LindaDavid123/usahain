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
    <script src="https://unpkg.com/lucide@latest"></script>
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
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(180deg, #F8FBFD 0%, #F7FAFC 100%);
            color: var(--text); 
            min-height: 100vh;
            position: relative;
            line-height: 1.5;
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
            max-width: 1180px;
            margin: 28px auto;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }
        
        /* Header/Hero Section */
        .page-header {
            margin-bottom: 32px;
            background: #1c6494;
            border-radius: 20px;
            padding: 28px 32px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(11,110,168,0.25);
        }

        .page-header::before {
            content: none;
        }
        .page-header::after {
            content: none;
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
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 0;
            color: #ffffff;
        }
        .header-text p {
            font-size: 12px;
            color: rgba(255,255,255,0.75);
            margin: 0;
            line-height: 1.5;
            max-width: 520px;
            font-weight: 400;
        }
        .header-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-top: 24px;
        }
        .header-stat {
            background: rgba(255,255,255,0.14);
            backdrop-filter: blur(25px);
            border-radius: 16px;
            padding: 20px 24px;
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
            font-size: 10px;
            color: rgba(255,255,255,0.85);
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
            font-family: 'Inter', sans-serif;
        }
        .header-stat .value {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            line-height: 1.1;
            position: relative;
            z-index: 1;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0;
        }
        .header-actions {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: nowrap;
            align-items: center;
            overflow-x: auto;
        }
        .btn-header {
            padding: 9px 18px;
            border-radius: 8px;
            font-weight: 800;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
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
            min-height: 36px;
            pointer-events: auto;
            z-index: 10;
        }
        .btn-header i {
            font-size: 14px;
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
            background: #ffffff;
            color: #1c6494;
            font-weight: 600;
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            box-shadow: none;
        }
        .btn-header.primary:active {
            
        }
        .btn-header.secondary {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.4);
            font-weight: 500;
            padding: 9px 18px;
            border-radius: 8px;
            box-shadow: none;
        }
        .btn-header.secondary:active {
            
        }
        #recalculateBtn {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.4);
            color: #fff;
            font-weight: 500;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
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

        .chart-empty-state {
            display: none;
            position: absolute;
            inset: 0;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            background: #f8fafc;
            border: 1px dashed var(--border);
            border-radius: 10px;
            padding: 16px;
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
            font-size: 13px;
        }
        thead { 
            background: #1c6494;
        }
        th { 
            padding: 10px 12px; 
            color: #fff; 
            font-size: 12px;
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
            padding: 10px 12px; 
            color: #111827; 
            font-size: 13px;
            border: none;
        }
        td:first-child { 
            font-weight: 700; 
            color: var(--primary);
        }
        .currency { 
            text-align: right; 
            font-weight: 700; 
            color: #111827;
            font-family: 'Inter', sans-serif;
        }
        #hppTable tbody td.currency,
        #hppTable tbody td.currency strong {
            color: #111827;
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
            padding: 0;
            width: 28px;
            height: 28px;
            border-radius: 6px; 
            background: #1c6494;
            color: #fff; 
            border: none; 
            cursor: pointer; 
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            min-width: 28px;
            justify-content: center;
        }
        .action-btn i {
            font-size: 13px;
        }
        .action-btn:hover { 
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(28,100,148,0.25);
        }
        .action-btn.view {
            background: #1c6494;
        }
        .action-btn.view:hover {
            box-shadow: 0 6px 16px rgba(28,100,148,0.25);
        }
        .action-btn.edit { 
            background: #f59e0b;
        }
        .action-btn.edit:hover {
            box-shadow: 0 6px 16px rgba(245,158,11,0.25);
        }
        .action-btn.delete { 
            background: #ef4444;
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
            content: none;
        }
        .margin-analysis-card.warning::before {
            content: none;
        }
        .margin-analysis-card.danger::before {
            content: none;
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
            font-size: 18px;
            font-weight: 700;
            color: #1c6494;
            margin-bottom: 12px;
            font-family: 'Inter', sans-serif;
        }
        .margin-analysis-card.success .margin-value {
            color: #1c6494;
        }
        .margin-analysis-card.warning .margin-value {
            color: #1c6494;
        }
        .margin-analysis-card.danger .margin-value {
            color: #1c6494;
        }
        .margin-analysis-card.profit-positive .margin-value {
            color: #16a34a;
        }
        .margin-analysis-card.profit-negative .margin-value {
            color: #ef4444;
        }
        .margin-analysis-card.profit-neutral .margin-value {
            color: #1c6494;
        }
        .margin-min-card .margin-value {
            color: #ef4444;
        }
        .margin-min-card .margin-indicator {
            background: #ef4444;
        }
        .margin-change {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0;
            border-radius: 0;
            display: inline;
            background: none;
            border: 0;
            color: #1c6494;
        }
        .margin-change i[data-lucide] {
            width: 12px;
            height: 12px;
            stroke-width: 2;
            vertical-align: -2px;
            margin-right: 4px;
        }
        .margin-change.negative {
            background: none;
            border: 0;
            color: var(--danger);
        }
        .margin-change.low {
            background: none;
            color: #ef4444;
            border: 0;
        }
        .margin-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #1c6494;
            margin-right: 6px;
        }
        .margin-indicator.warning {
            background: var(--warning);
        }
        .margin-indicator.danger {
            background: var(--danger);
        }
        .margin-analysis-card.profit-positive .margin-indicator {
            background: #16a34a;
        }
        .margin-analysis-card.profit-negative .margin-indicator {
            background: #ef4444;
        }
        .margin-analysis-card.profit-neutral .margin-indicator {
            background: #1c6494;
        }

        .analysis-section-divider {
            margin: 30px 0 18px;
            padding-top: 18px;
            border-top: 1px solid #dbe7f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .analysis-section-divider h2 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1c6494;
            margin: 0;
        }

        .analysis-panel {
            background: linear-gradient(135deg, var(--card) 0%, #f8fafb 100%);
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 18px;
        }

        .analysis-panel-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 12px;
        }

        .analysis-table-wrap {
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 10px;
        }

        .analysis-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .analysis-table th,
        .analysis-table td {
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            white-space: nowrap;
        }

        .analysis-table th {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            background: #f8fafc;
        }

        .analysis-table tbody tr:last-child td {
            border-bottom: none;
        }

        .analysis-money {
            font-weight: 600;
        }

        .analysis-money.positive {
            color: #166534;
        }

        .analysis-money.negative {
            color: #991b1b;
        }

        .analysis-status {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 3px 9px;
            font-size: 11px;
            font-weight: 600;
        }

        .analysis-status.good {
            background: rgba(22, 163, 74, 0.12);
            color: #166534;
        }

        .analysis-status.bad {
            background: rgba(220, 38, 38, 0.12);
            color: #991b1b;
        }

        .analysis-trend {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 999px;
            padding: 3px 9px;
            font-size: 11px;
            font-weight: 600;
        }

        .analysis-trend.up {
            background: rgba(22, 163, 74, 0.12);
            color: #166534;
        }

        .analysis-trend.down {
            background: rgba(220, 38, 38, 0.12);
            color: #991b1b;
        }

        .analysis-trend.stable {
            background: rgba(107, 114, 128, 0.14);
            color: #374151;
        }

        .analysis-trend i,
        .analysis-trend svg {
            width: 12px;
            height: 12px;
        }

        .analysis-source-badge {
            display: inline;
            font-size: 11px;
            font-weight: 500;
            color: #9ca3af;
        }

        .analysis-chart-wrap {
            position: relative;
            height: 240px;
        }

        .analysis-chart-empty {
            display: none;
            position: absolute;
            inset: 0;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            background: #f8fafc;
            border: 1px dashed var(--border);
            border-radius: 10px;
            padding: 16px;
        }

        .analysis-recommend-list {
            display: grid;
            gap: 12px;
        }

        .analysis-recommend-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .analysis-recommend-icon,
        .analysis-recommend-icon i,
        .analysis-recommend-icon svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            margin-top: 3px;
        }

        .analysis-recommend-icon.positive {
            color: #16a34a;
        }

        .analysis-recommend-icon.warning {
            color: #ef4444;
        }

        .analysis-recommend-text {
            font-size: 13px;
            color: #374151;
            line-height: 1.6;
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
            .page-header { padding: 28px 24px; }
            .table-header { flex-direction: column; align-items: flex-start; }
            .filter-row { width: 100%; }
            .filter-row input, .filter-row select { width: 100%; }
            table { font-size: 13px; }
            td, th { padding: 10px 12px; }
            .action-btn { padding: 6px 10px; }
        }
        @media (max-width: 480px) {
            .summary-cards { grid-template-columns: 1fr; }
            .header-actions { flex-wrap: nowrap; }
            .btn-header { justify-content: center; }
            .page-header { padding: 24px 16px; }
            .container { padding: 0 16px; margin: 20px auto; }
            th { padding: 10px 12px; font-size: 12px; }
            td { padding: 10px 12px; }
            .action-buttons { gap: 4px; }
            .action-btn { padding: 6px 10px; min-width: 32px; }
            .table-header { flex-direction: column; gap: 12px; }
            .filter-row { width: 100%; flex-direction: column; }
            .filter-row input, .filter-row select { width: 100%; }
            .card, .chart-container, .table-container { padding: 20px; }
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
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
            font-size: 13px;
        }

        .required {
            color: #dc2626;
            font-weight: bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 9px 12px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            color: #111827;
            background: white;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            font-size: 13px;
            color: #9ca3af;
            opacity: 1;
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
            max-width: 480px;
            width: 90%;
        }

        #hppModal .modal-large {
            max-width: 420px;
        }

        .modal-footer {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 18px;
            border-top: 1px solid var(--border);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            padding: 24px;
        }

        .detail-item {
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
        }

        .detail-label {
            font-size: 11px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .detail-value {
            font-size: 14px;
            color: var(--text);
            font-weight: 600;
            word-break: break-word;
        }

        .detail-item.full {
            grid-column: 1 / -1;
        }

        .btn-cancel {
            padding: 9px 16px;
            border: 2px solid var(--border);
            background: white;
            color: var(--text);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
        }

        .btn-cancel:hover {
            background: var(--bg);
        }

        .btn-submit {
            padding: 9px 16px;
            border: none;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
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

        /* ===== SIDEBAR STYLES (Dashboard Main) ===== */
        .app-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: #fff;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 999;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
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
            justify-content: flex-start;
            gap: 12px;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #1f6b99;
            font-weight: 800;
            font-size: 16px;
            white-space: nowrap;
            min-width: 40px;
            flex: 1;
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
            width: 36px;
            height: 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            display: none;
            align-items: center;
            justify-content: center;
            background: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s;
        }

        .sidebar-toggle-btn:hover {
            background: var(--bg);
            color: #1f6b99;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
            list-style: none;
            margin: 0;
        }

        .sidebar-menu-item {
            margin-bottom: 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 0;
            padding: 12px 16px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-secondary);
            transition: all 0.3s;
            font-weight: 500;
            font-size: 14px;
            position: relative;
        }

        .menu-item:hover {
            background: var(--bg);
            color: #1f6b99;
            transform: translateX(4px);
        }

        .menu-item.active {
            background: linear-gradient(135deg, #1f6b99 0%, #3a88ba 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(31,107,153,0.25);
        }

        .menu-icon {
            display: none;
        }

        .menu-text {
            display: inline-flex;
            align-items: center;
        }

        .menu-badge {
            margin-left: auto;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            background: rgba(31,107,153,0.1);
            color: #1f6b99;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .menu-item.active .menu-badge {
            background: #1c6494;
            color: #fff;
        }

        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        body.sidebar-collapsed .app-sidebar {
            width: 80px;
        }

        body.sidebar-collapsed .main-wrapper {
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
                background: #fff;
                box-shadow: 2px 0 8px rgba(0,0,0,0.1);
                transition: transform 0.3s ease;
            }

            .app-sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar-toggle-btn {
                display: flex !important;
            }

            .main-wrapper {
                margin-left: 0;
            }

            body.sidebar-collapsed .main-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- SIDEBAR KIRI -->
    <aside class="app-sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?= site_url('auth/dashboard'); ?>" class="sidebar-logo">
                <img src="<?= base_url('assets/logo.png'); ?>" alt="Usahain">
                <span class="logo-text">Usahain</span>
            </a>
            <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
        </div>
        
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="<?= site_url('auth/dashboard'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-grid-1x2"></i></span>
                    <span class="menu-text">Dashboard</span>
                    <span class="menu-badge">Home</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="<?= site_url('advisor'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-chat-square-text"></i></span>
                    <span class="menu-text">AI Advisor</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="<?= site_url('hpp'); ?>" class="menu-item active">
                    <span class="menu-icon"><i class="bi bi-calculator"></i></span>
                    <span class="menu-text">Kalkulator HPP</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="<?= site_url('keuangan'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-wallet2"></i></span>
                    <span class="menu-text">Pencatatan Keuangan</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="<?= site_url('risiko'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-shield-check"></i></span>
                    <span class="menu-text">Manajemen Risiko</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="<?= site_url('auth/info_bisnis'); ?>" class="menu-item">
                    <span class="menu-icon"><i class="bi bi-book"></i></span>
                    <span class="menu-text">Informasi Bisnis</span>
                </a>
            </li>
        </ul>
    </aside>

    <div class="main-wrapper">

    <div class="container">

        <!-- Page Header with Hero Design -->
        <div class="page-header">
            <div class="header-content">
                <div>
                    <div class="header-text">
                        <h1>HPP Calculator</h1>
                        <p>Kelola dan analisis biaya produksi bisnis Anda</p>
                    </div>
                    <div class="header-actions">
                        <button type="button" id="addHppBtn" class="btn-header primary" title="Tambah HPP" onclick="openHppModal()">
                            <span>Tambah HPP</span>
                        </button>
                        <button class="btn-header secondary" id="recalculateBtn" type="button" title="Hitung ulang semua margin" onclick="recalculateMargins()">
                            <span>Hitung Ulang</span>
                        </button>
                        <button class="btn-header secondary" id="printBtn" type="button" title="Cetak data (Ctrl+P)" onclick="printTable()">
                            <span>Cetak</span>
                        </button>
                    </div>
                </div>
                
                <div class="header-stats">
                    <div class="header-stat">
                        <div class="label">Total Produk</div>
                        <div class="value" id="totalProdukValue"><?= isset($hpp_list) ? count($hpp_list) : 0 ?></div>
                    </div>
                    <div class="header-stat">
                        <div class="label">Total Penjualan</div>
                        <div class="value" id="totalPenjualanValue">Rp <?php
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
                        <div class="value" id="totalBiayaValue">Rp <?php
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
                        <option value="tinggi">Margin Tinggi</option>
                        <option value="rendah">Margin Rendah</option>
                    </select>
                </div>
            </div>

            <div class="table-wrapper">
                <table id="hppTable">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Total Biaya Produksi</th>
                            <th>Harga Jual</th>
                            <th>Margin</th>
                            <th style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="hppTableBody">
                        <?php if (empty($hpp_list)): ?>
                            <tr id="noResults">
                                <td colspan="7" style="text-align: center; padding: 32px; color: #6b7280;">Belum ada data HPP</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($hpp_list as $hpp): ?>
                                <?php
                                    $margin = (float) $hpp->harga_jual - (float) $hpp->total_biaya;
                                    $namaProduk = trim((string) ($hpp->nama_produk ?? '')) !== '' ? $hpp->nama_produk : ('Produk #' . $hpp->id_hpp);
                                    $kategori = trim((string) ($hpp->kategori ?? '')) !== '' ? $hpp->kategori : 'Lainnya';
                                    $marginBucket = $margin >= 0 ? 'tinggi' : 'rendah';
                                ?>
                                <tr data-id="<?= (int) $hpp->id_hpp ?>" data-margin="<?= $marginBucket ?>" data-search="<?= strtolower($namaProduk . ' ' . $kategori . ' ' . $hpp->total_biaya . ' ' . $hpp->harga_jual . ' ' . $margin) ?>">
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($namaProduk) ?></td>
                                    <td><?= htmlspecialchars($kategori) ?></td>
                                    <td class="currency"><strong>Rp <?= number_format((float) $hpp->total_biaya, 0, ',', '.'); ?></strong></td>
                                    <td class="currency">Rp <?= number_format((float) $hpp->harga_jual, 0, ',', '.'); ?></td>
                                    <td>
                                        <span class="badge <?= $margin > 0 ? 'success' : ($margin < 0 ? 'danger' : 'warning') ?>">
                                            <?= $margin > 0 ? '+' : '' ?>Rp <?= number_format($margin, 0, ',', '.'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="action-btn view" data-action="view" data-id="<?= (int) $hpp->id_hpp ?>" title="Lihat"><i class="bi bi-eye"></i></button>
                                            <button type="button" class="action-btn edit" data-action="edit" data-id="<?= (int) $hpp->id_hpp ?>" title="Edit"><i class="bi bi-pencil"></i></button>
                                            <button type="button" class="action-btn delete" data-action="delete" data-id="<?= (int) $hpp->id_hpp ?>" title="Hapus"><i class="bi bi-trash3"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="margin-analysis-container" id="marginAnalysisContainer">
            <div class="margin-analysis-card success" id="avgMarginCard">
                <div class="margin-label">
                    <span class="margin-indicator"></span>
                    Margin Rata-Rata
                </div>
                <div class="margin-value" id="avgMarginValue">Rp 0</div>
                <div class="margin-change" id="avgMarginChange"><i data-lucide="trending-up"></i> 0%</div>
            </div>

            <div class="margin-analysis-card success" id="maxMarginCard">
                <div class="margin-label">
                    <span class="margin-indicator"></span>
                    Margin Tertinggi
                </div>
                <div class="margin-value" id="maxMarginValue">Rp 0</div>
                <div class="margin-change">Produk Terbaik</div>
            </div>

            <div class="margin-analysis-card margin-min-card warning" id="minMarginCard">
                <div class="margin-label">
                    <span class="margin-indicator"></span>
                    Margin Terendah
                </div>
                <div class="margin-value" id="minMarginValue">Rp 0</div>
                <div class="margin-change low" id="minMarginChange">Rendah</div>
            </div>

            <div class="margin-analysis-card success profit-neutral" id="profitStatusCard">
                <div class="margin-label">
                    <span class="margin-indicator"></span>
                    Status Profitabilitas
                </div>
                <div class="margin-value" id="profitStatusValue">0/0</div>
                <div class="margin-change" id="profitStatusChange"><i data-lucide="check-circle"></i> 0 Untung | 0 Rugi</div>
            </div>
        </div>

        <div class="analysis-section-divider" id="analisis-produk">
            <h2>Analisis Produk</h2>
        </div>

        <section class="analysis-panel">
            <h3 class="analysis-panel-title">Perbandingan Performa Antar Produk</h3>
            <div class="analysis-table-wrap">
                <table class="analysis-table">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Sumber Data</th>
                            <th>Total Penjualan</th>
                            <th>Biaya Produksi</th>
                            <th>Margin</th>
                            <th>Status</th>
                            <th>Tren</th>
                        </tr>
                    </thead>
                    <tbody id="analysisComparisonBody">
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: #6b7280;">Belum ada data analisis produk</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="analysis-panel">
            <h3 class="analysis-panel-title">Grafik Perbandingan Penjualan Antar Produk</h3>
            <div class="analysis-chart-wrap">
                <canvas id="analysisProdukChart"></canvas>
                <div class="analysis-chart-empty" id="analysisChartEmpty">Belum ada data analisis produk</div>
            </div>
        </section>

        <section class="analysis-panel">
            <h3 class="analysis-panel-title">Rekomendasi Otomatis</h3>
            <div class="analysis-recommend-list" id="analysisRecommendationList">
                <div class="analysis-recommend-item">
                    <i data-lucide="info" class="analysis-recommend-icon"></i>
                    <div class="analysis-recommend-text">Rekomendasi otomatis akan muncul setelah tersedia data produk.</div>
                </div>
            </div>
        </section>

        <!-- Charts and Sidebar -->
        <div class="dashboard-grid">
            <!-- Left Column -->
            <div>
                <!-- Profit Chart -->
                <div class="chart-container">
                    <div class="chart-title">Analisis Margin Keuntungan</div>
                    <div class="chart-wrapper">
                        <canvas id="marginChart"></canvas>
                        <div class="chart-empty-state" id="marginChartEmpty">Belum ada data HPP</div>
                    </div>
                </div>
                <!-- Cost Breakdown -->
                <div class="chart-container">
                    <div class="chart-title">Breakdown Biaya Produksi</div>
                    <div class="chart-wrapper">
                        <canvas id="costChart"></canvas>
                        <div class="chart-empty-state" id="costChartEmpty">Belum ada data HPP</div>
                    </div>
                </div>
            </div>
            
            <!-- Right Sidebar -->
            <div class="sidebar">
                <div class="card">
                    <div class="card-title">Panduan Cepat</div>
                    <div style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.8;">
                        <p style="margin-bottom: 12px;"><strong>1. Buat HPP Baru</strong><br/>Klik tombol "Tambah HPP" untuk menambahkan data produk, total biaya produksi, dan harga jual.</p>
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
                    <h2 id="modalTitle">Tambah HPP</h2>
                    <button type="button" class="modal-close" id="closeModalBtn" onclick="closeHppModal()">&times;</button>
                </div>
                <form id="hppForm" method="POST">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" placeholder="Contoh: Kemeja Batik Premium" required>
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" id="kategori" required>
                            <option value="">Pilih kategori produk</option>
                            <option value="Garmen">Garmen</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Kerajinan">Kerajinan</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Total Biaya Produksi</label>
                        <input type="number" name="total_biaya_produksi" id="total_biaya_produksi" placeholder="Masukkan total biaya produksi (Rp)" required min="0">
                    </div>

                    <div class="form-group">
                        <label>Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual" placeholder="Masukkan harga jual (Rp)" required min="0">
                    </div>

                    <div class="form-group">
                        <label>Jumlah Produksi</label>
                        <input type="number" name="jumlah_produksi" id="jumlah_produksi" placeholder="Masukkan jumlah unit produksi" required min="1">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeHppModal()">Batal</button>
                        <button type="submit" class="btn-submit">Simpan HPP</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal-overlay" id="hppDetailModal">
            <div class="modal-content modal-large">
                <div class="modal-header">
                    <h2>Detail Produk HPP</h2>
                    <button type="button" class="modal-close" onclick="closeDetailModal()">&times;</button>
                </div>
                <div class="detail-grid">
                    <div class="detail-item full">
                        <div class="detail-label">Nama Produk</div>
                        <div class="detail-value" id="detailNamaProduk">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Kategori</div>
                        <div class="detail-value" id="detailKategori">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Jumlah Produksi</div>
                        <div class="detail-value" id="detailJumlahProduksi">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Total Biaya Produksi</div>
                        <div class="detail-value" id="detailTotalBiaya">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Harga Jual</div>
                        <div class="detail-value" id="detailHargaJual">-</div>
                    </div>
                    <div class="detail-item full">
                        <div class="detail-label">Margin Otomatis</div>
                        <div class="detail-value" id="detailMargin">-</div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 0 24px 24px; border-top: none;">
                    <button type="button" class="btn-cancel" onclick="closeDetailModal()">Tutup</button>
                </div>
            </div>
        </div>

    <script>
    const HPP_ENDPOINTS = {
        list: '<?= site_url("hpp/list_json") ?>',
        create: '<?= site_url("hpp/create") ?>',
        editBase: '<?= site_url("hpp/edit/") ?>',
        deleteBase: '<?= site_url("hpp/delete/") ?>',
        detailBase: '<?= site_url("hpp/detail_json/") ?>',
        recalculate: '<?= site_url("hpp/recalculate") ?>'
    };

    const hppState = {
        items: [],
        marginChart: null,
        costChart: null,
        analysisChart: null,
        payload: null
    };

    function number_format(num) {
        return Math.round(Number(num || 0)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function formatRupiah(num) {
        return 'Rp ' + number_format(num);
    }

    function formatCompactRupiah(num) {
        const value = Number(num || 0);
        if (Math.abs(value) >= 1000000) {
            return 'Rp ' + (value / 1000000).toLocaleString('id-ID', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            }) + 'M';
        }
        return formatRupiah(value);
    }

    function formatRupiahShort(value) {
        const num = Number(value || 0);
        const abs = Math.abs(num);

        if (abs >= 1000000000) {
            return 'Rp ' + (num / 1000000000).toFixed(abs >= 10000000000 ? 0 : 1).replace('.0', '') + 'M';
        }

        if (abs >= 1000000) {
            return 'Rp ' + (num / 1000000).toFixed(abs >= 10000000 ? 0 : 1).replace('.0', '') + 'jt';
        }

        if (abs >= 1000) {
            return 'Rp ' + (num / 1000).toFixed(abs >= 10000 ? 0 : 1).replace('.0', '') + 'rb';
        }

        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `update-notification ${type}`;
        notification.innerHTML = `<span>${escapeHtml(message)}</span>`;
        document.body.appendChild(notification);

        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    async function requestJson(url, options = {}) {
        const config = {
            method: options.method || 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                ...(options.headers || {})
            }
        };

        if (options.body) {
            config.body = options.body;
        }

        const response = await fetch(url, config);
        const data = await response.json().catch(() => ({
            status: 'error',
            message: 'Respon server tidak valid.'
        }));

        if (!response.ok || data.status === 'error') {
            throw new Error(data.message || 'Terjadi kesalahan pada server.');
        }

        return data;
    }

    function openHppModal(item = null) {
        const hppModal = document.getElementById('hppModal');
        const hppForm = document.getElementById('hppForm');
        const modalTitle = document.getElementById('modalTitle');

        if (!hppModal || !hppForm) return;

        hppForm.reset();
        hppForm.dataset.id = item ? String(item.id_hpp) : '';

        if (item) {
            if (modalTitle) modalTitle.textContent = 'Edit HPP';
            hppForm.nama_produk.value = item.nama_produk || '';
            hppForm.kategori.value = item.kategori || '';
            hppForm.total_biaya_produksi.value = item.total_biaya || 0;
            hppForm.harga_jual.value = item.harga_jual || 0;
            hppForm.jumlah_produksi.value = item.jumlah_produksi || 1;
        } else if (modalTitle) {
            modalTitle.textContent = 'Tambah HPP';
        }

        hppModal.classList.add('show');
    }

    function closeHppModal() {
        const hppModal = document.getElementById('hppModal');
        if (hppModal) hppModal.classList.remove('show');
    }

    function closeDetailModal() {
        const modal = document.getElementById('hppDetailModal');
        if (modal) modal.classList.remove('show');
    }

    function openDetailModal(item) {
        if (!item) return;
        const modal = document.getElementById('hppDetailModal');
        if (!modal) return;

        document.getElementById('detailNamaProduk').textContent = item.nama_produk || '-';
        document.getElementById('detailKategori').textContent = item.kategori || '-';
        document.getElementById('detailJumlahProduksi').textContent = (item.jumlah_produksi || 1) + ' unit';
        document.getElementById('detailTotalBiaya').textContent = formatRupiah(item.total_biaya || 0);
        document.getElementById('detailHargaJual').textContent = formatRupiah(item.harga_jual || 0);
        document.getElementById('detailMargin').textContent = formatRupiah(item.margin || 0);

        modal.classList.add('show');
    }

    function renderHeaderStats(stats) {
        document.getElementById('totalProdukValue').textContent = stats.total_produk || 0;
        document.getElementById('totalPenjualanValue').textContent = formatCompactRupiah(stats.total_penjualan || 0);
        document.getElementById('totalBiayaValue').textContent = formatCompactRupiah(stats.total_biaya || 0);
    }

    function getMarginBadgeClass(margin) {
        if (margin > 0) return 'success';
        if (margin < 0) return 'danger';
        return 'warning';
    }

    function renderTable(items) {
        const tbody = document.getElementById('hppTableBody');
        if (!tbody) return;

        if (!items.length) {
            tbody.innerHTML = '<tr id="noResults"><td colspan="7" style="text-align: center; padding: 32px; color: #6b7280;">Belum ada data HPP</td></tr>';
            return;
        }

        tbody.innerHTML = items.map((item, index) => {
            const marginClass = getMarginBadgeClass(item.margin);
            const marginLabel = `${item.margin > 0 ? '+' : ''}Rp ${number_format(item.margin)}`;
            const searchBlob = `${item.nama_produk || ''} ${item.kategori || ''} ${item.total_biaya || ''} ${item.harga_jual || ''} ${item.margin || ''}`.toLowerCase();

            return `
                <tr data-id="${item.id_hpp}" data-margin="${item.margin_bucket || (item.margin >= 0 ? 'tinggi' : 'rendah')}" data-search="${escapeHtml(searchBlob)}">
                    <td>${index + 1}</td>
                    <td>${escapeHtml(item.nama_produk || '-')}</td>
                    <td>${escapeHtml(item.kategori || '-')}</td>
                    <td class="currency"><strong>Rp ${number_format(item.total_biaya)}</strong></td>
                    <td class="currency">Rp ${number_format(item.harga_jual)}</td>
                    <td><span class="badge ${marginClass}">${marginLabel}</span></td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" class="action-btn view" data-action="view" data-id="${item.id_hpp}" title="Lihat"><i class="bi bi-eye"></i></button>
                            <button type="button" class="action-btn edit" data-action="edit" data-id="${item.id_hpp}" title="Edit"><i class="bi bi-pencil"></i></button>
                            <button type="button" class="action-btn delete" data-action="delete" data-id="${item.id_hpp}" title="Hapus"><i class="bi bi-trash3"></i></button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function renderMarginCards(cards) {
        const avgCard = document.getElementById('avgMarginCard');
        const maxCard = document.getElementById('maxMarginCard');
        const minCard = document.getElementById('minMarginCard');
        const statusCard = document.getElementById('profitStatusCard');

        document.getElementById('avgMarginValue').textContent = formatRupiah(cards.avg_margin || 0);
        document.getElementById('avgMarginChange').innerHTML = `<i data-lucide="trending-up"></i> ${Math.abs(cards.avg_margin_percentage || 0)}%`;
        document.getElementById('maxMarginValue').textContent = formatRupiah(cards.max_margin || 0);
        document.getElementById('minMarginValue').textContent = formatRupiah(cards.min_margin || 0);
        document.getElementById('minMarginChange').textContent = (cards.min_margin || 0) < 0 ? 'Rugi' : 'Rendah';
        document.getElementById('profitStatusValue').textContent = `${cards.positive_count || 0}/${cards.total_count || 0}`;
        document.getElementById('profitStatusChange').innerHTML = `<i data-lucide="check-circle"></i> ${cards.positive_count || 0} Untung | ${cards.negative_count || 0} Rugi`;

        avgCard.classList.remove('success', 'warning', 'danger');
        if ((cards.avg_margin || 0) > 0) avgCard.classList.add('success');
        else if ((cards.avg_margin || 0) < 0) avgCard.classList.add('danger');
        else avgCard.classList.add('warning');

        maxCard.classList.remove('success', 'warning', 'danger');
        maxCard.classList.add((cards.max_margin || 0) > 0 ? 'success' : 'warning');

        minCard.classList.remove('success', 'warning', 'danger');
        minCard.classList.add((cards.min_margin || 0) < 0 ? 'danger' : 'warning');

        statusCard.classList.remove('profit-positive', 'profit-negative', 'profit-neutral');
        if ((cards.negative_count || 0) > 0) statusCard.classList.add('profit-negative');
        else if ((cards.positive_count || 0) > 0) statusCard.classList.add('profit-positive');
        else statusCard.classList.add('profit-neutral');
    }

    function toggleChartEmpty(canvasId, emptyId, shouldShow) {
        const canvas = document.getElementById(canvasId);
        const empty = document.getElementById(emptyId);
        if (!canvas || !empty) return;

        if (shouldShow) {
            canvas.style.display = 'none';
            empty.style.display = 'flex';
        } else {
            canvas.style.display = 'block';
            empty.style.display = 'none';
        }
    }

    function renderMarginChart(items) {
        const canvas = document.getElementById('marginChart');
        if (!canvas) return;

        if (!items.length) {
            if (hppState.marginChart) {
                hppState.marginChart.destroy();
                hppState.marginChart = null;
            }
            toggleChartEmpty('marginChart', 'marginChartEmpty', true);
            return;
        }

        toggleChartEmpty('marginChart', 'marginChartEmpty', false);

        const data = {
            labels: items.map(item => item.nama_produk),
            datasets: [{
                label: 'Margin Keuntungan',
                data: items.map(item => item.margin),
                borderColor: '#16a34a',
                backgroundColor: 'rgba(22, 163, 74, 0.12)',
                borderWidth: 3,
                fill: true,
                tension: 0.35
            }]
        };

        if (!hppState.marginChart) {
            hppState.marginChart = new Chart(canvas, {
                type: 'line',
                data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => 'Rp ' + number_format(value)
                            }
                        }
                    }
                }
            });
            return;
        }

        hppState.marginChart.data = data;
        hppState.marginChart.update();
    }

    function renderCostChart(costData, hasData) {
        const canvas = document.getElementById('costChart');
        if (!canvas) return;

        if (!hasData) {
            if (hppState.costChart) {
                hppState.costChart.destroy();
                hppState.costChart = null;
            }
            toggleChartEmpty('costChart', 'costChartEmpty', true);
            return;
        }

        toggleChartEmpty('costChart', 'costChartEmpty', false);

        const data = {
            labels: ['Biaya Bahan', 'Biaya Tenaga Kerja', 'Margin'],
            datasets: [{
                data: [costData.bahan || 0, costData.tenaga_kerja || 0, costData.margin || 0],
                backgroundColor: ['#1c6494', '#f59e0b', '#16a34a']
            }]
        };

        if (!hppState.costChart) {
            hppState.costChart = new Chart(canvas, {
                type: 'doughnut',
                data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
            return;
        }

        hppState.costChart.data = data;
        hppState.costChart.update();
    }

    function getTrendPresentation(direction) {
        if (direction === 'up') {
            return {
                className: 'up',
                icon: 'trending-up'
            };
        }
        if (direction === 'down') {
            return {
                className: 'down',
                icon: 'trending-down'
            };
        }
        return {
            className: 'stable',
            icon: 'minus'
        };
    }

    function renderAnalysisComparisonTable(items) {
        const tbody = document.getElementById('analysisComparisonBody');
        if (!tbody) return;

        if (!Array.isArray(items) || items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px; color: #6b7280;">Belum ada data analisis produk</td></tr>';
            return;
        }

        tbody.innerHTML = items.map(item => {
            const margin = Number(item.margin || 0);
            const isPositive = margin >= 0;
            const trend = getTrendPresentation(item.trend_direction || 'stable');
            const trendPercentage = Number(item.trend_percentage || 0);
            const trendLabel = trendPercentage > 0
                ? `${escapeHtml(item.trend_label || 'Stabil')} (${trendPercentage.toFixed(1)}%)`
                : escapeHtml(item.trend_label || 'Stabil');

            return `
                <tr>
                    <td>${escapeHtml(item.nama_produk || '-')}</td>
                    <td><span class="analysis-source-badge">${escapeHtml(item.sumber_data_label || 'Data HPP saja')}</span></td>
                    <td class="analysis-money">Rp ${number_format(item.total_penjualan || 0)}</td>
                    <td class="analysis-money">Rp ${number_format(item.biaya_produksi || 0)}</td>
                    <td class="analysis-money ${isPositive ? 'positive' : 'negative'}">Rp ${number_format(margin)}</td>
                    <td><span class="analysis-status ${isPositive ? 'good' : 'bad'}">${escapeHtml(item.status || (isPositive ? 'Untung' : 'Rugi'))}</span></td>
                    <td><span class="analysis-trend ${trend.className}"><i data-lucide="${trend.icon}"></i>${trendLabel}</span></td>
                </tr>
            `;
        }).join('');
    }

    function renderAnalysisRecommendations(items) {
        const container = document.getElementById('analysisRecommendationList');
        if (!container) return;

        if (!Array.isArray(items) || items.length === 0) {
            container.innerHTML = `
                <div class="analysis-recommend-item">
                    <i data-lucide="info" class="analysis-recommend-icon"></i>
                    <div class="analysis-recommend-text">Rekomendasi otomatis akan muncul setelah tersedia data produk.</div>
                </div>
            `;
            return;
        }

        container.innerHTML = items.map(text => {
            const recommendationText = String(text || '');
            const isWarning = recommendationText.toLowerCase().includes('margin negatif') || recommendationText.toLowerCase().includes('evaluasi');
            const iconName = isWarning ? 'alert-triangle' : 'check-circle';
            const iconClass = isWarning ? 'warning' : 'positive';

            return `
                <div class="analysis-recommend-item">
                    <i data-lucide="${iconName}" class="analysis-recommend-icon ${iconClass}"></i>
                    <div class="analysis-recommend-text">${escapeHtml(recommendationText)}</div>
                </div>
            `;
        }).join('');
    }

    function renderAnalysisChart(chartData) {
        const canvas = document.getElementById('analysisProdukChart');
        if (!canvas) return;

        const labels = Array.isArray(chartData && chartData.labels) ? chartData.labels : [];
        const values = Array.isArray(chartData && chartData.values) ? chartData.values : [];
        const hasData = labels.length > 0 && values.length > 0;

        if (!hasData) {
            if (hppState.analysisChart) {
                hppState.analysisChart.destroy();
                hppState.analysisChart = null;
            }
            toggleChartEmpty('analysisProdukChart', 'analysisChartEmpty', true);
            return;
        }

        toggleChartEmpty('analysisProdukChart', 'analysisChartEmpty', false);

        const maxBars = 10;
        const data = {
            labels: labels.slice(0, maxBars),
            datasets: [{
                label: 'Total Penjualan',
                data: values.slice(0, maxBars),
                backgroundColor: '#1c6494',
                borderColor: '#1c6494',
                borderWidth: 1,
                borderRadius: 8
            }]
        };

        if (!hppState.analysisChart) {
            hppState.analysisChart = new Chart(canvas.getContext('2d'), {
                type: 'bar',
                data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = Number(context.raw || 0);
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return formatRupiahShort(value);
                                }
                            }
                        }
                    }
                }
            });
            return;
        }

        hppState.analysisChart.data = data;
        hppState.analysisChart.update();
    }

    function renderAnalysisSections(analysis) {
        const analysisPayload = analysis || {};
        renderAnalysisComparisonTable(Array.isArray(analysisPayload.produk_comparison) ? analysisPayload.produk_comparison : []);
        renderAnalysisChart(analysisPayload.chart || {});
        renderAnalysisRecommendations(Array.isArray(analysisPayload.rekomendasi) ? analysisPayload.rekomendasi : []);
    }

    function applyTableFilters() {
        const tbody = document.getElementById('hppTableBody');
        const searchInput = document.getElementById('searchInput');
        const marginFilter = document.getElementById('marginFilter');
        if (!tbody || !searchInput || !marginFilter) return;

        const query = searchInput.value.trim().toLowerCase();
        const margin = marginFilter.value;
        const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.id !== 'noResults');

        let visibleCount = 0;
        rows.forEach(row => {
            const searchBlob = (row.getAttribute('data-search') || '').toLowerCase();
            const marginBucket = row.getAttribute('data-margin') || '';

            const matchesSearch = !query || searchBlob.includes(query);
            const matchesMargin = !margin || marginBucket === margin;
            const shouldShow = matchesSearch && matchesMargin;

            row.style.display = shouldShow ? '' : 'none';
            if (shouldShow) visibleCount += 1;
        });

        let emptyRow = document.getElementById('noResults');
        if (!emptyRow) {
            emptyRow = document.createElement('tr');
            emptyRow.id = 'noResults';
            emptyRow.innerHTML = '<td colspan="7" style="text-align: center; padding: 32px; color: #6b7280;">Tidak ada data yang sesuai</td>';
            tbody.appendChild(emptyRow);
        }

        emptyRow.style.display = visibleCount === 0 ? '' : 'none';
    }

    function ensureLucideIcons() {
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons({
                attrs: {
                    width: '12',
                    height: '12'
                }
            });
        }
    }

    function renderFromPayload(payload) {
        hppState.payload = payload;
        hppState.items = payload.items || [];

        renderTable(hppState.items);
        renderHeaderStats(payload.stats || {
            total_produk: 0,
            total_penjualan: 0,
            total_biaya: 0
        });
        renderMarginCards(payload.margin_cards || {
            avg_margin: 0,
            avg_margin_percentage: 0,
            max_margin: 0,
            min_margin: 0,
            positive_count: 0,
            negative_count: 0,
            total_count: 0
        });

        renderMarginChart(hppState.items);
        renderCostChart(payload.charts ? payload.charts.cost || {} : {}, hppState.items.length > 0);
        renderAnalysisSections(payload.analysis || {});
        applyTableFilters();
        ensureLucideIcons();
    }

    async function refreshFromDatabase() {
        try {
            const response = await requestJson(HPP_ENDPOINTS.list);
            renderFromPayload(response.payload || {});
        } catch (error) {
            showNotification(error.message || 'Gagal memuat data HPP.', 'error');
        }
    }

    async function handleFormSubmit(event) {
        event.preventDefault();
        const form = document.getElementById('hppForm');
        if (!form) return;

        const id = form.dataset.id || '';
        const formData = new FormData();
        formData.append('nama_produk', form.nama_produk.value.trim());
        formData.append('kategori', form.kategori.value);
        formData.append('total_biaya_produksi', form.total_biaya_produksi.value || '0');
        formData.append('harga_jual', form.harga_jual.value || '0');
        formData.append('jumlah_produksi', form.jumlah_produksi.value || '1');

        try {
            const response = await requestJson(id ? (HPP_ENDPOINTS.editBase + id) : HPP_ENDPOINTS.create, {
                method: 'POST',
                body: formData
            });

            if (response.payload) {
                renderFromPayload(response.payload);
            } else {
                await refreshFromDatabase();
            }

            closeHppModal();
            showNotification(response.message || (id ? 'Data HPP berhasil diupdate.' : 'Data HPP berhasil ditambahkan.'), 'success');
        } catch (error) {
            showNotification(error.message || 'Gagal menyimpan data HPP.', 'error');
        }
    }

    async function handleDelete(id) {
        if (!id) return;
        const confirmDelete = confirm('Yakin ingin menghapus data HPP ini?');
        if (!confirmDelete) return;

        try {
            const response = await requestJson(HPP_ENDPOINTS.deleteBase + id, {
                method: 'POST'
            });
            if (response.payload) {
                renderFromPayload(response.payload);
            } else {
                await refreshFromDatabase();
            }
            showNotification(response.message || 'Data HPP berhasil dihapus.', 'success');
        } catch (error) {
            showNotification(error.message || 'Gagal menghapus data HPP.', 'error');
        }
    }

    async function recalculateMargins() {
        try {
            const response = await requestJson(HPP_ENDPOINTS.recalculate, {
                method: 'POST'
            });
            if (response.payload) {
                renderFromPayload(response.payload);
            } else {
                await refreshFromDatabase();
            }
            showNotification(response.message || 'Perhitungan margin berhasil diperbarui.', 'success');
        } catch (error) {
            showNotification(error.message || 'Gagal menghitung ulang margin.', 'error');
        }
    }

    function printTable() {
        const sourceTable = document.getElementById('hppTable');
        const marginCards = document.getElementById('marginAnalysisContainer');

        if (!sourceTable) {
            showNotification('Tidak ada data untuk dicetak.', 'error');
            return;
        }

        const tableClone = sourceTable.cloneNode(true);
        tableClone.querySelectorAll('tr').forEach(row => {
            if (row.cells.length > 0) {
                row.deleteCell(row.cells.length - 1);
            }
        });

        const printWindow = window.open('', '', 'width=1024,height=720');
        const html = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Laporan HPP</title>
                <style>
                    body { font-family: Inter, Arial, sans-serif; margin: 24px; color: #0f172a; }
                    h1 { margin: 0 0 6px; color: #1c6494; }
                    .meta { margin-bottom: 18px; color: #64748b; font-size: 13px; }
                    .cards { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; margin-bottom: 16px; }
                    .card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; background: #f8fafc; }
                    .label { font-size: 11px; color: #64748b; text-transform: uppercase; margin-bottom: 6px; }
                    .value { font-size: 18px; font-weight: 700; color: #1c6494; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; font-size: 13px; }
                    th { background: #1c6494; color: white; }
                    .currency { text-align: right; }
                    .badge { padding: 3px 8px; border-radius: 999px; font-size: 11px; font-weight: 700; }
                    .success { background: #d1fae5; color: #065f46; }
                    .danger { background: #fee2e2; color: #991b1b; }
                    .warning { background: #fef3c7; color: #92400e; }
                </style>
            </head>
            <body>
                <h1>Laporan HPP</h1>
                <div class="meta">Tanggal Cetak: ${new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })}</div>
                <div class="cards">${marginCards ? marginCards.innerHTML.replace(/margin-analysis-card/g, 'card').replace(/margin-label/g, 'label').replace(/margin-value/g, 'value') : ''}</div>
                ${tableClone.outerHTML}
            </body>
            </html>
        `;

        printWindow.document.write(html);
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.print();
        };
    }

    function findItemById(id) {
        const numericId = Number(id);
        return hppState.items.find(item => Number(item.id_hpp) === numericId) || null;
    }

    async function handleView(id) {
        const localItem = findItemById(id);
        if (localItem) {
            openDetailModal(localItem);
            return;
        }

        try {
            const response = await requestJson(HPP_ENDPOINTS.detailBase + id);
            openDetailModal(response.item || null);
        } catch (error) {
            showNotification(error.message || 'Gagal mengambil detail HPP.', 'error');
        }
    }

    function handleEdit(id) {
        const item = findItemById(id);
        if (!item) {
            showNotification('Data tidak ditemukan untuk diedit.', 'error');
            return;
        }
        openHppModal(item);
    }

    function handleTableActionClick(event) {
        const button = event.target.closest('button[data-action]');
        if (!button) return;

        const action = button.dataset.action;
        const id = button.dataset.id;

        if (action === 'view') {
            handleView(id);
            return;
        }
        if (action === 'edit') {
            handleEdit(id);
            return;
        }
        if (action === 'delete') {
            handleDelete(id);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const hppForm = document.getElementById('hppForm');
        const hppModal = document.getElementById('hppModal');
        const detailModal = document.getElementById('hppDetailModal');
        const tableBody = document.getElementById('hppTableBody');
        const searchInput = document.getElementById('searchInput');
        const marginFilter = document.getElementById('marginFilter');

        if (hppForm) {
            hppForm.addEventListener('submit', handleFormSubmit);
        }

        if (hppModal) {
            hppModal.addEventListener('click', function(e) {
                if (e.target === hppModal) closeHppModal();
            });
        }

        if (detailModal) {
            detailModal.addEventListener('click', function(e) {
                if (e.target === detailModal) closeDetailModal();
            });
        }

        if (tableBody) {
            tableBody.addEventListener('click', handleTableActionClick);
        }

        if (searchInput) {
            searchInput.addEventListener('input', applyTableFilters);
        }

        if (marginFilter) {
            marginFilter.addEventListener('change', applyTableFilters);
        }

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                if (searchInput) searchInput.focus();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                printTable();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                e.preventDefault();
                recalculateMargins();
            }
        });

        refreshFromDatabase();
    });
    </script>
    </div><!-- main-wrapper -->
</body>
</html>

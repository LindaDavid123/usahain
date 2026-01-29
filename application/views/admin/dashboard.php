<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin - Usahain</title>

<style>
:root{
    --primary:#1C6494;
    --secondary:#2980b9;
    --accent:#65C1DF;
    --success:#22c55e;
    --danger:#ef4444;
    --warning:#f59e0b;
    --info:#3b82f6;
    --bg:#f0f4f8;
    --card:#ffffff;
    --text:#1e293b;
    --muted:#64748b;
    --border:#e2e8f0;
    --shadow:0 4px 12px rgba(0,0,0,0.08);
}

*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

body{
    font-family:'Inter','Segoe UI','Arial',sans-serif;
    background:var(--bg);
    color:var(--text);
    line-height:1.6;
}


/* NAVBAR */
.navbar-main {
    background: linear-gradient(135deg, var(--card) 0%, #f8fafc 100%);
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    backdrop-filter: blur(8px);
}

.navbar-container {
    max-width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    height: 72px;
    padding: 0 48px;
}

.navbar-left {
    display: flex;
    align-items: center;
    min-width: fit-content;
    gap: 8px;
    flex: 0 0 auto;
}

.navbar-brand {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    text-decoration: none;
    color: var(--primary);
    font-weight: 800;
    font-size: 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    letter-spacing: -0.5px;
    padding: 8px 12px;
    border-radius: 10px;
    border: none;
    outline: none;
    background: transparent;
    cursor: pointer;
    font-family: inherit;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.navbar-brand:hover {
    background: rgba(28, 100, 148, 0.08);
    color: var(--primary);
}

.navbar-brand:active {
    transform: scale(0.98);
}

.navbar-brand:focus {
    outline: none;
    box-shadow: none;
}

.navbar-brand:focus-visible {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

.navbar-logo {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border-radius: 8px;
    box-shadow: none;
    padding: 4px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    flex-shrink: 0;
}

.navbar-brand:hover .navbar-logo {
    background: rgba(28, 100, 148, 0.1);
}

.navbar-brand:active .navbar-logo {
    transform: scale(0.96);
}

.navbar-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.navbar-center {
    display: flex;
    gap: 8px;
    justify-content: flex-start;
    flex: 1;
    align-items: center;
    min-width: 0;
}

.navbar-link {
    position: relative;
    color: var(--muted);
    text-decoration: none;
    font-weight: 500;
    font-size: 13px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 8px 12px;
    border-radius: 6px;
    outline: none;
    white-space: nowrap;
}

.navbar-link:hover {
    color: var(--primary);
    background: rgba(28, 100, 148, 0.06);
}

.navbar-link.active {
    color: var(--primary);
    font-weight: 600;
    background: rgba(28, 100, 148, 0.08);
}

.navbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: fit-content;
    flex: 0 0 auto;
}

.navbar-btn {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.navbar-btn.btn-secondary {
    background: var(--bg);
    color: var(--muted);
}

.navbar-btn.btn-logout {
    background: var(--danger);
    color: white;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
}

.navbar-btn.btn-logout:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35);
}

.navbar-avatar {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary), #0f3a7d);
    color: white;
    border-radius: 50%;
    font-weight: 700;
    font-size: 16px;
    box-shadow: 0 4px 12px rgba(28, 100, 148, 0.25);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.navbar-avatar:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 16px rgba(28, 100, 148, 0.35);
}

.navbar-toggle {
    display: none;
    background: none;
    border: none;
    color: var(--primary);
    font-size: 24px;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 6px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    flex-direction: row;
    align-items: center;
    justify-content: center;
}

.navbar-toggle:hover {
    background: var(--bg);
    color: var(--secondary);
    transform: scale(1.05);
}

.navbar-toggle.active {
    color: var(--secondary);
    background: rgba(28, 100, 148, 0.1);
}

.navbar-toggle:active {
    transform: scale(0.95);
}
}

.navbar-btn.btn-secondary:hover {
    background: var(--border);
    color: var(--primary);
    transform: translateY(-2px);
}

.navbar-btn.btn-logout {
    background: var(--danger);
    color: #fff;
}

.navbar-btn.btn-logout:hover {
    background: #dc2626;
    transform: translateY(-2px);
}

.navbar-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    transition: transform 0.2s;
    cursor: pointer;
}

.navbar-avatar:hover {
    transform: scale(1.05);
}

/* SIDEBAR */
.sidebar {
    position: fixed;
    left: 0;
    top: 74px;
    width: 250px;
    height: calc(100vh - 74px);
    background: var(--card);
    border-right: 1px solid var(--border);
    overflow-y: auto;
    padding: 20px 0;
    z-index: 50;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.sidebar.closed {
    transform: translateX(-100%);
    width: 250px;
}

.sidebar.open {
    transform: translateX(0);
    width: 250px;
}

/* Sidebar overlay for mobile */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    z-index: 45;
    opacity: 0;
    transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
}

.sidebar-overlay.open {
    display: block;
    opacity: 1;
    pointer-events: auto;
}
    pointer-events: auto;
}

.sidebar-menu {
    list-style: none;
}

.sidebar-item {
    margin: 0;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 22px;
    color: var(--muted);
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-left: 4px solid transparent;
    margin-bottom: 6px;
}

.sidebar-link:hover {
    background: var(--bg);
    color: var(--primary);
    border-left-color: var(--primary);
    padding-left: 24px;
}

.sidebar-link.active {
    background: rgba(28, 100, 148, 0.12);
    color: var(--primary);
    border-left-color: var(--primary);
    font-weight: 700;
}

/* TABS STYLING */
.tabs {
    display: flex;
    gap: 8px;
    border-bottom: 2px solid var(--border);
    margin-bottom: 40px;
    flex-wrap: wrap;
    padding-bottom: 0;
}

.tab-btn {
    padding: 14px 28px;
    background: none;
    border: none;
    border-bottom: 3px solid transparent;
    color: var(--muted);
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    white-space: nowrap;
    margin-bottom: -2px;
}

.tab-btn:hover {
    color: var(--primary);
    background: rgba(28, 100, 148, 0.05);
}

.tab-btn.active {
    color: var(--primary);
    border-bottom-color: var(--primary);
    font-weight: 700;
}

.tab-content {
    display: none;
    animation: fadeIn 0.3s ease;
}

.tab-content.active {
    display: block;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* MAIN CONTENT */
.main-content {
    margin-left: 250px;
    padding: 40px 50px;
    flex: 1;
    transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: var(--bg);
    min-height: calc(100vh - 74px);
}

.main-content.sidebar-closed {
    margin-left: 250px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 50px;
}

.page-title {
    font-size: 32px;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.5px;
}

.page-subtitle {
    color: var(--muted);
    font-size: 15px;
    margin-top: 8px;
    font-weight: 500;
}

/* CARDS GRID */
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 28px;
    margin-bottom: 60px;
    margin-top: 0;
}

.stat-card {
    background: var(--card);
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid var(--border);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 32px rgba(0,0,0,0.12);
    border-color: var(--primary);
}

.stat-card.green {
    border-top: 4px solid var(--success);
}

.stat-card.blue {
    border-top: 4px solid var(--primary);
}

.stat-card.purple {
    border-top: 4px solid #a855f7;
}

.stat-card.orange {
    border-top: 4px solid var(--warning);
}

.stat-label {
    color: var(--muted);
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.stat-value {
    font-size: 36px;
    font-weight: 800;
    margin: 16px 0;
    color: var(--text);
}

.stat-change {
    font-size: 13px;
    font-weight: 600;
}

.stat-change.positive {
    color: var(--success);
}

.stat-change.negative {
    color: var(--danger);
}

/* SECTION */
.section {
    background: var(--card);
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1px solid var(--border);
    margin-bottom: 50px;
    transition: all 0.3s ease;
}

.section:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    border-bottom: 2px solid var(--border);
    padding-bottom: 20px;
    flex-wrap: wrap;
    gap: 16px;
}

.section-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text);
    margin: 0;
}

.section-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

/* TABLE */
.table-responsive {
    overflow-x: auto;
    margin-top: 20px;
    margin-bottom: 24px;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

th {
    background: var(--bg);
    padding: 16px 14px;
    text-align: left;
    font-weight: 700;
    color: var(--text);
    border-bottom: 2px solid var(--border);
    letter-spacing: 0.3px;
}

td {
    padding: 16px 14px;
    border-bottom: 1px solid var(--border);
    color: var(--text);
}

tr:hover {
    background: var(--bg);
    transition: background 0.2s ease;
}

tr:last-child td {
    border-bottom: none;
}

/* BUTTON */
.btn {
    padding: 12px 24px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    white-space: nowrap;
    letter-spacing: 0.3px;
}

.btn-primary {
    background: var(--primary);
    color: #fff;
}

.btn-primary:hover {
    background: var(--secondary);
    transform: translateY(-2px);
}

.btn-secondary {
    background: var(--bg);
    color: var(--text);
    border: 1px solid var(--border);
}

.btn-secondary:hover {
    background: var(--border);
}

.btn-success {
    background: var(--success);
    color: #fff;
}

.btn-success:hover {
    background: #16a34a;
}

.btn-danger {
    background: var(--danger);
    color: #fff;
}

.btn-danger:hover {
    background: #dc2626;
}

.btn-warning {
    background: var(--warning);
    color: #fff;
}

.btn-warning:hover {
    background: #d97706;
}

.btn-info {
    background: var(--info);
    color: #fff;
}

.btn-info:hover {
    background: #2563eb;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

/* BADGE */
.badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: rgba(34, 197, 94, 0.1);
    color: var(--success);
}

.badge-danger {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.badge-warning {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.badge-info {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info);
}

/* PROGRESS BAR */
.progress-bar {
    background: var(--bg);
    border-radius: 10px;
    height: 8px;
    overflow: hidden;
    margin: 8px 0;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--secondary));
    transition: width 0.3s ease;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(2px);
    transition: background 0.3s ease;
}

.modal.active {
    display: flex;
}

.modal-content {
    background: var(--card);
    border-radius: 16px;
    padding: 40px;
    max-width: 550px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    border-bottom: 2px solid var(--border);
    padding-bottom: 18px;
}

.modal-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.3px;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: var(--muted);
    transition: all 0.2s ease;
    padding: 8px;
}

.modal-close:hover {
    color: var(--text);
    transform: rotate(90deg);
}

.modal-body {
    margin-bottom: 28px;
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: var(--text);
    font-size: 14px;
    letter-spacing: 0.2px;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    transition: all 0.3s ease;
    background: var(--card);
    color: var(--text);
}

.form-control:hover {
    border-color: var(--primary);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(28, 100, 148, 0.15);
}

/* RESPONSIVE */
@media (max-width: 1024px) {
    .sidebar {
        width: 200px;
    }
    
    .main-content {
        margin-left: 200px;
        padding: 24px;
    }

    .cards-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }

    .navbar-center {
        gap: 20px;
    }

    .stat-card {
        padding: 20px;
    }

    .stat-value {
        font-size: 24px;
    }

    .section {
        padding: 20px;
    }

    .page-title {
        font-size: 24px;
    }
}

@media (max-width: 1024px) {
    .navbar-container {
        padding: 0 40px;
        gap: 16px;
    }

    .navbar-center {
        gap: 6px;
    }

    .navbar-link {
        font-size: 12px;
        padding: 8px 10px;
    }

    .navbar-btn {
        padding: 9px 18px;
        font-size: 12px;
    }
}

@media (max-width: 768px) {
    .navbar-toggle {
        display: block !important;
    }

    .navbar-main {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .navbar-container {
        padding: 0 16px;
        height: 64px;
        gap: 12px;
        justify-content: space-between;
    }

    .navbar-left {
        gap: 6px;
        flex: 1;
        min-width: 0;
    }

    .navbar-brand {
        font-size: 17px;
        gap: 8px;
        padding: 6px 8px;
        flex-shrink: 0;
    }

    .navbar-logo {
        width: 44px;
        height: 44px;
        padding: 3px;
    }

    .navbar-center {
        display: none;
    }

    .navbar-link {
        font-size: 12px;
        padding: 6px 8px;
    }

    .navbar-right {
        gap: 8px;
    }

    .navbar-btn {
        padding: 8px 16px;
        font-size: 12px;
    }

    .navbar-avatar {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }

    /* Mobile sidebar overlay behavior */
    .sidebar {
        position: fixed;
        left: 0;
        top: 64px;
        width: 250px;
        height: calc(100vh - 64px);
        background: var(--card);
        border-right: 1px solid var(--border);
        overflow-y: auto;
        padding: 20px 0;
        z-index: 60;
        box-shadow: 2px 0 8px rgba(0, 0, 0, 0.12);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar.open {
        transform: translateX(0) !important;
    }

    .sidebar.closed {
        transform: translateX(-100%) !important;
    }

    .sidebar-overlay {
        display: none;
    }

    .sidebar-overlay.open {
        display: block !important;
    }    .sidebar-overlay.open {
        display: block;
    }

    .main-content {
        margin-left: 0;
        padding: 24px 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-header {
        margin-bottom: 28px;
    }

    .page-title {
        font-size: 24px;
    }

    .cards-grid {
        grid-template-columns: 1fr;
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        padding: 20px;
    }

    .stat-label {
        font-size: 12px;
        letter-spacing: 0.6px;
    }

    .stat-value {
        font-size: 28px;
        margin: 12px 0;
    }

    .section {
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 32px;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 18px;
    }

    .section-actions {
        width: 100%;
        gap: 8px;
    }

    .section-actions .btn {
        flex: 1;
    }

    .tabs {
        overflow-x: auto;
        gap: 6px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        -webkit-overflow-scrolling: touch;
    }

    .tab-btn {
        padding: 12px 20px;
        font-size: 13px;
        white-space: nowrap;
    }

    table {
        font-size: 13px;
        min-width: 550px;
    }

    th {
        padding: 14px 10px;
        font-size: 12px;
    }

    td {
        padding: 12px 10px;
    }

    .btn {
        padding: 10px 16px;
        font-size: 13px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 11px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-control {
        padding: 10px 12px;
        font-size: 13px;
    }

    .badge {
        padding: 6px 12px;
        font-size: 11px;
    }
}

    .badge-danger {
        background-color: #ef4444;
        color: white;
    }

    .badge-info {
        background-color: #3b82f6;
        color: white;
    }

    .badge-warning {
        background-color: #f59e0b;
        color: white;
    }

    /* Action Buttons in Table */
    td .btn {
        padding: 5px 10px;
        font-size: 12px;
        margin-right: 4px;
        border: none;
    }

    .btn-sm {
        padding: 6px 10px;
        font-size: 12px;
    }

    .btn-info {
        background-color: #3b82f6;
        color: white;
    }

    .btn-info:hover {
        background-color: #2563eb;
        color: white;
    }

    .btn-warning {
        background-color: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background-color: #d97706;
        color: white;
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
        color: white;
    }

    .btn-primary {
        background-color: #6366f1;
        color: white;
    }

    .btn-primary:hover {
        background-color: #4f46e5;
        color: white;
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
        color: white;
    }

    /* Section Headers & Title */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .section-title {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: var(--primary);
    }

    .section-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .section-actions .btn {
        flex-grow: 0;
        white-space: nowrap;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-label {
        font-weight: 500;
        font-size: 14px;
        color: var(--text);
    }

    .form-control {
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 14px;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Responsive Settings Grid */
    .settings-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .section-actions {
        flex-wrap: wrap;
    }

    .section-actions .btn {
        min-width: 100px;
        flex-grow: 1;
    }

    .form-control {
        font-size: 14px;
    }

    /* Settings Grid Responsive */
    .settings-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important;
    }

    .section-header {
        gap: 12px;
    }

    .section-title {
        flex: 1;
        min-width: 200px;
    }
}

@media (max-width: 480px) {
    .navbar-main {
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
    }

    .navbar-container {
        padding: 0 12px;
        height: 60px;
        gap: 8px;
    }

    .navbar-left {
        flex: 1;
        min-width: 0;
    }

    .navbar-brand {
        font-size: 16px;
        gap: 6px;
        padding: 4px 6px;
    }

    .navbar-logo {
        width: 40px;
        height: 40px;
        padding: 2px;
    }

    .navbar-center {
        display: none;
    }

    .navbar-right {
        gap: 6px;
    }

    .navbar-btn {
        padding: 6px 12px;
        font-size: 11px;
    }

    .navbar-avatar {
        width: 36px;
        height: 36px;
        font-size: 12px;
    }

    .main-content {
        padding: 16px 12px;
    }

    .page-header {
        margin-bottom: 20px;
    }

    .page-title {
        font-size: 20px;
    }

    .page-subtitle {
        font-size: 12px;
        margin-top: 6px;
    }

    .cards-grid {
        gap: 12px;
        margin-bottom: 24px;
    }

    .stat-card {
        padding: 16px;
        border-radius: 10px;
    }

    .stat-label {
        font-size: 11px;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 22px;
        margin: 10px 0;
    }

    .stat-change {
        font-size: 12px;
    }

    .section {
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 24px;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .section-title {
        font-size: 16px;
    }

    .section-actions {
        width: 100%;
        gap: 8px;
    }

    .section-actions .btn {
        flex: 1;
    }

    .tabs {
        gap: 4px;
        margin-bottom: 16px;
        padding-bottom: 10px;
    }

    .tab-btn {
        padding: 10px 14px;
        font-size: 12px;
        white-space: nowrap;
    }

    .tab-content {
        animation: none;
    }

    table {
        font-size: 12px;
        min-width: 450px;
    }

    th {
        padding: 12px 8px;
        font-size: 11px;
    }

    td {
        padding: 10px 8px;
    }

    /* Hide extra columns in table on mobile */
    table th:nth-child(4),
    table td:nth-child(4) {
        display: none;
    }

    .modal-content {
        width: 95%;
        padding: 24px;
        max-width: none;
    }

    .modal-header {
        margin-bottom: 20px;
    }

    .modal-title {
        font-size: 18px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        font-size: 13px;
        margin-bottom: 8px;
    }

    .form-control {
        padding: 10px 12px;
        font-size: 14px;
    }

    .btn {
        padding: 10px 14px;
        font-size: 13px;
    }

    .btn-sm {
        padding: 6px 10px;
        font-size: 11px;
    }

    .badge {
        padding: 4px 10px;
        font-size: 10px;
    }
    .section-actions {
        width: 100%;
    }

    .section-actions .btn {
        font-size: 11px;
        padding: 6px 10px;
    }
}
    td .btn {
        padding: 4px 8px;
        font-size: 11px;
        margin-right: 2px;
    }
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-main">
    <div class="navbar-container">
        <div class="navbar-left">
            <button class="navbar-toggle" id="sidebarToggle" onclick="toggleSidebar()" style="display: none; margin-right: 12px;">
                <span>☰</span>
            </button>
            <button class="navbar-brand" onclick="toggleSidebar(event)" title="Toggle Sidebar">
                <span class="navbar-logo"><img src="<?= base_url('assets/logo.png'); ?>" alt="Usahain"></span>
                <span>Usahain Admin</span>
            </button>
        </div>
        <div class="navbar-right">
            <div class="navbar-avatar" title="Profile Admin"><?= strtoupper(substr($this->session->userdata('nama') ?? 'A',0,1)); ?></div>
            <a href="<?= site_url('auth/logout'); ?>" class="navbar-btn btn-logout" onclick="return confirm('Yakin ingin logout?')">
                <span>Logout</span>
            </a>
        </div>
    </div>
</nav>

<!-- Sidebar Overlay untuk Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div><!-- SIDEBAR -->
<aside class="sidebar closed" id="sidebar">
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="javascript:void(0)" class="sidebar-link active" onclick="setActive(this); switchTab('overview')">
                Dashboard
            </a>
        </li>
        <li class="sidebar-item">
            <a href="javascript:void(0)" class="sidebar-link" onclick="setActive(this); switchTab('pengguna')">
                Pengguna
            </a>
        </li>
        <li class="sidebar-item">
            <a href="javascript:void(0)" class="sidebar-link" onclick="setActive(this); switchTab('bisnis')">
                Data Bisnis
            </a>
        </li>
        <li class="sidebar-item">
            <a href="javascript:void(0)" class="sidebar-link" onclick="setActive(this); switchTab('subscription')">
                Subscription
            </a>
        </li>
        <li class="sidebar-item">
            <a href="javascript:void(0)" class="sidebar-link" onclick="setActive(this); switchTab('fitur')">
                Fitur
            </a>
        </li>
        <li class="sidebar-item">
            <a href="javascript:void(0)" class="sidebar-link" onclick="setActive(this); switchTab('laporan')">
                Laporan
            </a>
        </li>
        <li class="sidebar-item">
            <a href="javascript:void(0)" class="sidebar-link" onclick="setActive(this); switchTab('pengaturan')">
                Pengaturan
            </a>
        </li>
    </ul>
</aside>

<!-- MAIN CONTENT -->
<div class="main-content">

    <!-- PAGE HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard Admin</h1>
            <p class="page-subtitle">Kelola semua aspek aplikasi Usahain</p>
        </div>
    </div>

    <!-- TABS - Quick Navigation (Optional, can be removed) -->
    <!-- This section is optional for quick filtering/viewing within Overview tab -->

    <!-- TAB: OVERVIEW -->
    <div id="overview" class="tab-content active">
        <div class="stat-card green">
            <div class="stat-label">Total Pengguna</div>
            <div class="stat-value"><?= isset($total_users) ? number_format($total_users) : '0'; ?></div>
            <div class="stat-change positive">+<?= isset($new_users) ? $new_users : '0'; ?> bulan ini</div>
        </div>

        <div class="stat-card blue">
            <div class="stat-label">Pengguna Aktif</div>
            <div class="stat-value"><?= isset($active_users) ? number_format($active_users) : '0'; ?></div>
            <div class="stat-change positive">+<?= isset($active_increase) ? $active_increase : '5'; ?>% dari bulan lalu</div>
        </div>

        <div class="stat-card purple">
            <div class="stat-label">Premium Users</div>
            <div class="stat-value"><?= isset($premium_users) ? number_format($premium_users) : '0'; ?></div>
            <div class="stat-change positive"><?= isset($conversion_rate) ? $conversion_rate : '12'; ?>% conversion</div>
        </div>

        <div class="stat-card orange">
            <div class="stat-label">Revenue Bulan Ini</div>
            <div class="stat-value">Rp <?= number_format(isset($revenue) ? $revenue : 0,0,',','.'); ?></div>
            <div class="stat-change positive">+<?= isset($revenue_increase) ? $revenue_increase : '8'; ?>% dari bulan lalu</div>
        </div>
    </div><!-- End Overview Tab -->

    <!-- TAB: PENGGUNA -->
    <div id="pengguna" class="tab-content">
        <div class="section">
            <div class="section-header">
            <h2 class="section-title">Pengguna Terbaru</h2>
            <div class="section-actions">
                <button class="btn btn-primary btn-sm" onclick="openAddUserModal()">+ Tambah Pengguna</button>
                <button class="btn btn-secondary btn-sm" onclick="refreshUsers()">Refresh</button>
            </div>

            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $users = array(
                        array('id' => 1, 'name' => 'Budi Santoso', 'email' => 'budi@example.com', 'status' => 'Aktif', 'date' => '2026-01-05'),
                        array('id' => 2, 'name' => 'Siti Nurhaliza', 'email' => 'siti@example.com', 'status' => 'Aktif', 'date' => '2026-01-04'),
                        array('id' => 3, 'name' => 'Ahmad Wijaya', 'email' => 'ahmad@example.com', 'status' => 'Aktif', 'date' => '2026-01-03'),
                        array('id' => 4, 'name' => 'Rina Kartika', 'email' => 'rina@example.com', 'status' => 'Inactive', 'date' => '2026-01-02'),
                        array('id' => 5, 'name' => 'Dedi Gunawan', 'email' => 'dedi@example.com', 'status' => 'Aktif', 'date' => '2026-01-01'),
                    );
                    
                    foreach($users as $u): 
                    ?>
                    <tr>
                        <td><strong><?= $u['name']; ?></strong></td>
                        <td><?= $u['email']; ?></td>
                        <td>
                            <span class="badge <?= $u['status'] == 'Aktif' ? 'badge-success' : 'badge-danger'; ?>">
                                <?= $u['status']; ?>
                            </span>
                        </td>
                        <td><?= $u['date']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="editUser(<?= $u['id']; ?>)">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $u['id']; ?>)">Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    </div><!-- End Pengguna Tab -->

    <!-- TAB: FITUR -->
    <div id="fitur" class="tab-content">
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Penggunaan Fitur (30 Hari)</h2>
                <div class="section-actions">
                    <button class="btn btn-secondary btn-sm" onclick="refreshFeatureUsage()">Refresh</button>
                    <button class="btn btn-info btn-sm" onclick="openExportModal()">Export</button>
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Fitur</th>
                            <th>Penggunaan</th>
                            <th>Persentase</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $features = array(
                            array('name' => 'AI Advisor', 'count' => 1250, 'percent' => 95),
                            array('name' => 'Kalkulator HPP', 'count' => 980, 'percent' => 78),
                            array('name' => 'Pencatatan Keuangan', 'count' => 1100, 'percent' => 88),
                            array('name' => 'Analisis Produk', 'count' => 650, 'percent' => 52),
                            array('name' => 'Manajemen Risiko', 'count' => 520, 'percent' => 42),
                        );
                        
                        if (!empty($features) && is_array($features)): 
                            foreach($features as $f): 
                        ?>
                        <tr>
                            <td><strong><?= $f['name']; ?></strong></td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width:<?= $f['percent']; ?>%"></div>
                                </div>
                            </td>
                            <td><span class="badge badge-info"><?= $f['percent']; ?>%</span></td>
                            <td>
                                <button class="btn btn-sm btn-secondary" onclick="viewFeatureDetails('<?= $f['name']; ?>')">Detail</button>
                            </td>
                        </tr>
                        <?php 
                            endforeach; 
                        else: 
                        ?>
                        <tr>
                            <td colspan="4" style="text-align:center;color:var(--muted)">Tidak ada data penggunaan fitur.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section" style="margin-top: 30px;">
            <div class="section-header">
                <h2 class="section-title">Statistik Fitur</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div class="stat-card blue">
                    <div class="stat-label">Total Penggunaan Fitur</div>
                    <div class="stat-value">4,500</div>
                    <div class="stat-change positive">+15% dari minggu lalu</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-label">Fitur Paling Populer</div>
                    <div class="stat-value">AI Advisor</div>
                    <div class="stat-change positive">95% pengguna aktif</div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-label">Rata-rata Penggunaan/User</div>
                    <div class="stat-value">3.6</div>
                    <div class="stat-change positive">Fitur per pengguna</div>
                </div>
            </div>
        </div>
    </div><!-- End Fitur Tab -->

    <!-- TAB: PENGATURAN -->
    <div id="pengaturan" class="tab-content">
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">⚙️ Pengaturan Aplikasi</h2>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;" class="settings-grid">
                <!-- General Settings -->
                <div style="border: 1px solid var(--border); border-radius: 12px; padding: 20px;">
                    <h3 style="color: var(--primary); margin-bottom: 16px;">Pengaturan Umum</h3>
                    <div class="form-group">
                        <label class="form-label">Nama Aplikasi</label>
                        <input type="text" class="form-control" value="Usahain" onchange="saveSetting(this)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Support</label>
                        <input type="email" class="form-control" value="support@usahain.com" onchange="saveSetting(this)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telepon Support</label>
                        <input type="tel" class="form-control" value="+62-123-456-789" onchange="saveSetting(this)">
                    </div>
                </div>

                <!-- Security Settings -->
                <div style="border: 1px solid var(--border); border-radius: 12px; padding: 20px;">
                    <h3 style="color: var(--primary); margin-bottom: 16px;">Keamanan</h3>
                    <div class="form-group">
                        <label class="form-label">
                            <input type="checkbox" checked> Aktifkan Two-Factor Authentication
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <input type="checkbox" checked> Aktifkan Email Verification
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Max Login Attempts</label>
                        <input type="number" class="form-control" value="5" onchange="saveSetting(this)">
                    </div>
                    <button class="btn btn-warning" onclick="changePassword()">Ubah Password Admin</button>
                </div>

                <!-- Email Settings -->
                <div style="border: 1px solid var(--border); border-radius: 12px; padding: 20px;">
                    <h3 style="color: var(--primary); margin-bottom: 16px;">Email Settings</h3>
                    <div class="form-group">
                        <label class="form-label">SMTP Host</label>
                        <input type="text" class="form-control" value="smtp.gmail.com" onchange="saveSetting(this)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">SMTP Port</label>
                        <input type="number" class="form-control" value="587" onchange="saveSetting(this)">
                    </div>
                    <button class="btn btn-info" onclick="testEmail()">Test Email</button>
                </div>

                <!-- Payment Settings -->
                <div style="border: 1px solid var(--border); border-radius: 12px; padding: 20px;">
                    <h3 style="color: var(--primary); margin-bottom: 16px;">Payment Gateway</h3>
                    <div class="form-group">
                        <label class="form-label">Midtrans Server Key</label>
                        <input type="password" class="form-control" placeholder="Masukkan key..." onchange="saveSetting(this)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Midtrans Client Key</label>
                        <input type="password" class="form-control" placeholder="Masukkan key..." onchange="saveSetting(this)">
                    </div>
                    <button class="btn btn-info" onclick="testPayment()">Test Payment</button>
                </div>

                <!-- Backup Settings -->
                <div style="border: 1px solid var(--border); border-radius: 12px; padding: 20px;">
                    <h3 style="color: var(--primary); margin-bottom: 16px;">Backup Database</h3>
                    <div style="margin-bottom: 12px;">
                        <p style="font-size: 13px; color: var(--muted);">Last Backup: 2026-01-08 15:30:00</p>
                    </div>
                    <button class="btn btn-success" onclick="backupDatabase()" style="width: 100%; margin-bottom: 8px;">Backup Sekarang</button>
                    <button class="btn btn-secondary" onclick="restoreDatabase()" style="width: 100%;">Restore Backup</button>
                </div>

                <!-- System Info -->
                <div style="border: 1px solid var(--border); border-radius: 12px; padding: 20px;">
                    <h3 style="color: var(--primary); margin-bottom: 16px;">Informasi Sistem</h3>
                    <div style="font-size: 13px; color: var(--muted); line-height: 1.8;">
                        <p><strong>Versi App:</strong> 1.0.0</p>
                        <p><strong>Database:</strong> MySQL 5.7</p>
                        <p><strong>PHP Version:</strong> 7.4.33</p>
                        <p><strong>Server:</strong> Apache 2.4</p>
                        <p><strong>Last Update:</strong> 2026-01-01</p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Pengaturan Tab -->

    <!-- TAB: DATA BISNIS -->
    <div id="bisnis" class="tab-content">
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Data Bisnis Pengguna</h2>
                <div class="section-actions">
                    <button class="btn btn-secondary btn-sm" onclick="refreshBisnis()">Refresh</button>
                    <button class="btn btn-success btn-sm" onclick="openAddBisnis()">➕ Tambah</button>
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Bisnis</th>
                            <th>Pemilik</th>
                            <th>Jenis Usaha</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $bisnis = array(
                            array('nama' => 'Toko Elektronik ABC', 'pemilik' => 'Budi Santoso', 'jenis' => 'Retail', 'status' => 'Aktif'),
                            array('nama' => 'Warung Makan Sejahtera', 'pemilik' => 'Siti Nurhaliza', 'jenis' => 'F&B', 'status' => 'Aktif'),
                            array('nama' => 'Laundry Express', 'pemilik' => 'Ahmad Wijaya', 'jenis' => 'Jasa', 'status' => 'Aktif'),
                            array('nama' => 'Kafe Cozy Corner', 'pemilik' => 'Rina Kartika', 'jenis' => 'F&B', 'status' => 'Nonaktif'),
                        );
                        
                        foreach($bisnis as $b): 
                        ?>
                        <tr>
                            <td><strong><?= $b['nama']; ?></strong></td>
                            <td><?= $b['pemilik']; ?></td>
                            <td><?= $b['jenis']; ?></td>
                            <td><span class="badge <?= $b['status'] == 'Aktif' ? 'badge-success' : 'badge-danger'; ?>"><?= $b['status']; ?></span></td>
                            <td>
                                <button class="btn btn-sm btn-secondary" onclick="editBisnis('<?= $b['nama']; ?>')">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteBisnis('<?= $b['nama']; ?>')">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- End Data Bisnis Tab -->

    <!-- TAB: SUBSCRIPTION -->
    <div id="subscription" class="tab-content">
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Subscription Pengguna</h2>
                <div class="section-actions">
                    <button class="btn btn-secondary btn-sm" onclick="refreshSubscription()">Refresh</button>
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <th>Tanggal Berakhir</th>
                            <th>Harga/Bulan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $subscriptions = array(
                            array('user' => 'Budi Santoso', 'plan' => 'Premium', 'status' => 'Active', 'expires' => '2026-04-05', 'price' => 'Rp 299.000'),
                            array('user' => 'Siti Nurhaliza', 'plan' => 'Starter', 'status' => 'Active', 'expires' => '2026-02-04', 'price' => 'Rp 99.000'),
                            array('user' => 'Ahmad Wijaya', 'plan' => 'Elite', 'status' => 'Active', 'expires' => '2026-07-03', 'price' => 'Rp 599.000'),
                            array('user' => 'Rina Kartika', 'plan' => 'Free', 'status' => 'Expired', 'expires' => '2025-12-02', 'price' => 'Gratis'),
                        );
                        
                        foreach($subscriptions as $s): 
                        ?>
                        <tr>
                            <td><strong><?= $s['user']; ?></strong></td>
                            <td><?= $s['plan']; ?></td>
                            <td><span class="badge <?= $s['status'] == 'Active' ? 'badge-success' : 'badge-danger'; ?>"><?= $s['status']; ?></span></td>
                            <td><?= $s['expires']; ?></td>
                            <td><?= $s['price']; ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewSubscriptionDetail('<?= $s['user']; ?>')">Detail</button>
                                <button class="btn btn-sm btn-warning" onclick="renewSubscription('<?= $s['user']; ?>')">Perbarui</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- End Subscription Tab -->

    <!-- TAB: LAPORAN -->
    <div id="laporan" class="tab-content">
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Laporan & Analisis</h2>
                <div class="section-actions">
                    <button class="btn btn-secondary btn-sm" onclick="generateReport()">Generate</button>
                    <button class="btn btn-info btn-sm" onclick="openExportModal()">Export</button>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <div class="stat-card blue">
                    <div class="stat-label">Total Pendapatan (Bulan Ini)</div>
                    <div class="stat-value">Rp 45.5M</div>
                    <div class="stat-change positive">+18% dari bulan lalu</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-label">New Users (Bulan Ini)</div>
                    <div class="stat-value">342</div>
                    <div class="stat-change positive">+22% dari bulan lalu</div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-label">Churn Rate</div>
                    <div class="stat-value">2.4%</div>
                    <div class="stat-change negative">-1.2% improvement</div>
                </div>
                <div class="stat-card orange">
                    <div class="stat-label">Avg Session Duration</div>
                    <div class="stat-value">28 min</div>
                    <div class="stat-change positive">+5 min increase</div>
                </div>
            </div>

            <div class="section" style="margin-top: 30px;">
                <h3 class="section-title">📊 Rincian Laporan</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Metrik</th>
                                <th>Januari 2026</th>
                                <th>Desember 2025</th>
                                <th>Perubahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Total Users</strong></td>
                                <td>1,250</td>
                                <td>1,008</td>
                                <td><span class="badge badge-success">+19.0%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Active Users</strong></td>
                                <td>890</td>
                                <td>756</td>
                                <td><span class="badge badge-success">+17.7%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Premium Conversions</strong></td>
                                <td>156</td>
                                <td>128</td>
                                <td><span class="badge badge-success">+21.9%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Total Revenue</strong></td>
                                <td>Rp 45.5M</td>
                                <td>Rp 38.6M</td>
                                <td><span class="badge badge-success">+17.9%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Customer Support Tickets</strong></td>
                                <td>234</td>
                                <td>312</td>
                                <td><span class="badge badge-danger">-25.0%</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- End Laporan Tab -->

</div><!-- End Main Content -->

<!-- MODAL: ADD USER -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Pengguna Baru</h3>
            <button class="modal-close" onclick="closeModal('addUserModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="addUserForm" onsubmit="submitAddUser(event)">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="user">User</option>
                        <option value="premium">Premium User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Simpan</button>
                    <button type="button" class="btn btn-secondary" style="flex: 1;" onclick="closeModal('addUserModal')">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL: EXPORT DATA -->
<div id="exportModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Export Data</h3>
            <button class="modal-close" onclick="closeModal('exportModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form onsubmit="submitExport(event)">
                <div class="form-group">
                    <label class="form-label">Tipe Data</label>
                    <select class="form-control" required>
                        <option value="">-- Pilih Tipe Data --</option>
                        <option value="users">Data Pengguna</option>
                        <option value="subscription">Data Subscription</option>
                        <option value="features">Penggunaan Fitur</option>
                        <option value="all">Semua Data</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Format</label>
                    <select class="form-control" required>
                        <option value="csv">CSV</option>
                        <option value="pdf">PDF</option>
                        <option value="xlsx">Excel</option>
                    </select>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-success" style="flex: 1;">Download</button>
                    <button type="button" class="btn btn-secondary" style="flex: 1;" onclick="closeModal('exportModal')">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Tab switching function
    function switchTab(tabName) {
        // Hide all tab content
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Show selected tab
        const selectedTab = document.getElementById(tabName);
        if (selectedTab) {
            selectedTab.classList.add('active');
        }
        
        // Add active class to clicked button
        event.target.classList.add('active');
    }

    // Set active menu
    function setActive(element) {
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.classList.remove('active');
        });
        element.classList.add('active');
    }

    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    function openAddUserModal() {
        openModal('addUserModal');
    }

    function openExportModal() {
        openModal('exportModal');
    }

    // Form submissions
    function submitAddUser(event) {
        event.preventDefault();
        alert('Pengguna berhasil ditambahkan! Fitur akan diintegrasikan dengan database.');
        closeModal('addUserModal');
    }

    function submitExport(event) {
        event.preventDefault();
        alert('Data sedang dipersiapkan untuk diunduh...');
        closeModal('exportModal');
    }

    // Action functions
    function editUser(userId) {
        alert('Edit user dengan ID: ' + userId);
    }

    function deleteUser(userId) {
        if (confirm('Yakin ingin menghapus pengguna ini?')) {
            alert('Pengguna dengan ID: ' + userId + ' berhasil dihapus!');
        }
    }

    function viewSubscriptionDetail(userName) {
        alert('Detail subscription untuk: ' + userName);
    }

    function renewSubscription(userName) {
        alert('Perpanjangan subscription untuk: ' + userName);
    }

    function viewFeatureDetails(featureName) {
        alert('Detail penggunaan: ' + featureName);
    }

    function refreshFeatureUsage() {
        alert('Data penggunaan fitur sedang diperbarui...');
    }

    function refreshUsers() {
        alert('Data pengguna sedang diperbarui...');
    }

    function refreshSubscription() {
        alert('Data subscription sedang diperbarui...');
    }

    function refreshBisnis() {
        alert('Data bisnis sedang diperbarui...');
    }

    function openAddBisnis() {
        alert('Membuka form tambah bisnis...');
    }

    function editBisnis(nama) {
        alert('Edit bisnis: ' + nama);
    }

    function deleteBisnis(nama) {
        if (confirm('Yakin ingin menghapus bisnis: ' + nama + '?')) {
            alert('Bisnis berhasil dihapus!');
        }
    }

    function generateReport() {
        alert('Generate laporan sedang diproses...');
    }

    // Sidebar Toggle dengan Real-time Animation
    let sidebarOpen = false;

    function toggleSidebar(event) {
        if (event) {
            event.preventDefault();
        }
        
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (!sidebar) {
            console.error('Sidebar not found');
            return;
        }
        
        const isMobile = window.innerWidth <= 768;
        
        console.log('Toggle Sidebar - Mobile:', isMobile, 'Open:', sidebarOpen, 'Width:', window.innerWidth);
        
        // Toggle sidebar on mobile
        sidebarOpen = !sidebarOpen;
        
        if (sidebarOpen) {
            sidebar.classList.remove('closed');
            sidebar.classList.add('open');
            if (overlay) overlay.classList.add('open');
            console.log('Sidebar opened');
        } else {
            sidebar.classList.remove('open');
            sidebar.classList.add('closed');
            if (overlay) overlay.classList.remove('open');
            console.log('Sidebar closed');
        }
    }

    function openSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isMobile = window.innerWidth <= 768;
        
        if (!sidebar || sidebarOpen) return;
        
        if (isMobile) {
            sidebarOpen = true;
            sidebar.classList.remove('closed');
            sidebar.classList.add('open');
            if (overlay) overlay.classList.add('open');
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isMobile = window.innerWidth <= 768;
        
        if (!sidebar || !sidebarOpen) return;
        
        if (isMobile) {
            sidebarOpen = false;
            sidebar.classList.remove('open');
            sidebar.classList.add('closed');
            if (overlay) overlay.classList.remove('open');
        }
    }

    // Show hamburger toggle on mobile
    function updateResponsive() {
        const toggle = document.getElementById('sidebarToggle');
        if (toggle) {
            if (window.innerWidth <= 768) {
                toggle.style.display = 'block';
            } else {
                toggle.style.display = 'none';
                closeSidebar();
            }
        }
    }

    // Call on page load and window resize
    updateResponsive();
    window.addEventListener('resize', updateResponsive);
    
    // Initialize sidebar state
    const initSidebar = document.getElementById('sidebar');
    if (initSidebar) {
        console.log('Sidebar initialized - has closed class:', initSidebar.classList.contains('closed'));
        console.log('Sidebar classes:', initSidebar.className);
    }

    // Close sidebar when clicking on a link (mobile only)
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                setTimeout(closeSidebar, 150);
            }
        });
    });

    // Close sidebar when clicking overlay
    const overlay = document.getElementById('sidebarOverlay');
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Close sidebar on window resize if back to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && sidebarOpen) {
            closeSidebar();
        }
    });

    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });
</script>

</body>
</html>

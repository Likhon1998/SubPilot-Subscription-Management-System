@extends('layouts.frontend.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #e6e6fa 0%, #d8bfd8 100%);
        border-radius: 20px;
        padding: 48px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }
    
    .dashboard-header::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(186, 85, 211, 0.15) 0%, transparent 70%);
        top: -100px;
        right: -100px;
        border-radius: 50%;
    }
    
    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
        color: #805ad5;
        margin-bottom: 16px;
        border: 1px solid rgba(186, 85, 211, 0.2);
    }
    
    .dashboard-title {
        font-size: 42px;
        font-weight: 700;
        color: #553c9a;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }
    
    .dashboard-subtitle {
        font-size: 16px;
        color: #805ad5;
        font-weight: 400;
    }
    
    .user-name {
        color: #6b46c1;
        font-weight: 600;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 4px 20px rgba(138, 43, 226, 0.08);
        border: 1px solid rgba(216, 191, 216, 0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #ba55d3 0%, #9370db 100%);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(138, 43, 226, 0.15);
    }
    
    .stat-icon {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #e6e6fa 0%, #d8bfd8 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    
    .stat-icon svg {
        width: 26px;
        height: 26px;
        color: #805ad5;
    }
    
    .stat-title {
        font-size: 13px;
        color: #9f7aea;
        font-weight: 500;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #553c9a;
        margin-bottom: 4px;
    }
    
    .stat-description {
        font-size: 13px;
        color: #b794f4;
    }
    
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(138, 43, 226, 0.08);
        border: 1px solid rgba(216, 191, 216, 0.2);
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #553c9a;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }
    
    .action-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        background: linear-gradient(135deg, #f8f4ff 0%, #f3e8ff 100%);
        border: 1.5px solid rgba(159, 122, 234, 0.3);
        border-radius: 12px;
        color: #6b46c1;
        font-weight: 500;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        background: linear-gradient(135deg, #ba55d3 0%, #9370db 100%);
        color: white;
        transform: translateX(4px);
        border-color: transparent;
        box-shadow: 0 4px 16px rgba(186, 85, 211, 0.3);
    }
    
    .action-btn svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .dashboard-header {
        animation: fadeInUp 0.5s ease;
    }
    
    .stat-card {
        animation: fadeInUp 0.5s ease;
        animation-fill-mode: both;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    
    .quick-actions {
        animation: fadeInUp 0.5s ease 0.4s;
        animation-fill-mode: both;
    }
</style>

<div class="container py-5">
    <div class="dashboard-header">
        <div class="welcome-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Admin Account
        </div>
        <h1 class="dashboard-title">Welcome back, <span class="user-name">{{ auth()->user()->name }}</span></h1>
        <p class="dashboard-subtitle">Here's what's happening with your SubPilot platform today</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-title">Total Users</div>
            <div class="stat-value">2,547</div>
            <div class="stat-description">↑ 12% from last month</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
            </div>
            <div class="stat-title">Active Subscriptions</div>
            <div class="stat-value">1,832</div>
            <div class="stat-description">↑ 8% from last month</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div class="stat-title">System Status</div>
            <div class="stat-value">98.7%</div>
            <div class="stat-description">Uptime this month</div>
        </div>
    </div>

    <div class="quick-actions">
        <h2 class="section-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                <polyline points="2 17 12 22 22 17"/>
                <polyline points="2 12 12 17 22 12"/>
            </svg>
            Quick Actions
        </h2>
        <div class="action-grid">
            <a href="#" class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Manage Users
            </a>
            <a href="#" class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
                Subscriptions
            </a>
            <a href="#" class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
                Settings
            </a>
            <a href="#" class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
                Revenue Reports
            </a>
            <a href="#" class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
                System Logs
            </a>
            <a href="#" class="action-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                Notifications
            </a>
        </div>
    </div>
</div>
@endsecti
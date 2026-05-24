@extends('admin.master')

@section('main-content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap');

    .logout-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Plus Jakarta Sans', 'Noto Sans Bengali', sans-serif;
    }

    .logout-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        max-width: 500px;
        width: 100%;
        padding: 60px 40px;
        text-align: center;
        animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .logout-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 30px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: white;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        animation: bounce 0.6s ease-out;
    }

    @keyframes bounce {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }

    .logout-title {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 15px;
        letter-spacing: -0.5px;
    }

    .logout-subtitle {
        font-size: 16px;
        color: #64748b;
        margin: 0 0 30px;
        font-weight: 500;
        line-height: 1.6;
    }

    .user-info {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #e2e8f0;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        font-weight: 700;
        flex-shrink: 0;
    }

    .user-details {
        text-align: left;
    }

    .user-name {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 3px;
    }

    .user-role {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    .logout-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-logout {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        flex: 1;
    }

    .btn-logout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        border: 2px solid #e2e8f0;
        padding: 12px 32px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        flex: 1;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        border-color: #cbd5e1;
    }

    .logout-message {
        font-size: 13px;
        color: #64748b;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    @media (max-width: 600px) {
        .logout-container {
            padding: 40px 25px;
        }

        .logout-title {
            font-size: 26px;
        }

        .logout-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="logout-page">
    <div class="logout-container">
        <div class="logout-icon">
            <i class="bi bi-power"></i>
        </div>

        <h1 class="logout-title">আপনি কি নিশ্চিত?</h1>
        <p class="logout-subtitle">আপনি লগআউট করতে চলেছেন। আপনার সেশন বন্ধ হয়ে যাবে।</p>

        <div class="user-info">
            <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div class="user-details">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">প্রশাসক</div>
            </div>
        </div>

        <div class="logout-buttons">
            <form method="POST" action="{{ route('admin.logout.confirm') }}" style="flex: 1;">
                @csrf
                <button type="submit" class="btn-logout" style="width: 100%;">
                    <i class="bi bi-power"></i> হ্যাঁ, লগআউট করুন
                </button>
            </form>
            <a href="{{ route('admin.dashboard') }}" class="btn-cancel">
                <i class="bi bi-arrow-left"></i> বাতিল করুন
            </a>
        </div>

        <div class="logout-message">
            <i class="bi bi-info-circle me-1"></i> আপনি পরে আবার লগইন করতে পারবেন।
        </div>
    </div>
</div>
@endsection

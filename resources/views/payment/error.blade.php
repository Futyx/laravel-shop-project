<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>خطا در پرداخت - چیزمارت</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #000;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 600px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            background: #ef4444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease-out;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }
        
        .error-icon svg {
            width: 60px;
            height: 60px;
            stroke: #000;
            stroke-width: 2;
            fill: none;
        }
        
        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #ef4444;
            font-weight: 600;
        }
        
        .message {
            font-size: 1.1rem;
            margin-bottom: 40px;
            color: #e5e7eb;
            line-height: 1.8;
        }
        
        .error-box {
            background: #111;
            border: 1px solid #ef4444;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            text-align: right;
        }
        
        .error-message {
            color: #fca5a5;
            font-size: 1rem;
            line-height: 1.8;
            word-wrap: break-word;
        }
        
        .info-text {
            color: #9ca3af;
            font-size: 0.95rem;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #1f2937;
        }
        
        .actions {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .btn-primary {
            background: #ef4444;
            color: #fff;
        }
        
        .btn-primary:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            color: #fff;
            border-color: #374151;
        }
        
        .btn-secondary:hover {
            border-color: #ef4444;
            color: #ef4444;
        }
        
        @media (max-width: 640px) {
            h1 {
                font-size: 1.5rem;
            }
            
            .message {
                font-size: 1rem;
            }
            
            .error-box {
                padding: 20px;
            }
            
            .error-message {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-icon">
            <svg viewBox="0 0 24 24">
                <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        
        <h1>خطا در پرداخت</h1>
        
        <p class="message">
            متأسفانه پرداخت شما با خطا مواجه شد. لطفاً دوباره تلاش کنید یا با پشتیبانی تماس بگیرید.
        </p>
        
        <div class="error-box">
            <div class="error-message">
                {{ $message ?? 'خطای نامشخص در پرداخت' }}
            </div>
            
            <div class="info-text">
                <p>در صورت کسر وجه از حساب شما، مبلغ طی ۲۴ تا ۷۲ ساعت به حساب شما بازگردانده می‌شود.</p>
                <p style="margin-top: 10px;">برای پیگیری بیشتر با شماره <strong>09022593643</strong> تماس بگیرید.</p>
            </div>
        </div>
        
        <div class="actions">
            <a href="{{ route('cart.index') }}" class="btn btn-primary">تلاش مجدد</a>
            <a href="{{ route('home') }}" class="btn btn-secondary">بازگشت به صفحه اصلی</a>
        </div>
    </div>
</body>
</html>


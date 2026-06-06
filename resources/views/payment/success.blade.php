<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پرداخت موفق - چیزمارت</title>
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
        
        .success-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            background: #10b981;
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
        
        .success-icon svg {
            width: 60px;
            height: 60px;
            stroke: #000;
            stroke-width: 2;
            fill: none;
        }
        
        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #10b981;
            font-weight: 600;
        }
        
        .message {
            font-size: 1.1rem;
            margin-bottom: 40px;
            color: #e5e7eb;
        }
        
        .info-box {
            background: #111;
            border: 1px solid #10b981;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            text-align: right;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #1f2937;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            color: #9ca3af;
            font-size: 0.95rem;
        }
        
        .info-value {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            font-family: 'Courier New', monospace;
            direction: ltr;
            text-align: left;
        }
        
        .tracking-code {
            color: #10b981;
            font-size: 1.3rem;
            font-weight: 700;
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
            background: #10b981;
            color: #000;
        }
        
        .btn-primary:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            color: #fff;
            border-color: #374151;
        }
        
        .btn-secondary:hover {
            border-color: #10b981;
            color: #10b981;
        }
        
        @media (max-width: 640px) {
            h1 {
                font-size: 1.5rem;
            }
            
            .message {
                font-size: 1rem;
            }
            
            .info-box {
                padding: 20px;
            }
            
            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .info-value {
                font-size: 1rem;
            }
            
            .tracking-code {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24">
                <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        
        <h1>پرداخت با موفقیت انجام شد</h1>
        
        <p class="message">
            سفارش شما با موفقیت ثبت و پرداخت شد. کد پیگیری سفارش خود را یادداشت کنید.
        </p>
        
        <div class="info-box">
            @if(isset($trackingCode))
            <div class="info-row">
                <span class="info-label">کد پیگیری سفارش:</span>
                <span class="info-value tracking-code">{{ $trackingCode }}</span>
            </div>
            @endif
            
            @if(isset($refId))
            <div class="info-row">
                <span class="info-label">شماره تراکنش:</span>
                <span class="info-value">{{ $refId }}</span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="info-label">وضعیت:</span>
                <span class="info-value" style="color: #10b981;">پرداخت شده</span>
            </div>
        </div>
        
        <div class="actions">
            <a href="{{ route('home') }}" class="btn btn-primary">بازگشت به صفحه اصلی</a>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">مشاهده سفارشات من</a>
        </div>
    </div>
</body>
</html>



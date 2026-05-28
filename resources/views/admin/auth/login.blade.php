<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন লগইন | দৈনিক ভোলা টাইমস্</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-bg: #f8fafc;     /* Soft slate light background */
            --card-bg: #ffffff;        /* Clean white card */
            --accent: #dc2626;         /* Crimson Accent */
            --accent-hover: #b91c1c;
            --text-main: #334155;      /* Dark slate gray */
            --text-sub: #64748b;       /* Muted slate */
            --border-color: #e2e8f0;   /* Light gray borders */
            --radius: 16px;
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Noto Sans Bengali', 'Outfit', sans-serif;
            background-color: var(--primary-bg);
            background-image: 
                radial-gradient(at 10% 20%, rgba(220, 38, 38, 0.05) 0px, transparent 50%),
                radial-gradient(at 90% 80%, rgba(203, 213, 225, 0.3) 0px, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            padding: 24px;
        }

        /* Glassmorphic Login Container */
        .login-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            width: 100%;
            max-width: 440px;
            padding: 40px;
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
            animation: fadeIn 0.8s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-logo {
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: -1px;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .brand-logo span {
            color: var(--accent);
        }

        .brand-subtitle {
            font-size: 0.95rem;
            color: var(--text-sub);
            letter-spacing: 1px;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-sub);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-input {
            width: 100%;
            padding: 12px 16px 12px 42px;
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-main);
            font-size: 0.95rem;
            outline: none;
            transition: var(--transition);
            font-family: inherit;
        }
 
        .form-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
            background-color: #ffffff;
        }

        .form-input:focus + .input-icon {
            color: var(--accent);
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            font-size: 0.85rem;
            color: var(--text-sub);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input {
            cursor: pointer;
            accent-color: var(--accent);
        }

        .forgot-link:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        /* Button */
        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: var(--accent);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .submit-btn:hover {
            background-color: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(220, 38, 38, 0.45);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Errors Alert */
        .error-alert {
            background-color: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-home-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            font-size: 0.85rem;
            color: var(--text-sub);
        }

        .back-home-link:hover {
            color: var(--accent);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-header">
            <h1 class="brand-logo">Times<span>Panel</span></h1>
            <p class="brand-subtitle">নিউজপেপার কন্ট্রোল ড্যাশবোর্ড</p>
        </div>

        @if($errors->any())
            <div class="error-alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <!-- Email Field -->
            <div class="form-group">
                <label for="email" class="form-label">ইমেইল ঠিকানা</label>
                <div class="input-wrapper">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@example.com" class="form-input">
                    <i class="fa-solid fa-envelope input-icon"></i>
                </div>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">গোপন পাসওয়ার্ড</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="••••••••" class="form-input">
                    <i class="fa-solid fa-lock input-icon"></i>
                </div>
            </div>

            <!-- Remember Me options -->
            <div class="options-row">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <span>আমাকে মনে রাখুন</span>
                </label>
                <a href="#" class="forgot-link">পাসওয়ার্ড ভুলে গেছেন?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                <span>লগইন করুন</span>
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-home-link">
            <i class="fa-solid fa-angle-left"></i> মূল ওয়েবসাইটে ফিরে যান
        </a>
    </div>

</body>
</html>

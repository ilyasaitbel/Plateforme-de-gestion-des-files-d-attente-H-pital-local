<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HôpitalFile — Gestion des Files d'Attente</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --accent: #16a085;
            --dark: #1f2d3d;
            --dark-soft: #34495e;
            --light: #f4f6f8;
            --white: #ffffff;
            --muted: #6b7280;
            --border: #dce6ee;
            --danger-bg: #fdecea;
            --danger-text: #c0392b;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--light);
            color: #333;
        }

        body.modal-open {
            overflow: hidden;
        }

        nav {
            position: absolute;
            width: 100%;
            z-index: 10;
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .logo {
            color: #fff;
            font-size: 22px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        nav .logo span {
            color: #7dd3fc;
        }

        .logo-mark {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: linear-gradient(135deg, #cdeeff, #69a9ff);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(105, 169, 255, 0.28);
            flex-shrink: 0;
        }

        .logo-mark svg {
            width: 29px;
            height: 29px;
        }

        nav .nav-links {
            display: flex;
            gap: 12px;
        }

        nav .nav-links button {
            padding: 9px 20px;
            border-radius: 999px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.25s ease;
        }

        nav .btn-login {
            border: 1px solid #fff;
            color: #fff;
            background: transparent;
        }

        nav .btn-login:hover {
            background: #fff;
            color: #2c3e50;
        }

        nav .btn-register {
            background: var(--primary);
            border: 1px solid var(--primary);
            color: #fff;
        }

        nav .btn-register:hover {
            background: var(--primary-dark);
        }

        .hero {
            height: 100vh;
            background-image: url('https://d2fi3g03kp79b8.cloudfront.net/uploads/Smart_Patient_Journey_Hero_Banner_FR_63b4e8e9ef.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            padding: 80px 40px;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.78), rgba(12, 74, 110, 0.55));
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: #fff;
            max-width: 760px;
        }

        .hero-badge {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 18px;
            border-radius: 999px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.16);
            font-size: 14px;
        }

        .hero h1 {
            font-size: 52px;
            font-weight: bold;
            margin-bottom: 20px;
            line-height: 1.15;
        }

        .hero h1 span {
            color: #f1c40f;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.92;
            line-height: 1.8;
        }

        .hero-actions {
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-hero,
        .btn-hero-secondary {
            display: inline-block;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 999px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            transition: 0.25s ease;
        }

        .btn-hero {
            background: var(--primary);
            color: white;
            box-shadow: 0 12px 30px rgba(52, 152, 219, 0.25);
        }

        .btn-hero:hover {
            background: var(--primary-dark);
        }

        .btn-hero-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.28);
        }

        .btn-hero-secondary:hover {
            background: rgba(255,255,255,0.2);
        }

        .features {
            padding: 70px 40px;
            max-width: 1140px;
            margin: 0 auto;
        }

        .features h2 {
            text-align: center;
            font-size: 30px;
            color: #2c3e50;
            margin-bottom: 40px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 24px;
        }

        .feature-card {
            background: #fff;
            border-radius: 18px;
            padding: 28px 24px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            border: 1px solid #edf2f7;
        }

        .feature-card .icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 14px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eaf5ff, #d6ecff);
            border: 1px solid #cfe3f6;
            box-shadow: 0 10px 24px rgba(52, 152, 219, 0.14);
            overflow: hidden;
        }

        .feature-card .icon img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .feature-card h3 {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 14px;
            color: #777;
            line-height: 1.7;
        }

        .cta {
            background: linear-gradient(135deg, #22313f, #2c3e50);
            color: #fff;
            padding: 70px 40px;
        }

        .cta-inner {
            max-width: 1140px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: minmax(280px, 1fr) minmax(300px, 420px);
            gap: 36px;
            align-items: center;
        }

        .cta-copy h2 {
            font-size: 42px;
            margin-bottom: 14px;
            line-height: 1.2;
        }

        .cta-copy p {
            font-size: 17px;
            margin-bottom: 18px;
            opacity: 0.92;
            line-height: 1.8;
        }

        .cta-points {
            list-style: none;
            display: grid;
            gap: 12px;
        }

        .cta-points li {
            font-size: 15px;
            opacity: 0.95;
        }

        footer {
            background: #1a252f;
            color: #aaa;
            text-align: center;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: linear-gradient(180deg, #f8fdff 0%, #e9f7ff 100%);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(40, 122, 186, 0.28);
            border: 1px solid rgba(125, 211, 252, 0.55);
            animation: cardIn 0.25s ease;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(16px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .auth-card-header {
            background: linear-gradient(135deg, #dff4ff, #bfe8ff);
            padding: 26px 24px 18px;
            text-align: center;
            border-bottom: 1px solid #cfefff;
        }

        .brand-icon {
            width: 74px;
            height: 74px;
            margin: 0 auto 14px;
            border-radius: 22px;
            display: block;
            object-fit: cover;
            background: #fff;
            padding: 10px;
            box-shadow: 0 12px 28px rgba(52, 152, 219, 0.22);
        }

        .auth-card-header h3 {
            font-size: 28px;
            color: var(--dark);
            margin-bottom: 6px;
        }

        .auth-card-header p {
            color: var(--muted);
            font-size: 14px;
        }

        .tabs {
            display: flex;
            gap: 10px;
            padding: 14px 14px 0;
            background: transparent;
        }

        .tab-btn {
            flex: 1;
            border: none;
            border-radius: 14px;
            padding: 13px;
            font-size: 14px;
            font-weight: bold;
            color: var(--dark-soft);
            background: #d9f0ff;
            cursor: pointer;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            color: #fff;
            box-shadow: 0 10px 22px rgba(14, 165, 233, 0.28);
        }

        .form-panel {
            padding: 26px 28px 30px;
            background: rgba(255, 255, 255, 0.55);
        }

        .form {
            display: none;
        }

        .form.active {
            display: block;
        }

        .alert {
            background: var(--danger-bg);
            color: var(--danger-text);
            border: 1px solid #f5c6cb;
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .success {
            background: #eafaf1;
            color: #0f8a5f;
            border: 1px solid #bce9d1;
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark);
            font-size: 14px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #bfe8ff;
            border-radius: 14px;
            font-size: 14px;
            outline: none;
            transition: 0.2s ease;
            background: rgba(255, 255, 255, 0.92);
        }

        .form-control:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.18);
            background: #fff;
        }

        .btn-submit {
            width: 100%;
            border: none;
            padding: 15px;
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            color: #fff;
            font-size: 15px;
            font-weight: bold;
            border-radius: 14px;
            cursor: pointer;
            margin-top: 6px;
            box-shadow: 0 12px 24px rgba(14, 165, 233, 0.24);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
        }

        .switch-note {
            text-align: center;
            margin-top: 16px;
            font-size: 13px;
            color: var(--muted);
        }

        .switch-note button {
            border: none;
            background: none;
            color: var(--primary);
            font-weight: bold;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            nav {
                padding: 16px 18px;
                flex-direction: column;
                gap: 12px;
            }

            .hero {
                padding: 120px 20px 60px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 16px;
            }

            .features,
            .cta {
                padding-left: 20px;
                padding-right: 20px;
            }

            .cta-inner {
                grid-template-columns: 1fr;
            }

            .cta-copy {
                text-align: center;
            }

            .cta-points {
                justify-items: center;
            }
        }

        @media (max-width: 520px) {
            .hero-actions,
            .tabs {
                flex-direction: column;
            }

            .auth-card-header,
            .form-panel {
                padding-left: 18px;
                padding-right: 18px;
            }
        }
    </style>
</head>

<body data-auth-mode="{{ session('authMode', $authMode ?? '') }}" data-auth-error="{{ $errors->any() || session('error') ? '1' : '0' }}">

<nav>
    <div class="logo">🏥HôpitalFile</div>
    <div class="nav-links">
        <button type="button" class="btn-login" onclick="scrollToAuth('login')">Connexion</button>
        <button type="button" class="btn-register" onclick="scrollToAuth('register')">S'inscrire</button>
    </div>
</nav>

<div class="hero">
    <div class="hero-content">
        <div class="hero-badge">Plateforme moderne pour l’organisation hospitalière</div>
        <h1>Optimisez la gestion des <span>files d’attente</span> hospitalières</h1>
        <p>
            Système moderne permettant de gérer efficacement les files d’attente,
            réduire le temps d’attente et améliorer l’organisation des services hospitaliers.
        </p>
        <div class="hero-actions">
            <button type="button" class="btn-hero" onclick="scrollToAuth('register')">Commencer maintenant</button>
            <button type="button" class="btn-hero-secondary" onclick="scrollToAuth('login')">Se connecter</button>
        </div>
    </div>
</div>

<div class="features">
    <h2>Pourquoi choisir HôpitalFile ?</h2>

    <div class="features-grid">
        <div class="feature-card">
            <div class="icon">
                <img src="https://img.icons8.com/color/96/ticket.png" alt="Ticket en ligne">
            </div>
            <h3>Ticket en ligne</h3>
            <p>Prenez votre ticket depuis chez vous avec une expérience simple et rapide.</p>
        </div>

        <div class="feature-card">
            <div class="icon">
                <img src="https://img.icons8.com/color/96/combo-chart--v1.png" alt="Suivi en temps réel">
            </div>
            <h3>Suivi en temps réel</h3>
            <p>Suivez votre position dans la file et l’état global du service.</p>
        </div>

        <div class="feature-card">
            <div class="icon">
                <img src="https://img.icons8.com/color/96/stopwatch.png" alt="Gain de temps">
            </div>
            <h3>Gain de temps</h3>
            <p>Réduisez les temps d’attente grâce à une meilleure organisation.</p>
        </div>

    </div>
</div>

<div class="cta" id="auth-section">
    <div class="cta-inner">
        <div class="cta-copy">
            <h2>Prêt à commencer ?</h2>
            <p>Le formulaire de connexion et d’inscription est maintenant disponible directement ici, sans popup, pour un accès plus rapide.</p>
            <ul class="cta-points">
                <li>✓ Inscription rapide en quelques secondes</li>
                <li>✓ Connexion directe depuis la page d’accueil</li>
                <li>✓ Accès immédiat à votre espace personnel</li>
            </ul>
        </div>

        <div class="auth-card">
            <div class="auth-card-header">
                <img class="brand-icon" src="https://img.icons8.com/color/96/clinic.png" alt="Logo HôpitalFile">
                <h3>HôpitalFile</h3>
                <p>Connexion et inscription directement depuis la page d’accueil</p>
            </div>

            <div class="tabs">
                <button type="button" class="tab-btn active" id="loginTabBtn" onclick="showAuthForm('login')">Connexion</button>
                <button type="button" class="tab-btn" id="registerTabBtn" onclick="showAuthForm('register')">Inscription</button>
            </div>

            <div class="form-panel">
                <div class="form active" id="loginForm">
                    @if(session('error'))
                        <div class="alert">{{ session('error') }}</div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com" value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" placeholder="********">
                        </div>

                        <button type="submit" class="btn-submit">Se connecter</button>
                    </form>

                    <div class="switch-note">
                        Pas encore de compte ?
                        <button type="button" onclick="showAuthForm('register')">Créer un compte</button>
                    </div>
                </div>

                <div class="form" id="registerForm">
                    @if($errors->any() && session('authMode') === 'register')
                        <div class="alert">{{ $errors->first() }}</div>
                    @endif

                    <form action="/register" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="name" class="form-control" placeholder="Nom complet" value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com" value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" placeholder="********">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirmer mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="********">
                        </div>

                        <button type="submit" class="btn-submit">Créer un compte</button>
                    </form>

                    <div class="switch-note">
                        Vous avez déjà un compte ?
                        <button type="button" onclick="showAuthForm('login')">Se connecter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    &copy; {{ date('Y') }} HôpitalFile — Tous droits réservés.
</footer>

<script>
    const body = document.body;
    const initialAuthMode = body.dataset.authMode;
    const hasAuthError = body.dataset.authError === '1';

    function showAuthForm(mode) {
        const isRegister = mode === 'register';

        document.getElementById('loginForm').classList.toggle('active', !isRegister);
        document.getElementById('registerForm').classList.toggle('active', isRegister);

        document.getElementById('loginTabBtn').classList.toggle('active', !isRegister);
        document.getElementById('registerTabBtn').classList.toggle('active', isRegister);
    }

    function scrollToAuth(mode = 'login') {
        showAuthForm(mode);
        document.getElementById('auth-section').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    if (initialAuthMode === 'register') {
        showAuthForm('register');
        document.getElementById('auth-section').scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else if (initialAuthMode === 'login' || hasAuthError) {
        showAuthForm('login');
        document.getElementById('auth-section').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
</script>

</body>
</html>

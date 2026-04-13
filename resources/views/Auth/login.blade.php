<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HôpitalFile — Auth</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #1e88e5;
            --primary-dark: #1565c0;
            --accent: #22c55e;
            --text-dark: #1f2937;
            --text-soft: #6b7280;
            --white: #ffffff;
            --border: #dbe5ef;
            --danger-bg: #fdecea;
            --danger-text: #c0392b;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            background: #eef3f8;
        }

        nav {
            position: absolute;
            inset: 0 0 auto 0;
            z-index: 20;
            padding: 18px 42px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: var(--white);
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo span {
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

        .nav-links {
            display: flex;
            gap: 12px;
        }

        .nav-links button {
            padding: 10px 20px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.25s ease;
        }

        .btn-login {
            background: transparent;
            color: var(--white);
            border: 1px solid rgba(255,255,255,0.75);
        }

        .btn-login:hover,
        .btn-login.active {
            background: var(--white);
            color: #12344d;
        }

        .btn-register {
            background: var(--primary);
            color: var(--white);
            border: 1px solid var(--primary);
            box-shadow: 0 8px 20px rgba(30, 136, 229, 0.22);
        }

        .btn-register:hover,
        .btn-register.active {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .hero {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 120px 24px 50px;
            background-image: url('https://d2fi3g03kp79b8.cloudfront.net/uploads/Smart_Patient_Journey_Hero_Banner_FR_63b4e8e9ef.jpg');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, rgba(7, 28, 48, 0.82), rgba(8, 43, 70, 0.55));
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            right: -120px;
            bottom: -120px;
            background: radial-gradient(circle, rgba(34, 197, 94, 0.25), transparent 70%);
        }

        .auth-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1180px;
            display: grid;
            grid-template-columns: 1.15fr 460px;
            gap: 44px;
            align-items: center;
        }

        .hero-content {
            color: var(--white);
            max-width: 680px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.16);
            padding: 10px 16px;
            border-radius: 999px;
            margin-bottom: 22px;
            font-size: 14px;
            backdrop-filter: blur(8px);
        }

        .hero-content h1 {
            font-size: 54px;
            line-height: 1.1;
            margin-bottom: 18px;
            font-weight: 800;
        }

        .hero-content h1 span {
            color: #facc15;
        }

        .hero-content p {
            font-size: 18px;
            line-height: 1.8;
            opacity: 0.95;
            margin-bottom: 28px;
            max-width: 620px;
        }

        .hero-points {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .hero-points li {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 18px;
            padding: 16px;
            font-size: 15px;
            line-height: 1.5;
            backdrop-filter: blur(8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        .auth-card {
            background: rgba(255,255,255,0.96);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(0,0,0,0.22);
            border: 1px solid rgba(255,255,255,0.65);
        }

        .auth-card-header {
            padding: 34px 32px 22px;
            background: linear-gradient(135deg, #f8fbff, #edf6ff);
            text-align: center;
            border-bottom: 1px solid #e6edf5;
        }

        .brand-icon {
            width: 62px;
            height: 62px;
            margin: 0 auto 16px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary), #4fc3f7);
            color: var(--white);
            font-size: 28px;
            box-shadow: 0 14px 28px rgba(30, 136, 229, 0.24);
        }

        .auth-card-header h2 {
            font-size: 30px;
            margin-bottom: 8px;
            color: #17324d;
        }

        .auth-card-header p {
            color: var(--text-soft);
            font-size: 14px;
        }

        .tabs {
            display: flex;
            gap: 10px;
            padding: 12px 14px 0;
            background: #fff;
        }

        .tab-btn {
            flex: 1;
            border: none;
            background: #f3f7fb;
            padding: 13px;
            border-radius: 14px;
            font-weight: 700;
            color: #4b5e71;
            cursor: pointer;
            transition: 0.25s ease;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, var(--primary), #42a5f5);
            color: var(--white);
            box-shadow: 0 10px 22px rgba(30, 136, 229, 0.2);
        }

        .form-panel {
            padding: 26px 30px 32px;
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
            padding: 13px 14px;
            border-radius: 12px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 17px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #2b4257;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid var(--border);
            border-radius: 14px;
            font-size: 14px;
            outline: none;
            background: #fbfdff;
            transition: 0.25s ease;
        }

        .form-control:focus {
            border-color: #90caf9;
            box-shadow: 0 0 0 4px rgba(30, 136, 229, 0.12);
            background: #fff;
        }

        .btn-submit {
            width: 100%;
            border: none;
            padding: 15px;
            margin-top: 6px;
            background: linear-gradient(135deg, var(--primary), #42a5f5);
            color: var(--white);
            font-size: 15px;
            font-weight: 700;
            border-radius: 14px;
            cursor: pointer;
            box-shadow: 0 14px 28px rgba(30, 136, 229, 0.22);
            transition: transform 0.2s ease, box-shadow 0.25s ease;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(30, 136, 229, 0.28);
        }

        .bottom-note {
            text-align: center;
            margin-top: 18px;
            font-size: 13px;
            color: var(--text-soft);
        }

        .bottom-note strong {
            color: var(--primary);
        }

        @media (max-width: 1024px) {
            .auth-wrapper {
                grid-template-columns: 1fr;
            }

            .hero-content {
                margin: 0 auto;
                text-align: center;
            }

            .hero-points {
                text-align: left;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 18px 18px;
                flex-direction: column;
                gap: 12px;
            }

            .hero {
                padding: 150px 16px 36px;
            }

            .hero-content h1 {
                font-size: 38px;
            }

            .hero-points {
                grid-template-columns: 1fr;
            }

            .auth-card-header,
            .form-panel {
                padding-left: 20px;
                padding-right: 20px;
            }
        }

        @media (max-width: 520px) {
            .tabs {
                flex-direction: column;
            }

            .hero-content h1 {
                font-size: 32px;
            }

            .hero-content p {
                font-size: 16px;
            }
        }
    </style>
</head>

<body data-show-register="{{ $errors->any() && session('register') ? '1' : '0' }}">

<nav>
    <div class="logo">🏥HôpitalFile</div>
    <div class="nav-links">
        <button class="btn-login active" id="navLoginBtn" type="button" onclick="showForm('login')">Connexion</button>
        <button class="btn-register" id="navRegisterBtn" type="button" onclick="showForm('register')">S'inscrire</button>
    </div>
</nav>

<section class="hero">
    <div class="auth-wrapper">
        <div class="hero-content">
            <div class="badge">✨ Plateforme intelligente pour les files d’attente hospitalières</div>

            <h1>Bienvenue sur <span>HôpitalFile</span></h1>

            <p>
                Gérez les rendez-vous, les tickets et les files d’attente avec une expérience moderne,
                claire et professionnelle pensée pour les citoyens, les agents et l’administration.
            </p>

            <ul class="hero-points">
                <li>🎫 Réservation rapide des tickets et meilleure organisation des passages</li>
                <li>📊 Vue claire sur l’activité, les services et les files en temps réel</li>
                <li>⚡ Accès rapide aux services et aux tickets sans complexité</li>
                <li>🏥 Interface adaptée aux besoins des hôpitaux, agents et citoyens</li>
            </ul>
        </div>

        <div class="auth-card">
            <div class="auth-card-header">
                <div class="brand-icon">✚</div>
                <h2>HôpitalFile</h2>
                <p>Connectez-vous ou créez un compte en quelques secondes</p>
            </div>

            <div class="tabs">
                <button class="tab-btn active" id="tabLoginBtn" type="button" onclick="showForm('login')">Connexion</button>
                <button class="tab-btn" id="tabRegisterBtn" type="button" onclick="showForm('register')">Inscription</button>
            </div>

            <div class="form-panel">
                <div class="form active" id="loginForm">
                    @if($errors->any() && !session('register'))
                        <div class="alert">{{ $errors->first() }}</div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" placeholder="********">
                        </div>

                        <button class="btn-submit" type="submit">Se connecter</button>
                    </form>

                    <div class="bottom-note">
                        Pas encore de compte ? <strong>Utilisez l’onglet inscription</strong>.
                    </div>
                </div>

                <div class="form" id="registerForm">
                    @if($errors->any() && session('register'))
                        <div class="alert">{{ $errors->first() }}</div>
                    @endif

                    <form action="/register" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="name" class="form-control" placeholder="Nom complet">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@example.com">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" placeholder="********">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirmer mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="********">
                        </div>

                        <button class="btn-submit" type="submit">Créer un compte</button>
                    </form>

                    <div class="bottom-note">
                        Vous avez déjà un compte ? <strong>Revenez à la connexion</strong>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const shouldShowRegister = document.body.dataset.showRegister === '1';

function showForm(type) {
    const isRegister = type === 'register';

    document.getElementById('loginForm').classList.toggle('active', !isRegister);
    document.getElementById('registerForm').classList.toggle('active', isRegister);

    document.getElementById('tabLoginBtn').classList.toggle('active', !isRegister);
    document.getElementById('tabRegisterBtn').classList.toggle('active', isRegister);

    document.getElementById('navLoginBtn').classList.toggle('active', !isRegister);
    document.getElementById('navRegisterBtn').classList.toggle('active', isRegister);
}

if (shouldShowRegister) {
    showForm('register');
}
</script>

</body>
</html>

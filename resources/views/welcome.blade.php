<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HôpitalFile — Gestion des Files d'Attente</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f6f8; color: #333; }

        /* NAV */
        nav {
            position: absolute;
            width: 100%;
            z-index: 10;
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .logo { color: #fff; font-size: 22px; font-weight: bold; }
        nav .logo span { color: #3498db; }

        nav .nav-links { display: flex; gap: 12px; }

        nav .nav-links a {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        nav .btn-login {
            border: 1px solid #fff;
            color: #fff;
        }

        nav .btn-login:hover {
            background: #fff;
            color: #2c3e50;
        }

        nav .btn-register {
            background: #3498db;
            color: #fff;
        }

        nav .btn-register:hover {
            background: #2980b9;
        }

        /* HERO */
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
            background: rgba(0, 0, 0, 0.6);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: #fff;
            max-width: 700px;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hero h1 span {
            color: #f1c40f;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn-hero {
            display: inline-block;
            padding: 14px 36px;
            background: orange;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn-hero:hover {
            background: #e67e22;
        }

        /* FEATURES */
        .features {
            padding: 60px 40px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .features h2 {
            text-align: center;
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 40px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
        }

        .feature-card {
            background: #fff;
            border-radius: 10px;
            padding: 28px 24px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        }

        .feature-card .icon {
            font-size: 40px;
            margin-bottom: 14px;
        }

        .feature-card h3 {
            font-size: 17px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 14px;
            color: #777;
        }

        /* CTA */
        .cta {
            background: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 60px 40px;
        }

        .cta h2 {
            font-size: 28px;
            margin-bottom: 14px;
        }

        .cta p {
            font-size: 16px;
            margin-bottom: 28px;
        }

        .cta a {
            padding: 14px 36px;
            background: #3498db;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
        }

        footer {
            background: #1a252f;
            color: #aaa;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>

<body>

<nav>
    <div class="logo">🏥 Hôpital<span>File</span></div>
    <div class="nav-links">
        <a href="{{ route('login') }}" class="btn-login">Connexion</a>
        <a href="{{ route('register') }}" class="btn-register">S'inscrire</a>
    </div>
</nav>

<div class="hero">
    <div class="hero-content">
        <h1>Optimisez la gestion des files d’attente hospitalières</h1>
        <p>Système moderne permettant de gérer efficacement les files d’attente,
réduire le temps d’attente et améliorer l’organisation des services hospitaliers.</p>
        <a href="{{ route('register') }}" class="btn-hero">Commencer maintenant →</a>
    </div>
</div>

<div class="features">
    <h2>Pourquoi choisir HôpitalFile ?</h2>

    <div class="features-grid">
        <div class="feature-card">
            <div class="icon">🎫</div>
            <h3>Ticket en ligne</h3>
            <p>Prenez votre ticket depuis chez vous.</p>
        </div>

        <div class="feature-card">
            <div class="icon">📊</div>
            <h3>Suivi en temps réel</h3>
            <p>Suivez votre position dans la file.</p>
        </div>

        <div class="feature-card">
            <div class="icon">⏱️</div>
            <h3>Gain de temps</h3>
            <p>Réduisez le temps d’attente.</p>
        </div>

        <div class="feature-card">
            <div class="icon">🔔</div>
            <h3>Notifications</h3>
            <p>Recevez des alertes en temps réel.</p>
        </div>
    </div>
</div>

<div class="cta">
    <h2>Prêt à commencer ?</h2>
    <p>Rejoignez notre plateforme dès aujourd’hui.</p>
    <a href="{{ route('register') }}">Créer un compte</a>
</div>

<footer>
    &copy; {{ date('Y') }} HôpitalFile — Tous droits réservés.
</footer>

</body>
</html>
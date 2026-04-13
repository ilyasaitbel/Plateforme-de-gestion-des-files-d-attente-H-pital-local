<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediQueue — Auth</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            background: url('https://images.unsplash.com/photo-1586773860418-d37222d8fce3') no-repeat center/cover;
        }

        /* overlay */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(15,23,42,0.7);
            z-index: 0;
        }

        /* FORM */
        .auth-box {
            position: relative;
            z-index: 2;
            width: 400px;

            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);

            padding: 40px;
            border-radius: 20px;

            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
        }

        /* LOGO */
        .logo {
            text-align: center;
            margin-bottom: 25px;
            color: white;
        }

        .logo h2 {
            font-size: 24px;
            font-weight: 600;
        }

        /* TABS */
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px;
            border: none;
            background: rgba(255,255,255,0.1);
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }

        .tab-btn.active {
            background: #3b82f6;
        }

        /* FORM */
        .form {
            display: none;
        }

        .form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            color: white;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            margin-top: 5px;

            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.3);

            background: rgba(255,255,255,0.15);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.6);
        }

        /* BUTTON */
        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: #3b82f6;
            color: white;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn:hover {
            background: #2563eb;
        }

        /* ALERT */
        .alert {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        @media(max-width: 500px){
            .auth-box {
                width: 90%;
                padding: 25px;
            }
        }
    </style>
</head>

<body>

<div class="auth-box">

    <div class="logo">
        <h2>HôpitalFile</h2>
    </div>

    <div class="tabs">
        <button class="tab-btn active" onclick="showForm('login')">Connexion</button>
        <button class="tab-btn" onclick="showForm('register')">Inscription</button>
    </div>

    <!-- LOGIN -->
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

            <button class="btn">Se connecter</button>
        </form>
    </div>

    <!-- REGISTER -->
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

            <button class="btn">S'inscrire</button>
        </form>
    </div>

</div>

<script>
function showForm(type){
    document.getElementById('loginForm').classList.remove('active');
    document.getElementById('registerForm').classList.remove('active');
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

    if(type === 'login'){
        document.getElementById('loginForm').classList.add('active');
        document.querySelectorAll('.tab-btn')[0].classList.add('active');
    } else {
        document.getElementById('registerForm').classList.add('active');
        document.querySelectorAll('.tab-btn')[1].classList.add('active');
    }
}

@if($errors->any() && session('register'))
    showForm('register');
@endif
</script>

</body>
</html>
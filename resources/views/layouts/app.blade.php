<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'MediQueue')</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;

    background: linear-gradient(rgba(15,23,42,0.75), rgba(15,23,42,0.75)),
                url('https://thumbs.dreamstime.com/b/diff%C3%A9rentes-personnes-qui-attendent-dans-la-conduite-%C3%A0-l-h%C3%B4pital-et-aux-documents-de-signature-que-le-m%C3%A9decin-donne-ligne-pour-204700619.jpg?w=992') center/cover no-repeat;

    min-height: 100vh;
    color: white;
}

/* APP */
.app {
    display: flex;
}

/* SIDEBAR */
.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;

    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(15px);

    border-right: 1px solid rgba(255,255,255,0.1);
}

/* LOGO */
.sidebar-header {
    padding: 20px;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
}

/* LINKS */
.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;

    padding: 12px 20px;
    margin: 5px 10px;

    text-decoration: none;
    color: white;

    border-radius: 10px;
    transition: 0.3s;
}

.nav-link:hover {
    background: rgba(255,255,255,0.1);
}

.nav-link.active {
    background: rgba(255,255,255,0.2);
}

/* ICONS */
.nav-icon img {
    width: 20px;
    filter: brightness(0) invert(1);
}

/* MAIN */
.main {
    margin-left: 250px;
    width: 100%;
}

/* NAVBAR */
.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 15px 30px;

    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);

    border-bottom: 1px solid rgba(255,255,255,0.1);
}

/* CONTENT */
.content {
    padding: 30px;
}

/* CARD */
.card {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(15px);

    border-radius: 15px;
    padding: 20px;

    border: 1px solid rgba(255,255,255,0.1);
}

/* BUTTON */
.btn {
    padding: 8px 14px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
}

.btn-logout {
    background: #ef4444;
    color: white;
}

/* RESPONSIVE */
@media(max-width: 900px){
    .sidebar {
        display: none;
    }

    .main {
        margin-left: 0;
    }
}
</style>
</head>

<body>

<div class="app">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="sidebar-header">
            MediQueue
        </div>

        <a href="/dashboard" class="nav-link">
            <span class="nav-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828791.png">
            </span>
            Tableau de bord
        </a>

        <a href="/hospitals" class="nav-link">
            <span class="nav-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/1484/1484842.png">
            </span>
            Hôpitaux
        </a>

        <a href="/services" class="nav-link">
            <span class="nav-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/4320/4320371.png">
            </span>
            Services
        </a>

        <a href="/queues" class="nav-link">
            <span class="nav-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png">
            </span>
            Files
        </a>

        <a href="/tickets" class="nav-link">
            <span class="nav-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png">
            </span>
            Tickets
        </a>

        <a href="/agents" class="nav-link">
            <span class="nav-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png">
            </span>
            Agents
        </a>

        <a href="/citoyens" class="nav-link">
            <span class="nav-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/4140/4140047.png">
            </span>
            Citoyens
        </a>

        <a href="/notifications" class="nav-link">
            <span class="nav-icon">
                <img src="https://cdn-icons-png.flaticon.com/512/1827/1827392.png">
            </span>
            Notifications
        </a>

    </aside>

    <!-- MAIN -->
    <div class="main">

        <!-- NAVBAR -->
        <div class="topbar">
            <h3>@yield('title', 'Dashboard')</h3>

            <form method="POST" action="/logout">
                @csrf
                <button class="btn btn-logout">Déconnexion</button>
            </form>
        </div>

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>
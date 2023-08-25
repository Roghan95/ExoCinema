<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="public/css/style.css">

    <script src="public/js/script.js"></script>
    <title><?= $titre ?></title>
</head>

<body>
    <header>
        <!-- Logo -->
        <div class="logo">
            <a href="index.php?action=accueil">
                <div>
                    FLIX<span>GO</span>
                </div>
            </a>
        </div>
        <div>
            <button>Ajouter</button>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="bars">
            <path fill="#fff" d="M3,8H21a1,1,0,0,0,0-2H3A1,1,0,0,0,3,8Zm18,8H3a1,1,0,0,0,0,2H21a1,1,0,0,0,0-2Zm0-5H3a1,1,0,0,0,0,2H21a1,1,0,0,0,0-2Z"></path>
        </svg>
        <nav>
            <!-- Logo du menu burger -->
            <div class="logo_burger">
                <div>
                    FLIX<span>GO</span>
                </div>
                <i class="uil uil-times"></i>
            </div>
            <!-- Liste des liens du menu burger -->
            <ul>
                <li><a href="index.php?action=accueil">Accueil</a></li>
                <li><a href="index.php?action=listFilms">Films</a></li>
                <li><a href="index.php?action=listRole">Rôles</a></li>
                <li><a href="index.php?action=listActeurs">Acteurs</a></li>
                <li><a href="index.php?action=listGenre">Genres</a></li>
                <li><a href="index.php?action=listRealisateur">Réalisateurs</a></li>
                <li><a href="index.php?action=addGenre">Ajouter un genre</a></li>
                <li><a href="index.php?action=addRole">Ajouter un rôle</a></li>
                <li><a href="index.php?action=addRea">Ajouter un réalisateur</a></li>
                <li><a href="index.php?action=addActeur">Ajouter un acteur</a></li>
                <li><a href="index.php?action=addCasting">Ajouter un casting</a></li>
                <li><a href="index.php?action=addFilm">Ajouter Film</a></li>
            </ul>
        </nav>
        <!-- Fond obscure lorsque le menu burger est ouvert -->
        <div class="overlay"></div>
    </header>
    <?= $content ?>

</body>
</html>
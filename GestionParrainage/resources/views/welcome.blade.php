<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beno Bokk Parrainage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        /* ✅ Background Image en plein écran avec animation */
        .background-container {
            position: fixed;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/palaisp.jpg') }}") no-repeat center center;
            background-size: cover;
            opacity: 0;
            animation: fadeInBackground 2s ease-in-out forwards;
        }

        @keyframes fadeInBackground {
            from {
                opacity: 0;
                transform: scale(1.1);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ✅ Overlay pour rendre le texte lisible */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Assombrit l’image */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            opacity: 0;
            animation: fadeInOverlay 2s ease-in-out 1.5s forwards;
        }

        @keyframes fadeInOverlay {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .overlay h1 {
            font-size: 4rem;
            color: white;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .overlay p {
            font-size: 1.3rem;
            color: white;
            max-width: 800px;
            margin-top: 10px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
        }

        .cta-btn {
            background-color: #28a745;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: background 0.3s ease-in-out;
        }

        .cta-btn:hover {
            background-color: #218838;
        }

        /* ✅ Barre de navigation en haut */
        .navbar {
            position: absolute;
            top: 0;
            width: 100%;
            background: rgba(0, 123, 255, 0.8);
            padding: 1rem;
        }

        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: bold;
        }

    </style>
</head>
<body>

    <!-- ✅ Background Image -->
    <div class="background-container"></div>

    <!-- ✅ Barre de navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">🏛 Beno Bokk Parrainage</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Se connecter</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">S'inscrire</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ✅ Overlay avec description et bouton -->
    <div class="overlay">
        <h1>BENO BOKK PARRAINAGE</h1>
        <p>
            Le Sénégal est un pays indépendant depuis le 4 avril 1960. Son premier président était <strong>Léopold Sédar Senghor</strong>,
            suivi de <strong>Abdou Diouf</strong>, <strong>Abdoulaye Wade</strong>, <strong>Macky Sall</strong> et d'autres figures emblématiques.
            Aujourd'hui, le parrainage électoral est une composante essentielle du processus démocratique sénégalais.
        </p>
        <p>
            Cette plateforme est conçue pour permettre aux citoyens d'exprimer leur soutien aux candidats et de participer activement
            à la vie politique de notre pays.
        </p>

        <!-- ✅ Bouton d'inscription -->
        <a href="{{ route('register') }}" class="cta-btn">
            Pour commencer Inscris toi en cliquant ici🚀
        </a>
    </div>
    

</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Arial', sans-serif;
        }

        /* ✅ Animation du fond d'écran */
        .background-container {
            position: fixed;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/lion.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            opacity: 0;
            animation: slideInBackground 2s ease-in-out forwards;
        }

        @keyframes slideInBackground {
            from {
                opacity: 0;
                transform: translateY(-100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ✅ Overlay sombre pour améliorer la lisibilité */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Effet de transparence */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* ✅ Formulaire stylisé */
        .container {
            max-width: 400px;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            animation: fadeInForm 2s ease-in-out 1.5s forwards;
        }

        @keyframes fadeInForm {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
            font-size: 1.2rem;
            padding: 10px;
            width: 100%;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .alert {
            color: red;
            font-size: 0.9rem;
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            font-weight: bold;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- ✅ Background avec animation -->
    <div class="background-container"></div>

    <!-- ✅ Overlay sombre -->
    <div class="overlay">
        <!-- ✅ Formulaire de connexion -->
        <div class="container">
            <h1>Connexion</h1>

            @if(session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email :</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe :</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Se connecter</button>

                <a href="{{ route('register') }}" class="back-link">Pas encore inscrit ? S'inscrire</a>
            </form>
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url("{{ asset('images/senegal.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
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

    <div class="container">
        <h1>Inscription</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Numéro Carte Électeur :</label>
                <input type="text" name="numCarteElecteur" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Date de Naissance :</label>
                <input type="date" name="dateNaissance" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nom :</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Prénom :</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email :</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Téléphone :</label>
                <input type="text" name="telephone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Type Utilisateur :</label>
                <select name="type_utilisateur" class="form-select" required>
                    <option value="ELECTEUR">Électeur</option>
                    <option value="CANDIDAT">Candidat</option>
                    <option value="ADMINISTRATEUR">Administrateur</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Parti Politique (si Candidat) :</label>
                <input type="text" name="parti_politique" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe :</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmer le mot de passe :</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">S'inscrire</button>

            <a href="{{ route('login') }}" class="back-link">Déjà un compte ? Se connecter</a>
        </form>
    </div>

</body>
</html>

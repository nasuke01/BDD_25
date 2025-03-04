<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        /* Importation de la police */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #3498db, #8e44ad);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            color: #8e44ad;
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: 600;
            text-align: left;
            display: block;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 2px solid #8e44ad;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            transition: 0.3s;
        }

        input:focus, select:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.5);
        }

        button {
            background: #8e44ad;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #5e3370;
        }

        .error-messages {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            padding: 10px;
            border-left: 5px solid #e74c3c;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: left;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>

        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <label>Numéro Carte Électeur :</label>
            <input type="text" name="numCarteElecteur" required>

            <label>Date de Naissance :</label>
            <input type="date" name="dateNaissance" required>

            <label>Nom :</label>
            <input type="text" name="nom" required>

            <label>Prénom :</label>
            <input type="text" name="prenom" required>

            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Téléphone :</label>
            <input type="text" name="telephone" required>

            <label>Type Utilisateur :</label>
            <select name="type_utilisateur" required>
                <option value="ELECTEUR">Électeur</option>
                <option value="CANDIDAT">Candidat</option>
                <option value="ADMINISTRATEUR">Administrateur</option>
            </select>

            <label>Parti Politique (si Candidat) :</label>
            <input type="text" name="parti_politique">

            <label>Mot de passe :</label>
            <input type="password" name="password" required>

            <label>Confirmer le mot de passe :</label>
            <input type="password" name="password_confirmation" required>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    @if ($errors->any())
        <div style="color: red;">
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

        <label>Mot de passe :</label>
        <input type="password" name="password" required>

        <label>Confirmer le mot de passe :</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>

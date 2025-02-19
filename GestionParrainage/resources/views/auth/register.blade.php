<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <!-- ✅ Affichage du message de succès après inscription -->
    @if(session('success'))
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <label>Numéro Carte Électeur :</label>
        <input type="text" name="numCarteElecteur" required>
        <br>
        <label>Date de Naissance :</label>
        <input type="date" name="dateNaissance" required>
        <br>
        <label>Nom :</label>
        <input type="text" name="nom" required>
        <br>
        <label>Prénom :</label>
        <input type="text" name="prenom" required>
        <br>
        <label>Email :</label>
        <input type="email" name="email" required>
        <br>
        <label>Téléphone :</label>
        <input type="text" name="telephone" required>
        <br>
        <label>Type Utilisateur :</label>
        <select name="type_utilisateur" required>
            <option value="ELECTEUR">Électeur</option>
            <option value="CANDIDAT">Candidat</option>
            <option value="ADMINISTRATEUR">Administrateur</option>
        </select>
        <br>
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        <br>
        <label>Confirmer le mot de passe :</label>
        <input type="password" name="password_confirmation" required>
        <br>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>

<!-- resources/views/auth/update.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Profil</title>
</head>
<body>
    <h1>Modifier Mon Profil</h1>
    <form method="POST" action="{{ url('/user/update') }}">
        @csrf
        @method('PUT')
        <label>Nom :</label>
        <input type="text" name="nom" value="{{ auth()->user()->nom }}" required>
        <br>
        <label>Prénom :</label>
        <input type="text" name="prenom" value="{{ auth()->user()->prenom }}" required>
        <br>
        <label>Email :</label>
        <input type="email" name="email" value="{{ auth()->user()->email }}" required>
        <br>
        <label>Téléphone :</label>
        <input type="text" name="telephone" value="{{ auth()->user()->telephone }}" required>
        <br>
        <button type="submit">Sauvegarder</button>
    </form>
</body>
</html>

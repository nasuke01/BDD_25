<!-- resources/views/auth/profile.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Utilisateur</title>
</head>
<body>
    <h1>Mon Profil</h1>
    <p><strong>Nom :</strong> {{ auth()->user()->nom }}</p>
    <p><strong>Prénom :</strong> {{ auth()->user()->prenom }}</p>
    <p><strong>Email :</strong> {{ auth()->user()->email }}</p>
    <p><strong>Téléphone :</strong> {{ auth()->user()->telephone }}</p>
    <p><strong>Type :</strong> {{ auth()->user()->type_utilisateur }}</p>
    <br>
    <a href="{{ url('/user/update') }}">Modifier mon profil</a>
</body>
</html>

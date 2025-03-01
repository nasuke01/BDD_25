<!-- resources/views/profile.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
    <h1>Profil de {{ $user->nom }} {{ $user->prenom }}</h1>

    <p><strong>Email :</strong> {{ $user->email }}</p>
    <p><strong>Téléphone :</strong> {{ $user->telephone }}</p>
    <p><strong>Type d'utilisateur :</strong> {{ $user->type_utilisateur }}</p>

    <!-- ✅ Bouton de déconnexion -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Se déconnecter</button>
    </form>
</body>
</html>

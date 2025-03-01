<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des candidats</title>
</head>
<body>
    <h1>Liste des candidats</h1>

    @if(session('message'))
        <p style="color: red;">{{ session('message') }}</p>
    @endif

    @foreach ($candidats as $candidat)
        <div>
            <h3>{{ $candidat->user->nom }} {{ $candidat->user->prenom }}</h3>
            <p><strong>Parti :</strong> {{ $candidat->parti_politique ?? 'Indépendant' }}</p>
            <a href="{{ route('parrainage.form', ['id' => $candidat->id]) }}">Parrainer</a>
        </div>
    @endforeach
</body>
</html>

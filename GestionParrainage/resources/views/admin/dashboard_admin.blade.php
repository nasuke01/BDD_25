<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Admin</title>
</head>
<body>
    <h1>Tableau de Bord Administrateur</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <h3>Période de Parrainage Actuelle</h3>
    @if($periode)
        <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
        <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
    @else
        <p>Aucune période de parrainage définie.</p>
    @endif

    <!-- Bouton pour fermer le dépôt des candidatures -->
    <form method="POST" action="{{ route('admin.fermer.candidature') }}">
        @csrf
        <button type="submit" style="background-color: red; color: white;">Fermer Dépôt de Candidature</button>
    </form>

    <!-- Bouton pour fermer le parrainage -->
    <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
        @csrf
        <button type="submit" style="background-color: red; color: white;">Fermer Parrainage</button>
    </form>

    <br>

    <!-- ✅ Nouveau bouton pour rouvrir le dépôt des candidatures -->
    <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
        @csrf
        <button type="submit" style="background-color: green; color: white;">Rouvrir Dépôt de Candidature</button>
    </form>

    <!-- ✅ Nouveau bouton pour rouvrir le parrainage -->
    <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
        @csrf
        <button type="submit" style="background-color: green; color: white;">Rouvrir Parrainage</button>
    </form>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Définir la période de parrainage</title>
</head>
<body>
    <h1>Définir la période de parrainage</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('periode.store') }}">
        @csrf
        <label>Date de début :</label>
        <input type="date" name="date_debut" required>
        <br>

        <label>Date de fin :</label>
        <input type="date" name="date_fin" required>
        <br>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>

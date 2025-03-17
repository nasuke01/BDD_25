<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des candidats</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url("{{ asset('images/senegall.jpeg') }}") no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }

        /* ✅ Grid pour aligner les cartes */
        .grid-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        /* ✅ Carte de candidat */
        .card {
            background: rgba(255, 255, 255, 0.9);
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* ✅ Effet au survol */
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
        }

        .card h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .btn-parrainer {
            background-color: #28a745;
            color: white;
            font-size: 1rem;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease-in-out;
        }

        .btn-parrainer:hover {
            background-color: #218838;
        }

        .alert {
            font-size: 1rem;
            text-align: center;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Liste des candidats</h1>

        @if(session('success'))
            <p class="alert success">{{ session('success') }}</p>
        @endif

        @if(session('message'))
            <p class="alert error">{{ session('message') }}</p>
        @endif

        <!-- ✅ Grid des candidats -->
        <div class="grid-container">
            @foreach ($candidats as $candidat)
                <div class="card">
                    <h3>{{ $candidat->user->nom }} {{ $candidat->user->prenom }}</h3>
                    <p><strong>Parti :</strong> {{ $candidat->parti_politique ?? 'Indépendant' }}</p>
                    <a href="{{ route('parrainage.form', ['id' => $candidat->id]) }}" class="btn-parrainer">Parrainer</a>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des candidats</title>
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
            background: linear-gradient(135deg, #2c3e50, #8e44ad);
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        h1 {
            color: white;
            margin-bottom: 20px;
        }

        .message {
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            width: 80%;
            text-align: center;
            margin-bottom: 15px;
        }

        .success {
            background: rgba(46, 204, 113, 0.2);
            color: #27ae60;
            border-left: 5px solid #27ae60;
        }

        .error {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border-left: 5px solid #e74c3c;
        }

        .candidats-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            width: 90%;
            max-width: 1200px;
        }

        .candidat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 280px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .candidat-card:hover {
            transform: translateY(-5px);
        }

        .candidat-card h3 {
            color: #8e44ad;
            margin-bottom: 10px;
        }

        .candidat-card p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            font-size: 16px;
            color: white;
            background-color: #8e44ad;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #5e3370;
        }
    </style>
</head>
<body>
    <h1>Liste des candidats</h1>

    @if(session('success'))
        <div class="message success">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('message'))
        <div class="message error">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <div class="candidats-container">
        @foreach ($candidats as $candidat)
            <div class="candidat-card">
                <h3>{{ $candidat->user->nom }} {{ $candidat->user->prenom }}</h3>
                <p><strong>Parti :</strong> {{ $candidat->parti_politique ?? 'Indépendant' }}</p>
                <a href="{{ route('parrainage.form', ['id' => $candidat->id]) }}" class="btn">Parrainer</a>
            </div>
        @endforeach
    </div>
</body>
</html>

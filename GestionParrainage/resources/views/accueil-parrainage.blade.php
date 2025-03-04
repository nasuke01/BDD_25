<!-- resources/views/accueil-parrainage.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Parrainage</title>
    <style>
        
            body {
    font-family: Arial, sans-serif;
    text-align: center;
    margin: 50px;
    background-image: url('{{ asset('images/baobab.jpg') }}');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

        
        h1 {
            color: #e74c3c;
        }
        p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            color: white;
            background-color: #3498db;
            border: none;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1>DAGEY PARRAINER ? KAYYY WAYYY !</h1>
    
    <p>Bienvenue cher électeur. Comme vous le voyez, cette page a été conçue pour les élections.</p>
    <p>Pour procéder au parrainage, veuillez cliquer sur le bouton ci-dessous :</p>

    <!-- ✅ Bouton pour accéder à la liste des candidats -->
    <a href="{{ route('candidats.afficher') }}" class="btn">Damey Parrainer</a>
</body>
</html>

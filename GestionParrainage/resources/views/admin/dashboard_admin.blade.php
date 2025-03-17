<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Police et couleurs de base */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f7;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        /* Card container */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f5a623, #f76c6c);
            padding: 30px;
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        .card-body {
            color: #fff;
            text-align: center;
        }

        .card-body .btn {
            width: 100%;
            padding: 15px;
            font-size: 1.2rem;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .card-body .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .card-body .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-body .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .card-body .btn-danger:hover {
            background-color: #c82333;
        }

        .card-body .btn-success {
            background-color: #28a745;
            border: none;
        }

        .card-body .btn-success:hover {
            background-color: #218838;
        }

        .alert {
            font-weight: bold;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 8px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        /* Link Hover Effect */
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            text-transform: uppercase;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Animation for buttons */
        .btn-primary, .btn-danger, .btn-success {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }

        .btn-primary::after, .btn-danger::after, .btn-success::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
            transform: scaleX(0);
            transform-origin: right;
        }

        .btn-primary:hover::after, .btn-danger:hover::after, .btn-success:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .btn-primary, .btn-danger, .btn-success {
            padding: 15px 30px;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Tableau de bord -->
        <div class="card">
            <div class="card-header">Tableau de Bord DGE</div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Affichage de la période actuelle -->
                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>

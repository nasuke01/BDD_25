<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Classement des Candidats</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.3);
            max-width: 700px;
            width: 100%;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            font-size: 24px;
            color: #8e44ad;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        canvas {
            margin-top: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Classement des Candidats</h1>

        @if(isset($candidats) && $candidats->isNotEmpty())
            <canvas id="classementChart"></canvas>
        @else
            <p>Aucun parrainage enregistré pour le moment.</p>
        @endif
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ route('api.statistiques') }}")
            .then(response => response.json())
            .then(data => {
                console.log("Données reçues :", data); // ✅ Vérifier les données en console

                if (data.length === 0) {
                    return;
                }

                let noms = data.map(c => (c.user ? c.user.nom + " " + c.user.prenom : "Inconnu"));
                let parrainages = data.map(c => c.parrainages_count);

                // Générer une couleur unique pour chaque candidat
                function getRandomColor() {
                    return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`;
                }

                let backgroundColors = noms.map(() => getRandomColor());
                let borderColors = backgroundColors.map(color => color.replace('0.6', '1'));

                let ctx = document.getElementById('classementChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: noms,
                        datasets: [{
                            label: 'Nombre de Parrainages',
                            data: parrainages,
                            backgroundColor: backgroundColors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error("Erreur JS :", error));
    });
    </script>

</body>
</html>

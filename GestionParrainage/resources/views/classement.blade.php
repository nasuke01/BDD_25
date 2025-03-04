<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Classement des Candidats</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                console.log("Données reçues :", data); // ✅ Affiche les données en console

                let noms = data.map(c => (c.user ? c.user.nom + " " + c.user.prenom : "Inconnu"));
                let parrainages = data.map(c => c.parrainages_count);

                let ctx = document.getElementById('classementChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: noms,
                        datasets: [{
                            label: 'Nombre de Parrainages',
                            data: parrainages,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
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

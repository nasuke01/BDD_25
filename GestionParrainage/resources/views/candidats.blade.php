@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Liste des candidats</h2>
    <div id="liste-candidats" class="row"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ url('/api/candidats') }}")
            .then(response => response.json())
            .then(candidats => {
                let liste = document.getElementById("liste-candidats");
                candidats.forEach(candidat => {
                    liste.innerHTML += `
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <img src="${candidat.photo || 'default.jpg'}" class="card-img-top" alt="Photo de ${candidat.user.nom}">
                                <div class="card-body">
                                    <h5 class="card-title">${candidat.user.nom} ${candidat.user.prenom}</h5>
                                    <p class="card-text"><strong>Parti :</strong> ${candidat.parti_politique || 'Indépendant'}</p>
                                    <p class="card-text"><strong>Slogan :</strong> ${candidat.slogan || '—'}</p>
                                    <a href="{{ route('parrainage.form', ['id' => $candidat->id]) }}" class="btn btn-primary">Parrainer</a>
                                </div>
                            </div>
                        </div>
                    `;
                });
            });
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Liste des candidats</h2>

    @if ($candidats->isEmpty())
        <p class="text-center">Aucun candidat trouvé.</p>
    @else
        <div class="row">
            @foreach ($candidats as $candidat)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ $candidat->photo ?? asset('default.jpg') }}" class="card-img-top" alt="Photo de {{ $candidat->user->nom }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $candidat->user->nom }} {{ $candidat->user->prenom }}</h5>
                            <p class="card-text"><strong>Parti :</strong> {{ $candidat->parti_politique ?? 'Indépendant' }}</p>
                            <a href="{{ route('parrainage.form', ['id' => $candidat->id]) }}" class="btn btn-primary">Parrainer</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

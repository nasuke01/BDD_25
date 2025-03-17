@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Parrainer un candidat</h2>
    
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $candidat->user->nom }} {{ $candidat->user->prenom }}</h4>
            <p><strong>Parti :</strong> {{ $candidat->parti_politique ?? 'Indépendant' }}</p>
            <p><strong>Slogan :</strong> {{ $candidat->slogan ?? '—' }}</p>
            <img src="{{ $candidat->photo ?? asset('default.jpg') }}" alt="Photo de {{ $candidat->user->nom }}" class="img-fluid mb-3">
            <form action="{{ route('parrainage.store') }}" method="POST">
                @csrf
                <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">
                <button type="submit" class="btn btn-success">Confirmer mon parrainage</button>
            </form>
        </div>
    </div>
</div>
@endsection
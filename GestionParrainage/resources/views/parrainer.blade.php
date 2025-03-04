@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center text-white">Parrainer un candidat</h2>

    <div class="card candidat-card mx-auto">
        <div class="card-body text-center">
            <img src="{{ $candidat->photo ?? asset('default.jpg') }}" 
                 alt="Photo de {{ $candidat->user->nom }}" 
                 class="candidat-photo mb-3">

            <h4 class="card-title">{{ $candidat->user->nom }} {{ $candidat->user->prenom }}</h4>
            <p><strong>Parti :</strong> {{ $candidat->parti_politique ?? 'Indépendant' }}</p>
            <p><strong>Slogan :</strong> {{ $candidat->slogan ?? '—' }}</p>

            <form action="{{ route('parrainage.store') }}" method="POST">
                @csrf
                <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">
                <button type="submit" class="btn btn-success btn-lg mt-3">Confirmer mon parrainage</button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Importation de la police */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    body {
        background: linear-gradient(135deg, #2c3e50, #8e44ad);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .candidat-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.3);
        max-width: 500px;
        margin-top: 30px;
    }

    .candidat-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #8e44ad;
    }

    h2 {
        font-weight: 600;
        margin-bottom: 20px;
    }

    h4 {
        color: #8e44ad;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    p {
        font-size: 16px;
        color: #555;
    }

    .btn-success {
        background: #27ae60;
        border: none;
        font-size: 18px;
        padding: 12px 20px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn-success:hover {
        background: #219150;
        transform: scale(1.05);
    }
</style>
@endsection

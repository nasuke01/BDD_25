@extends('layouts.master')

@section('title', 'Inscription Candidat')

@section('content')
    <h2>Inscription d'un candidat</h2>
    <form action="{{ route('candidats.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" required>

        <label for="email">Email :</label>
        <input type="email" name="email" required>

        <label for="photo">Photo :</label>
        <input type="file" name="photo" accept="image/*" required>

        <button type="submit">Enregistrer</button>
    </form>
@endsection

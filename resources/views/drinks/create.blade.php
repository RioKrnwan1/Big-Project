@extends('layouts.main')
@section('content')
<div class="card card-modern p-4">
    <h5 class="fw-bold mb-3">Tambah Minuman</h5>
    <form action="{{ route('drinks.store') }}" method="POST">
        @csrf
        <div class="mb-3"><label>Nama</label><input type="text" name="name" class="form-control" required></div>
        <div class="row mb-3">
            <div class="col"><label>Kalori</label><input type="number" step="0.1" name="calories" class="form-control"></div>
            <div class="col"><label>Lemak</label><input type="number" step="0.1" name="fat" class="form-control"></div>
            <div class="col"><label>Protein</label><input type="number" step="0.1" name="protein" class="form-control"></div>
            <div class="col"><label>Karbo</label><input type="number" step="0.1" name="carbs" class="form-control"></div>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
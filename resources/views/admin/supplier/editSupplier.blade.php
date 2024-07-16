@extends('layouts.layout')

@section('content')
@include('sweetalert::alert')

<form action="{{ route('supplier.update', [$supplier->kd_supp]) }}" method="POST">
    @csrf
    @method('PUT')
    <fieldset>
        <legend>Ubah Data Supplier</legend>

        <div class="form-group row">
            <div class="col-md-5">
                <label for="Kode_supplier">Kode Supplier</label>
                <input class="form-control" type="text" name="addkdsupp" value="{{ $supplier->kd_supp }}" readonly>
            </div>

            <div class="col-md-5">
                <label for="nama_supplier">Nama Supplier</label>
                <input id="addnmsupp" type="text" name="addnmsupp" class="form-control" value="{{ $supplier->nm_supp }}">
            </div>

            <div class="col-md-5">
                <label for="alamat">Alamat</label>
                <input id="addalamat" type="text" name="addalamat" class="form-control" value="{{ $supplier->alamat }}">
            </div>

            <div class="col-md-5">
                <label for="tel">Telepon</label>
                <input id="addtel" type="text" name="addtel" class="form-control" value="{{ $supplier->telepon }}">
            </div>
        </div>
    </fieldset>

    <div class="col-md-10 mt-3">
        <input type="submit" class="btn btn-success btn-send" value="Update">
        <a href="{{ route('supplier.index') }}" class="btn btn-primary btn-send">Kembali</a>
    </div>
    
    <hr>
</form>
@endsection

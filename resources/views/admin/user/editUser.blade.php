@extends('layouts.layout')

@section('content')
<form action="{{ route('user.update', [$user->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <fieldset>
        <legend>Ubah Akses User</legend>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="kode">Kode User</label>
                <input class="form-control" type="text" name="kode" value="{{ $user->id }}" readonly>
            </div>
            <div class="col-md-5">
                <label for="user">Nama User</label>
                <input id="name" type="text" name="uname" class="form-control" value="{{ $user->name }}" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-5">
                <label for="email">Email</label>
                <input id="email" type="text" name="email" class="form-control" value="{{ $user->email }}" readonly>
            </div>
            <div class="col-md-2">
                @foreach ($user->roles as $role)
                    <label for="akses">Akses</label>
                    <input id="akses" type="text" name="akses" class="form-control" value="{{ $role->id }}" readonly>
                @endforeach
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="roles">Ubah Akses</label>
                <select id="roles" name="role" class="form-control" required>
                    <option value="">--Pilih Akses--</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
        </div>
    </fieldset>
    <div class="form-group row">
        <div class="col-md-10">
            <input type="submit" class="btn btn-success btn-send" value="Ubah Akses">
            <a href="{{ route('user.index') }}" class="btn btn-primary btn-send">Kembali</a>
        </div>
    </div>
    <hr>
</form>
@endsection

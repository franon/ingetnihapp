@extends('layouts.admin.default')

@section('title')
    Ubah Data User
@stop

@section('content')

<div class="page-wrapper">
    @include('includes.admin.breadcumb')    

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($message = Session::get('edituser-error'))
                          <div class="alert alert-danger alert-block">
                           <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                          </div>
                          @endif
                        <form method="POST" action="{{'admin/user/user/edit'}}">
                            @method('PUT')
                            @csrf
                                {{-- =====================================
                                Nama Acara
                                ===================================== --}}
                                {{-- {{dd($users)}} --}}
                                <div class="form-group">
                                    <label for="name">Nama Pengguna</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{$users->name}}" required> 
                                </div>
                                
                                {{-- =====================================
                                Detail Acara
                                ===================================== --}}
                                <div class="form-group">
                                    <label for="email">Email Pengguna</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{$users->email}}" required>
                                </div>

                                <div class="form-row">
                                    <div class="col">
                                        <label for="role_id">Role</label>
                                        <select name="role_id" id="role_id" class="custom-select mr-sm-2" required>
                                            <option selected>Sebagai...</option>
                                            <option value="2">Dosen</option>
                                            <option value="3">Mahasiswa</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="jabatan">Jabatan</label>
                                        <select name="jabatan" id="jabatan" class="custom-select mr-sm-2" required>
                                            <option selected>Jabatan...</option>
                                            <option value="2">Rektor</option>
                                            <option value="3">Dekan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phone_number">Nomor Handphone</label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{$users->phone_number}}" required> 
                                </div>

                                <div class="form-group mb-4">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select name="gender" id="gender" class="custom-select mr-sm-2" required>
                                        <option selected value="">Jenis Kelamin...</option>
                                        <option value="m">Laki-laki</option>
                                        <option value="f">Perempuan</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success">Ubah Data Pengguna</button>
                              </form>
                        </div>
                </div>
            </div>
        </div>

    </div>

</div>


@stop
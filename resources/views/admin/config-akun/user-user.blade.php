@extends('layouts.admin.default')

@section('content')

<div class="page-wrapper">
    @include('includes.admin.breadcumb')
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <!-- basic table -->
    <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3 mx-auto">
                            <div class="card card-hover">
                                <div class="p-2 bg-primary text-center">
                                    <h1 class="font-light text-white">{{count($dataUser)}}</h1>
                                    <h6 class="text-white">Banyak Pengguna</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="/admin/user/user/add">
                        <button type="button" class="btn btn-outline-primary mb-3"><i class="fa fa-plus" aria-hidden="true"><span class="ml-2">Tambah Pengguna</span></i></button>
                        </a>

                        @if ($message = Session::get('tambahpengguna-success'))
                        <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif

                    <div class="table-responsive">
                        <table id="users-table" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Nomor Handphone</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Nomor Handphone</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('customjs')
<script>
$('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'http://localhost:8000/api/users/datatables',
        columns: [
            {data: 'user_id', name: 'user_id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role_id', name: 'role_id'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'gender', name: 'gender'},
            {data: 'jabatan', name: 'jabatan'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
</script>
@stop
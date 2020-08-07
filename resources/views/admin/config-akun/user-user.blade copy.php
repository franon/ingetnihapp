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
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="p-2 bg-primary text-center">
                                    <h1 class="font-light text-white">{{count($dataUser)}}</h1>
                                    <h6 class="text-white">Banyak Pengguna</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="p-2 bg-cyan text-center">
                                    <h1 class="font-light text-white">1,738</h1>
                                    <h6 class="text-white">Responded</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="p-2 bg-success text-center">
                                    <h1 class="font-light text-white">1100</h1>
                                    <h6 class="text-white">Resolve</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="p-2 bg-danger text-center">
                                    <h1 class="font-light text-white">964</h1>
                                    <h6 class="text-white">Pending</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
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
                                @foreach ($dataUser as $user)
                                    <tr>
                                        <td> <a href="{{'/users/'.$user->user_id}}">{{$user->name}}</a></td>
                                        <td><a href="javascript:void(0)" class="font-weight-medium link"></a>{{$user->email}}</td>
                                        <td><a href="javascript:void(0)" class="font-bold link">{{$user->role_id}}</a></td>
                                        <td>{{$user->phone_number}}</td>
                                        <td>{{$user->gender}}</td>
                                        <td>{{$user->jabatan}}</td>
                                        <td>zzz</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
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

                        {{-- {{$paginator->links()}} --}}
                        <ul class="pagination float-right">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('customjs')
<script>
$('#jadwal-table').DataTable({
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
            {data: 'views', name: 'views'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
</script>
@stop
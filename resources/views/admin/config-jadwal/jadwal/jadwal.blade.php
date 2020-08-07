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
                        {{-- <!-- Column -->
                        <div class="col-md-6 col-lg-3 col-xlg-3">
                            <div class="card card-hover">
                                <div class="p-2 bg-primary text-center">
                                    <h1 class="font-light text-white">aye</h1>
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
                        <!-- Column --> --}}
                        <a href="/admin/event/add">
                        <button type="button" class="btn btn-outline-primary mb-3"><i class="fa fa-plus" aria-hidden="true"><span class="ml-2">Tambah Acara</span></i></button>
                        </a>

                        @if ($message = Session::get('tambahjadwal-success'))
                        <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        <table class="table" id="jadwal-table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nama Acara</th>
                                    <th class="text-center">Detail Acara</th>
                                    <th class="text-center">Tanggal Mulai Acara</th>
                                    <th class="text-center">Tanggal Berakhir Acara</th>
                                    <th class="text-center">Waktu Acara</th>
                                    <th class="text-center">Pembuat Acara</th>
                                    <th class="text-center">Privasi Acara</th>
                                    <th class="text-center">Aksi</th>
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
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
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
$('#jadwal-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'http://localhost:8000/api/event/datatables',
        columns: [
            {data: 'id', name: '#'},
            {data: 'event_name', name: 'event_name'},
            {data: 'event_detail', name: 'event_detail'},
            {data: 'event_date', name: 'event_date'},
            {data: 'event_date_end', name: 'event_date_end'},
            {data: 'event_time', name: 'event_time'},
            {data: 'created_by', name: 'created_by'},
            {data: 'views', name: 'views'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
</script>
@stop

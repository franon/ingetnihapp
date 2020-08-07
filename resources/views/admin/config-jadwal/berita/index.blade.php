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
                                    <h1 class="font-light text-white">{{count($dataBerita)}}</h1>
                                    <h6 class="text-white">Banyak Berita</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
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
                        <table id="berita-table" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>ID Berita</th>
                                    <th>Nama Berita</th>
                                    <th>Tautan Berita</th>
                                    <th>Isi Berita</th>
                                    <th>Tautan Gambar Berita</th>
                                    <th>Tautan PDF Berita</th>
                                    <th>Tanggal Berita</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td style="over-flow: break-word;"></td>
                                        <td style="over-flow: break-word;"></td>
                                        <td style="over-flow: break-word;"></td>
                                        <td style="over-flow: break-word;"></td>
                                        <td style="over-flow: break-word;"></td>
                                        <td style="over-flow: break-word;"></td>
                                        <td style="over-flow: break-word;"></td>
                                        <td style="over-flow: break-word;"></td>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID Berita</th>
                                    <th>Nama Berita</th>
                                    <th>Tautan Berita</th>
                                    <th>Isi Berita</th>
                                    <th>Tautan Gambar Berita</th>
                                    <th>Tautan PDF Berita</th>
                                    <th>Tanggal Berita</th>
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
$('#berita-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'http://localhost:8000/api/berita/datatables',
        columns: [
            {data: 'berita_id', name: 'berita_id'},
            {data: 'berita_link', name: 'berita_link'},
            {data: 'berita_judul', name: 'berita_judul'},
            {data: 'berita_isi', name: 'berita_isi'},
            {data: 'gambar_link', name: 'gambar_link'},
            {data: 'pdf_link', name: 'pdf_link'},
            {data: 'berita_tanggal', name: 'berita_tanggal'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
</script>
@stop
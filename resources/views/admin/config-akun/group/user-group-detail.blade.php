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
            <div class="col-md-6 col-lg-3 col-xlg-3 mx-auto">
                <div class="card card-hover">
                    <div class="p-2 bg-primary text-center">
                        <h1 class="font-light text-white">Group {{$data->group[0]->group}}</h1>
                        <h6 class="text-white">...</h6>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Pengguna didalam Grup {{ $data->group[0]->group}}</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Jabatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count=1;?>
                                    @foreach ($data->user as $user)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->jabatan}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Acara didalam Grup {{ $data->group[0]->group}}</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Acara</th>
                                        <th>Tanggal Acara</th>
                                        <th>Pembuat Acara</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count=1;?>
                                    @foreach ($data->event as $event)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$event->event_name}}</td>
                                        <td>{{$event->event_date}}</td>
                                        <td>{{$event->created_by}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    
@stop
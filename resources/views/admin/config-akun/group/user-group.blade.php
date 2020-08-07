@extends('layouts.admin.default')

@section('title')
    Admin - List Grup
@stop

@section('customcss')
<link href="{{ asset('vendor/customcss/list-card/style.css')}}" rel="stylesheet">
@stop

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
                            <div class="col-md-6 col-lg-3 col-xlg-3 mx-auto">
                                <div class="card card-hover">
                                    <div class="p-2 bg-primary text-center">
                                        <h1 class="font-light text-white">{{count($dataGroup)}}</h1>
                                        <h6 class="text-white">Banyak Group</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card deck -->
                        <div class="card-deck row">
                            @foreach ($dataGroup as $group)
                            <div class="col-xs-12 col-sm-6 col-md-4">

                                <div class="card">
                                    <!--Card image-->
                                    <div class="view overlay">
                                        <a href="{{'/admin/user/group/'.$group->group_id}}">
                                        <img class="card-img-top"
                                            src="https://fti.budiluhur.ac.id/wp-content/uploads/2018/08/logo-bl-292x300.jpg"
                                            alt="Card image cap">
                                            <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>

                                    <!--Card content-->
                                    <div class="card-body">
                                        <h4 class="card-title"> <a href="{{'/admin/user/group/'.$group->group_id}}">Grup {{$group->group}} </a></h4>
                                        <p class="card-text">Some quick example text to build on the card title and make
                                            up the bulk of the card's content.</p>
                                    </div>

                                </div>
                                <!-- Card -->
                            </div>
                            @endforeach
                        </div>
                        <!-- Card deck -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @stop
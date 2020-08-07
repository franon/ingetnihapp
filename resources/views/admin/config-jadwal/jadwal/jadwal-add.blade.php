@extends('layouts.admin.default')

@section('title')
    Tambah User
@stop

@section('content')

<div class="page-wrapper">
    @include('includes.admin.breadcumb')    

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($message = Session::get('tambahjadwal-error'))
                          <div class="alert alert-danger alert-block">
                           <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                          </div>
                          @endif
                        <form method="POST" action="{{'/admin/event/create'}}">
                            @csrf
                                {{-- =====================================
                                Nama Acara
                                ===================================== --}}
                                <div class="form-group">
                                    <label for="event_name">Nama Acara</label>
                                    <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Nama Acara..." required>
                                </div>
                                
                                {{-- =====================================
                                Detail Acara
                                ===================================== --}}
                                <div class="form-group">
                                    <label for="event_detail">Detail Acara</label>
                                    <textarea class="form-control" name="event_detail" id="event_detail" rows="3" placeholder="Detail Acara tersebut..." required></textarea>
                                </div>

                                <div class="form-row">
                                    <div class="col">
                                        <label for="event_date">Tanggal Acara</label>
                                        <input type="date" class="form-control" name="event_date" id="event_date" required>
                                    </div>
                                    <div class="col">
                                        <label for="event_date_end">Tanggal Berakhir Acara (Optional)</label>
                                        <input type="date" class="form-control" name="event_date_end" id="event_date_end">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="event_time">Mulai Acara</label>
                                    <input type="time" class="form-control" name="event_time" id="event_time">
                                </div>

                                <div class="form-group mb-4">
                                    <label for="tag">Jenis Tag Acara</label>
                                    <select name="tag" id="tag" class="custom-select mr-sm-2" required>
                                        <option selected>Pilih...</option>
                                        <option value="1">Perkuliahan</option>
                                        <option value="2">Antara</option>
                                        <option value="7">KKP</option>
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="views">Jenis Range Acara</label>
                                    <select name="views" id="views" class="custom-select mr-sm-2" required>
                                        <option selected>Pilih...</option>
                                        <option value="public">Publik</option>
                                        <option value="restricted">Terbatas</option>
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="belongs_to">Bagikan Kepada</label>
                                    <select name="belongs_to" id="belongs_to" class="custom-select mr-sm-2">
                                        <option selected>Pilih...</option>
                                        <option value="1">Perkuliahan</option>
                                        <option value="2">Antara</option>
                                        <option value="7">KKP</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success">Submit</button>
                              </form>
                        </div>
                </div>
            </div>
        </div>

    </div>

</div>


@stop
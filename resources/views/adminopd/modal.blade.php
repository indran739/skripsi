

@extends('layouts.db_admin')

@section('content')



<!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"></h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active">Konfirmasi Jadwal </li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>



<div class="container-fluid">
<div class="row">
<div class="col-12">

    <div class="card">
        <div class="card-header">

        <div class="text-blue">
            <h4><b>
                DAFTAR KONFIRMASI JADWAL:
                </b>
            </h4>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
           

        <div class="card-body">
            <table id="table1" class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">NAMA PENYEWA</th>
                        <th scope="col">NAMA LAPANGAN</th>
                        <th scope="col">JAM/WAKTU</th>
                        <th scope="col">TANGGAL</th>
                        <th scope="col">AKSI</th>
                        <th scope="col">BUKTI BAYAR</th>
                    </tr>
                </thead>
                
                <tbody>
                @php $no=0; @endphp @foreach($py as $py)
                    <tr>
                        <td>
                        {{$loop->iteration}}
                        </td>

                        <td>
                          {{$py->name}}
                        </td>

                        <td>
                        {{$py->nama_lapangan}}
                        </td>

                        <td>
                        {{$py->jam_sewa}}
                        </td>

                        
                        <td>
                        {{date('d F Y', strtotime($py->tgl_sewa))}}
                        </td>

                        <td>
                        
                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal__{{ $py->id }}">
                            SUDAH LUNAS
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal__{{ $py->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">KONFIRMASI JADWAL</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                <form action="/admin/konfirmasi/{{$py->id}}" method="post" enctype="multipart/form-data">

                                {{csrf_field()}}
                                {{ method_field('put') }}

                                <p>Apakah anda yakin ingin Konfirmasi Jadwal ini? {{$py->name}} </p> 
                                
                                <input type="hidden" name="id_users" value="{{$py->id_users}}" >
                                <input type="hidden" name="tgl_sewa" value="{{$py->tgl_sewa}}" >
                                <input type="hidden" name="jam_sewa" value="{{$py->jam_sewa}}" >

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                                    <button type="submit" class="btn btn-primary">KONFIRMASI</button>
                                </div>
                                </form>
                                </div>
                            </div>
                            </div>

                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#dt__{{ $py->id }}">
                            UANG MUKA
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="dt__{{ $py->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabe1l">KONFIRMASI JADWAL</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                <form action="/admin/konfirmasi/um/{{$py->id}}" method="post" enctype="multipart/form-data">

                                {{csrf_field()}}
                                {{ method_field('put') }}

                                <p>Apakah anda yakin ingin Konfirmasi Jadwal ini? {{$py->name}} </p> 
                                
                                <input type="hidden" name="id_users" value="{{$py->id_users}}" >
                                <input type="hidden" name="tgl_sewa" value="{{$py->tgl_sewa}}" >
                                <input type="hidden" name="jam_sewa" value="{{$py->jam_sewa}}" >

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                                    <button type="submit" class="btn btn-primary">KONFIRMASI</button>
                                </div>
                                </form>
                                </div>
                            </div>
                            </div>


                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger " title="Hapus Data" data-bs-toggle="modal" data-bs-target="#modalDelete_{{ $py->id }}">
                                        TOLAK
                                        </button>


                                                            <!-- Modal -->
                                                            <form method="get" action="/admin/tolak/{{$py->id}}">
                                                                <div class="modal fade" id="modalDelete_{{ $py->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                {{ csrf_field() }} {{ method_field('delete') }}

                                                                                <p>Apakah anda yakin ingin menolak <b>{{$py->name}}</b> ?</p>
                                                                                
                                                                                <div class="form-group" required>
                                                                                        <label for="isi">Alasan?</label>
                                                                                        <textarea class="form-control" name="isi" rows="3"></textarea>
                                                                                    </div>



                                                                                <input type="hidden" name="id_users" value="{{$py->id_users}}" >
                                                                                <input type="hidden" name="tgl_sewa" value="{{$py->tgl_sewa}}" >
                                                                                <input type="hidden" name="jam_sewa" value="{{$py->jam_sewa}}" >
                                                                                

                                                                                
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                                <button type="submit" class="btn btn-danger toastrDefaultError">TOLAK</button>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>

                        </td>

                        <td>

                            <!-- Button trigger modal -->
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter{{ $py->id }}">
                        Lihat
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter{{ $py->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">BUKTI PEMBAYARAN</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                

                            <img width="100%" height=100%" src="{{url('images/lapangan', $py->bukti_bayar)}}" alt="image" style="margin-right: 1px;"/>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                                
                            </div>
                            </div>
                        </div>
                        </div>

                        </td>

                        
                        

                        
                    </tr>
                    @endforeach
                </tbody>
               

            </table>
            <br>
            <br>
            <a href="/pelanggan" class="btn btn-outline-info text-dark pull-right">Kembali</a> 
            
            
           

            </table>
        </div>

    </div>

</div>

</div>

</div>

</div>
</div>



@endsection



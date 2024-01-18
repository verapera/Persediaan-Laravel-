@extends('template.home')
@section('title','Daftar Barang')
@section('content')

<link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
<div class="row justify-content-end mt-2">
    <div class="col-auto d-flex">
      <button class="btn btn-primary mx-1"><a href="{{ route('barang.create') }}" style="color: inherit">Tambah data barang</a></button>
      <a class="btn btn-danger mx-1" href="/"><i class="bx bxs-printer"></i> Export PDF</a>
      <form action="/excel_barang" method="POST">
        @if ($start_date && $end_date)
          @csrf
          <input class="form-control" type="hidden" name="start_date" id="start_date" value="{{ $start_date }}">
          <input class="form-control" type="hidden" name="end_date" id="end_date" value="{{ $end_date }}">
        @else
          @csrf
          <input class="form-control" type="hidden" name="start_date" id="start_date">
          <input class="form-control" type="hidden" name="end_date" id="end_date">
        @endif
        <button type="submit" class="btn btn-success mx-1"><i class="bx bx-printer"></i> Export Excel</button>
      </form>
    </div>
  </div>
  

  


<div class="card shadow rounded mt-2">
    <h4 class="card-header ms-0">Daftar Barang</h4>
    <div class="table-responsive text-nowrap">
      <div class="container">
        <form action="/exportToExcel" method="POST">
          @csrf
          @if ($start_date && $end_date)
          <div class="row">
            <div class="col-lg-3">
              <label for="start_date">Start Date:</label>
              <input class="form-control" type="date" name="start_date" id="start_date" value="{{ $start_date }}">
            </div>
            <div class="col-lg-3">
              <label for="end_date">End Date:</label>
              <input class="form-control" type="date" name="end_date" id="end_date" value="{{ $end_date }}">
            </div>
            <div class="col-lg-4 mt-3">

              <button class="btn btn-primary mb-4" type="submit">Filter</button>
            </div>

          </div>
          @else
          <div class="row">
            <div class="col-lg-3">
              <label for="start_date">Start Date:</label>
              <input class="form-control" type="date" name="start_date" id="start_date">
            </div>
            <div class="col-lg-3">
              <label for="end_date">End Date:</label>
              <input class="form-control" type="date" name="end_date" id="end_date">
            </div>
            <div class="col-lg-4 mt-3">

              <button class="btn btn-primary mb-4" type="submit">Filter</button>
            </div>

          </div>
          @endif
          
      </form>
        <table id='myTable' class="table table-stripped">
          <caption class="ms-4">
            List of Projects
          </caption>
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Gambar</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Harga</th>
              <th scope="col">Stok</th>
              <th scope="col">Deskripsi</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              
              @forelse ($barangs as $barang)
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <img src="{{ asset('storage/barangs/'.$barang->image) }}" class="rounded" style="width:200px">
                  </td>
                  <td>{{ $barang->nama_barang }}</td>
                  <td>{{ rupiah($barang->harga) }}</td>
                  <td>{{ $barang->stok }}</td>
                  <td>{!! $barang->deskripsi !!}</td>
                  <td>{{ $barang->created_at }}</td>
                  <td class="text-center">
                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barang.destroy', $barang->id) }}" method="POST">
                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                    </form>
                  </td>
                 
                </tr>
              @empty
              <div class="alert alert-danger col-md-12">
                  Data Barang belum Tersedia.
              </div>
              @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
  <script>   	
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

  </script>
    <script>
    //message with toastr
    @if(session()->has('success'))
    
        toastr.success('{{ session('success') }}', 'BERHASIL!'); 

    @elseif(session()->has('error'))

        toastr.error('{{ session('error') }}', 'GAGAL!'); 
        
    @endif
    </script>
@endsection
@include('partials/js')




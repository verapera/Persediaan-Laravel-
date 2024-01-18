@extends('template.home')
@section('title','Daftar Barang')
@section('content')
<!-- modal -->
      <!-- Button trigger modal -->
      <div class="mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Tambah 
        </button>
        <a class="btn btn-danger" href="/pdf_barangkeluar"><i class="bx bxs-printer"></i> Cetak</a>
      </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('barangkeluar.store') }}" method="POST">
            <div class="modal-body">
              @csrf
                <div class="card mb-4">
                    <h5 class="card-header">Form Barang Masuk</h5>
                    <div class="card-body">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <select name="barang_id" id="" class="form-control">
                          @foreach ($barang as $item)
                              <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                          @endforeach
                        </select>
                    </div>       
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Masukan nominal...">
                    </div>       
                    <div class="mb-3">
                        <label for="penerima" class="form-label">Penerima</label>
                        <input type="text" class="form-control" name="penerima" id="penerima" placeholder="Masukan tanggal Anda...">
                    </div>       
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
            </div>
        </div>
        </div>



<div class="card">
    <h5 class="card-header">Daftar Barang Keluar</h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <caption class="ms-4">
          List of Projects
        </caption>
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Penerima</th>
            <th scope="col" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
              @forelse ($barangkeluars as $item)
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->Barang->nama_barang }}</td>
                  <td>{{ $item->jumlah}}</td>
                  <td>{{ $item->penerima }}</td>
                  <td class="text-center">
                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barangkeluar.destroy', $item->id) }}" method="POST">
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
      {{ $barangkeluars->links() }}
    </div>
  </div>
    <script>
    //message with toastr
    @if(session()->has('success'))
    
        toastr.success('{{ session('success') }}', 'BERHASIL!'); 

    @elseif(session()->has('error'))

        toastr.error('{{ session('error') }}', 'GAGAL!'); 
        
    @endif
    </script>
@endsection




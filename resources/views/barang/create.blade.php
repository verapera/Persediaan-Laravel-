@extends('template.home')
@section('title','Create Barang')
@section('content')

  <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title">Form Input Barang</h3> 
          <form class="forms-sample mt-3" action=" {{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="form-group mt-3">
              <label for="image">Gambar</label>
              <input type="file" name ="image" class="form-control @error('image') is-invalid @enderror" id="image" placeholder="Gambar">
              {{-- pesan error --}}
              @error('image')
                  <div class="alert alert-danger">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            <div class="form-group mt-3">
              <label for="text">Nama Barang</label>
              <input type="text" name ="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" placeholder="Nama Barang">
              {{-- pesan error --}}
              @error('nama_barang')
                  <div class="alert alert-danger">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            <div class="form-group mt-3">
              <label for="harga">Harga Barang</label>
              <input type="number" name ="harga" class="form-control @error('harga') is-invalid @enderror" id="harga" placeholder="Harga Barang">
              {{-- pesan error --}}
              @error('harga')
                  <div class="alert alert-danger">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            <div class="form-group mt-3">
              <label for="stok">Stok Barang</label>
              <input type="number" name ="stok" class="form-control @error('stok') is-invalid @enderror" id="stok" placeholder="Stok Barang">
              {{-- pesan error --}}
              @error('stok')
                  <div class="alert alert-danger">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            
            <div class="form-group mt-3">

              <label for="deskripsi">Deskripsi Barang</label>
              <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="5" placeholder="Masukkan Konten Post">{{ old('deskripsi') }}</textarea>
              {{-- pesan error --}}
              @error('deskripsi')
                  <div class="alert alert-danger">
                      {{ $message }}
                  </div>
              @enderror
            </div>   
            <button type="submit" class="btn btn-primary mt-3 ">Submit</button>
            <button class="btn btn-light">Cancel</button>
          </form>
        </div>
      </div>
    </div>
</div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'deskripsi' );
</script>
@endsection
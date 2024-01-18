<?php
namespace App\Http\Controllers;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    //
    public function index(){
        $barangs = Barang::all();
        $start_date = null;
        $end_date = null;
        // render view with barangs
        return view('barang.index',compact('barangs', 'start_date','end_date'));
    }

    public function create(){
        // render view with barangs
        return view('barang.create');
    }
      
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'           => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang'     => 'required',
            'harga'           => 'required',
            'stok'            => 'required',
            'deskripsi'       => 'required'
        ]);
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/barangs', $image->hashName());
        //create barang
        Barang::create([
            'image'           => $image->hashName(),
            'nama_barang'     => $request->nama_barang,
            'harga'           => $request->harga,
            'stok'            => $request->stok,
            'deskripsi'       => $request->deskripsi,
        ]);
        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);

    }
    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }
    public function update(Request $request, Barang $barang)
    {
         //validate form
         $this->validate($request, [
            'image'           => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang'     => 'required',
            'harga'           => 'required',
            'stok'            => 'required',
            'deskripsi'       => 'required'
        ]);
        // get data barang dari if
        $barang = Barang::findOrFail($barang->id);

        //check if image is uploaded
        if ($request->file('image')=="") {
            $barang->update([
                'nama_barang' =>$request->nama_barang,
                'harga' =>$request->harga,
                'stok' =>$request->stok,
                'deskripsi' =>$request->deskripsi
            ]); 
        }else{
             // hapus old image
             Storage::delete('public/barangs/'.$barang->image);
            //  upload new image
             $image = $request->file('image');
             $image->storeAs('public/barangs', $image->hashName());
             $barang->update([
                 // create barangs
                 'image' => $image->hashName(),
                 'nama_barang' =>$request->nama_barang,
                 'harga' =>$request->harga,
                 'stok' =>$request->stok,
                 'deskripsi' =>$request->deskripsi
             ]); 
        }
        if ($barang) {
            // redirect dengan pesan berhasil
            return redirect()->route('barang.index')->with(['succes'=>'Data Berhasil diedit']);
        }else{
                // redirect dengan pesan error
                return redirect()->back()->with(['key'=>'value']);
                return redirect()->route('barang.index')->with(['succes'=>'Data gagal diedit']);
        }

        //redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy($id){
        $barang = Barang::findOrFail($id);
        Storage::disk('local')->delete('public/barang'.$barang->image);
        $barang->delete();
        if ($barang) {
        // redirect dgn pesan berhasil
        return redirect()->route('barang.index')->with(['succes'=>'Data berhasil dihapus']);
        }else{
            return redirect()->route('barang.index')->with(['succes'=>'Data gagal dihapus']);
        }
    }
    public function filter(Request $request){
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        // Lakukan query untuk mendapatkan data barang masuk berdasarkan rentang tanggal
        $barangs = Barang::whereBetween('created_at', [$start_date, $end_date])->paginate(10);
        
            return view('barang.index', compact('barangs', 'start_date', 'end_date'));
        
    }
}

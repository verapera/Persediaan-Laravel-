<?php
namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    //
    public function index(){
        $barangmasuks = BarangMasuk::with('Barang')->paginate(10);
        $barang = Barang::all();
        // render view with barangs
        
        return view('barangmasuk.index',compact('barangmasuks','barang'));
    }

    public function store(Request $request){
         //validate form
         $this->validate($request, [
            'barang_id'           => 'required',
            'jumlah'              => 'required',
            'penerima'            => 'required',
        ]);
        //create barang masuk
        BarangMasuk::create([
            'barang_id'         => $request->barang_id,
            'jumlah'            => $request->jumlah,
            'penerima'           => $request->penerima,
        ]);
        //redirect to index
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function destroy($id){
        $barangmasuks = BarangMasuk::findOrFail($id);
        $barangmasuks->delete();
        if ($barangmasuks) {
        // redirect dgn pesan berhasil
        return redirect()->route('barangmasuk.index')->with(['succes'=>'Data berhasil dihapus']);
        }else{
            return redirect()->route('barangmasuk.index')->with(['succes'=>'Data gagal dihapus']);
        }
    }
    
    
}

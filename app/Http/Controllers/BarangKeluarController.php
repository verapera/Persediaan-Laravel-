<?php
namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    //
    public function index(){
        $barangkeluars = BarangKeluar::with('Barang')->paginate(10);
        $barang = Barang::all();
        // render view with barangs
        
        return view('barangkeluar.index',compact('barangkeluars','barang'));
    }

    public function store(Request $request){
         //validate form
         $this->validate($request, [
            'barang_id'           => 'required',
            'jumlah'              => 'required',
            'penerima'            => 'required',
        ]);
        //create barang keluar
        BarangKeluar::create([
            'barang_id'         => $request->barang_id,
            'jumlah'            => $request->jumlah,
            'penerima'           => $request->penerima,
        ]);
        //redirect to index
        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function destroy($id){
        $barangkeluars = BarangKeluar::findOrFail($id);
        $barangkeluars->delete();
        if ($barangkeluars) {
        // redirect dgn pesan berhasil
            return redirect()->route('barangkeluar.index')->with(['succes'=>'Data berhasil dihapus']);
        }else{
            return redirect()->route('barangkeluar.index')->with(['succes'=>'Data gagal dihapus']);
        }
    }
}

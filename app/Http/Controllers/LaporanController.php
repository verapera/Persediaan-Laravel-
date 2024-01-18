<?php
namespace App\Http\Controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
class LaporanController extends Controller
{
    //
    public function laporan_barang_masuk() 
    {
    	$html = '<h3 style="text-align: center;">Laporan Barang Masuk</h3> <br>';
        TCPDF::SetTitle('Laporan Barang Masuk');
        TCPDF::AddPage();
        TCPDF::writeHTML($html, true, false, true, false, '');

        $barangmasuks = BarangMasuk::with('Barang')->get(); 
        TCPDF::SetFont('helvetica', 'B', 12);
        TCPDF::Cell(15, 10, 'No', 1, 0, 'C');
        TCPDF::Cell(50, 10, 'Nama Barang', 1, 0, 'C');
        TCPDF::Cell(35, 10, 'Jumlah', 1, 0, 'C');
        TCPDF::Cell(40, 10, 'Tanggal', 1, 0, 'C');
        TCPDF::Cell(50, 10, 'Penerima', 1, 1, 'C'); 
        TCPDF::SetFont('helvetica', '', 10);

        $no = 1;
        foreach ($barangmasuks as $barangmasuk) {
            TCPDF::Cell(15, 10, $no++, 1, 0, 'C');
            TCPDF::Cell(50, 10, $barangmasuk->Barang->nama_barang, 1, 0, 'C'); 
            TCPDF::Cell(35, 10, $barangmasuk->jumlah, 1, 0, 'C'); 
            TCPDF::Cell(40, 10, $barangmasuk->created_at, 1, 0, 'C'); 
            TCPDF::Cell(50, 10, $barangmasuk->penerima, 1, 1, 'C'); 
        }     
        $fileName = 'laporan_barang_masuk.pdf';
        TCPDF::Output($fileName, 'I'); 
        TCPDF::Output('path/to/save/' . $fileName, 'F');
        
    }
    public function laporan_barang_keluar() 
    {
    	$html = '<h3 style="text-align: center;">Laporan Barang Keluar</h3> <br>';
        TCPDF::SetTitle('Laporan Barang Keluar');
        TCPDF::AddPage();
        TCPDF::writeHTML($html, true, false, true, false, '');

        $barangkeluars = BarangKeluar::with('Barang')->get(); 
        TCPDF::SetFont('helvetica', 'B', 12);
        TCPDF::Cell(15, 10, 'No', 1, 0, 'C');
        TCPDF::Cell(50, 10, 'Nama Barang', 1, 0, 'C');
        TCPDF::Cell(35, 10, 'Jumlah', 1, 0, 'C');
        TCPDF::Cell(40, 10, 'Tanggal', 1, 0, 'C');
        TCPDF::Cell(50, 10, 'Penerima', 1, 1, 'C'); 
        TCPDF::SetFont('helvetica', '', 10);

        $no = 1;
        foreach ($barangkeluars as $barangkeluar) {
            TCPDF::Cell(15, 10, $no++, 1, 0, 'C');
            TCPDF::Cell(50, 10, $barangkeluar->Barang->nama_barang, 1, 0, 'C'); 
            TCPDF::Cell(35, 10, $barangkeluar->jumlah, 1, 0, 'C'); 
            TCPDF::Cell(40, 10, $barangkeluar->created_at, 1, 0, 'C'); 
            TCPDF::Cell(50, 10, $barangkeluar->penerima, 1, 1, 'C'); 
        }     
        $fileName = 'laporan_barang_keluar.pdf';
        TCPDF::Output($fileName, 'I'); 
        TCPDF::Output('path/to/save/' . $fileName, 'F');
        
    }
     public function exportToExcel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); 
        // dd($request->barangs);;;
        if($request->start_date !== null){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $barangs = Barang::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->get();
        } else {
            $barangs = Barang::latest()->get();
           
      
        }

            // $barangs = Barang::whereDate('created_at','>=',$start_date)->whereDate('created_at','>=','$end_date');
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Harga');
        $sheet->setCellValue('D1', 'Stok');
        $sheet->setCellValue('E1', 'Deskripsi');
        $sheet->setCellValue('F1', 'Tanggal');

        $row = 2; // Mulai dari baris kedua untuk data
        $no = 1;
        
        // Isi data
        foreach ($barangs as $barang) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $barang->nama_barang);
            $sheet->setCellValue('C' . $row, $barang->harga);
            $sheet->setCellValue('D' . $row, $barang->stok);
            $sheet->setCellValue('E' . $row, $barang->deskripsi);
            $sheet->setCellValue('F' . $row, $barang->created_at);
            $row++;
        }

        // Konfigurasi nama file dan tipe
        $filename = 'laporan_barang_' . date('YmdHis') . '.xlsx';

        // Save spreadsheet ke file
        $writer = new Xlsx($spreadsheet);
        $writer->save('document' . $filename);

        return response()->download('document' . $filename)->deleteFileAfterSend(true);
    }
}

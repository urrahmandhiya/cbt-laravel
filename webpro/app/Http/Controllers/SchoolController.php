<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PDF;

class SchoolController extends Controller
{
    public function index()
    {
        $data['list'] = Cache::remember('school-list', 10, function () 
        {
            return School::all();
        });
        $data['rekap'] = School::getDataForGraph();
        //dd($school);
        Cache::put('example-cache', '12345', 3600);
        return view('school/school', $data);


    }

    public function form()
    {
        // Uncomment the following line to check the cache before clearing
        // dd(Cache::get('example-cache'));

        // Clear the cache after displaying the value
        Cache::forget('example-cache');

        return view('school/form');
    }

    public function simpan(Request $post)
    {
        $data = $post->validate([
            'school_name' => 'required|min:3',
            'level' => 'required|min:2',
            'address' => 'required|min:3',
            'student_amount' => 'required|min:2',
        ]);

        $school = new School;
        $school->school_name = $data['school_name'];
        $school->level = $data['level'];
        $school->address = $data['address'];
        $school->student_amount = $data['student_amount'];
        $school->save();

        return redirect()->route('school.index');
    }

    public function formedit($id_school)
    {
        $data['school'] = School::find($id_school);
        return view('school/edit', $data);
    }

    public function update(Request $post)
    {
        $data = $post->validate([
            'id' => 'required',
            'school_name' => 'required|min:3',
            'level' => 'required|min:2',
            'address' => 'required|min:3',
            'student_amount' => 'required|min:2',
        ]);

        $school = School::find($data['id']);
        $school->school_name = $data['school_name'];
        $school->level = $data['level'];
        $school->address = $data['address'];
        $school->student_amount = $data['student_amount'];
        $school->save();

        return redirect()->route('school.index');
    }

    public function delete($id_school)
    {
        $school = School::find($id_school);
        $school->delete();

        return redirect()->route('school.index');
    }

    public function unduhdata()
    {
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $data = School::all();

        $activeWorksheet->setCellValue('A1', 'ID');
        $activeWorksheet->setCellValue('B1', 'Nama Sekolah');
        $activeWorksheet->setCellValue('C1', 'Jenjang');
        $activeWorksheet->setCellValue('D1', 'Alamat');
        $activeWorksheet->setCellValue('E1', 'Jumlah Siswa');

        $baris = 2;
        foreach ($data as $row) {
            $activeWorksheet->setCellValue('A' . $baris, $row->id);
            $activeWorksheet->setCellValue('B' . $baris, $row->school_name);
            $activeWorksheet->setCellValue('C' . $baris, $row->level);
            $activeWorksheet->setCellValue('D' . $baris, $row->address);
            $activeWorksheet->setCellValue('E' . $baris, $row->student_amount);
            $baris++;
        }

        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="data_school.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        //$writer->save('hello world.xlsx');
        exit($writer->save('php://output'));
    }

    public function cetakword($id)
    {
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('files/template.docx'));

        $school = School::find($id);

        $templateProcessor->setValue('nama_sekolah',  $school->school_name);
        $templateProcessor->setValue('jenjang', $school->level);
        $templateProcessor->setValue('alamat', $school->address);
        $templateProcessor->setValue('jumlah_siswa', $school->student_amount);

        $file = 'school.docx';
        /*      header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save("php://output"); */

        $templateProcessor->saveAs(storage_path('files/' . $file));

        return response()->download(storage_path('files/' . $file));
    }

    public function cetakpdf($id)
    {
        PDF::SetTitle('Hello World');
        PDF::AddPage();

        $data['school'] = School::find($id);
        $html = view('school/pdf_format', $data);

        PDF::writeHTML($html, true, false, true, false, '');

        PDF::Output('school.pdf', 'D');
    }
}

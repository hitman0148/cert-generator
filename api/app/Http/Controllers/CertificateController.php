<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;

use App\Models\Lesson;
use App\Models\User;
use setasign\Fpdi\Fpdi;

class CertificateController extends Controller
{

    // public function index(Request $request)
    public function index($uid,$lid)
    {
        $res = User::where('id',$uid)->get();
        $res2 = Lesson::where('id',$lid)->get();
        Certificate::create(['user_id' => $uid, 'lesson_id' => $lid,'date_created' => now()],);
        $name = $res[0]['fname'] ." ".$res[0]['lname']; //"Ruben Pedragosa";
        $content =  $res2[0]['description']; //"Hope this code and post will helped you for implement FPDF text align – FPDF align text LEFT, Center and Right you have good idea about this post you can give it comment section. Your comment will help us for help you more and improve onlincode. we will give you this type of more interesting post";
        $outputfile = public_path().'certificate.pdf';
        $this->fillPDF(public_path(). "/certificate.pdf",$outputfile,$name,$content);

        return response()->file($outputfile);
    }

    public function fillPDF($file,$outputfile,$name,$content){
        $fpdi = new FPDI;
        $fpdi->setSourceFile($file);
        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage($size['orientation'],array($size['width'],$size['height']));
        $fpdi->useTemplate($template);
        // $fpdi->SetFont('helvetica',"",12);
       
        $fpdi->SetXY(12.6,95);

        $fpdi->SetFont('helvetica',"",30);
        $fpdi->SetTextColor(25,26,25);
        $fpdi->Cell(0,11,$name,0,10,'C');
        $fpdi->SetX(12.6);

        // $fpdi->SetXY(12.6,110);
        // $fpdi->SetFont('Arial', 'B', 16);
        // $fpdi->Cell(0,11,$content,0,10,'C');
        $fpdi->SetFont('Arial', '', 12);
        // $fpdi->MultiCell(0,11,$content,'C');
        $fpdi->SetXY(35,110);
        $fpdi->MultiCell(230,10,$content,0,'C',false);

        // $fpdi->SetX(12.6);
        // $fpdi->MultiCell(0,10,'This is MultiCell - Welcome to plus2net.com','LRTB','C',false);

        // $col1="PILOT REMARKS\n\n";
        // $fpdi->MultiCell(200, 10, $col1, 1, "C");
        // $fpdi->SetXY(30,9);
        // $col2="Pilot's\n Name \nand Signature\n".$name;
        // $fpdi->MultiCell(63, 10, $col2, 1);

        return $fpdi->Output($outputfile,'F');
    }

    public function store(Request $request)
    {
        $data = array(
            'user_id' => $request->user_id,
            'lesson_id' => $request->lesson_id,
            'date_created' => now()
        );
        Certificate::create($data);
        $msg = ['status' => 200, 'message' => 'success'];
        return response()->json($msg);
    }


    public function show($id)
    {
        return Certificate::with('user','lesson')->where('id',$id)->get();
    }

    public function showAll()
    {
        return Certificate::with('user','lesson')->get();
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        
    }
}

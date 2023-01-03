<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportPostController extends Controller
{
    public function reportForm($id)
    {
        return view('pages.report_post', ['post'=>Post::find($id)]);
    }



    public function submitReport(Request $request, $id){
       
        $report=DB::table('report_information')->where('id_user', '=', Auth::id())->where('id_content', '=', $id)->get();

        if ($report->isEmpty()){
        $reason=$request->input('reason');

        $report=array('id_content'=>$id, 'id_user'=>Auth::id(), 'reason'=> $reason, 'reviewed'=> false);
        
        DB::table('report_information')->insert($report);
        
        }
        return redirect(route('main'));    
    }
}
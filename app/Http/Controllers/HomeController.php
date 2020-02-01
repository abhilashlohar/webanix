<?php

namespace App\Http\Controllers;
use App\Student;
use App\Marksheet;
use App\User;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $student_count  = DB::table('students')->count();
        $marksheet_count = DB::table('marksheets')->count();
        $user_count     = DB::table('users')->count();
        $query2 = Student::select('marksheets.year_id',DB::raw('count(students.id) as total'));
            
                $query2->leftJoin('marksheets', function($join){
                    $join->on('marksheets.student_id', '=', 'students.id');
                });
        $student_details = $query2->groupBy('marksheets.year_id')
            ->get();
        $year_wise_student=[];
        if(!empty($student_details))
        {
            foreach($student_details as $student_detail)
            {
                @$year_wise_student[@$student_detail->year_id] = @$student_detail->total;
            }
        }
        // marksheet
        $marksheets = Marksheet::select('marksheets.year_id',DB::raw('count(marksheets.id) as total'))
            ->groupBy('marksheets.year_id')
            ->get();
        $year_wise_marksheet=[];
        if(!empty($marksheets))
        {
            foreach($marksheets as $marksheet)
            {
                @$year_wise_marksheet[@$marksheet->year_id] = @$marksheet->total;
            }
        }
        dd($year_wise_marksheet);exit;            
        return view('home',compact('student_count','marksheet_count','user_count'));
    }
}

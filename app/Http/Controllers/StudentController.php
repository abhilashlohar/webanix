<?php

namespace App\Http\Controllers;

use App\Student;
use App\Course;
use App\Stream;
use App\Year;
use App\Semester;
use App\Marksheet;
use Illuminate\Http\Request;
use DB;
use Webpatser\Uuid\Uuid;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courses = Course::all()->where('deleted', false);

        $streams = Stream::all()->where('deleted', false)
                            ->where('course_id', $request->course_id);

        $years = Year::all()->where('deleted', false);

        $semesters = Semester::all()->where('deleted', false);
        if($request->year_id)
        {
        $whereClause = ['course','stream','marksheets'=>function($query) use($request) {
            $query->where('marksheets.id','=',$request->year_id);
        }];
        }else{
            $whereClause=['course','stream','marksheets'];
        }

         $student_details = Student::with('course','stream');
         if($request->year_id || $request->session || $request->semester_id)
         {
            $student_details->join('marksheets', function ($join)use ($request) {
            $join->on('students.id', '=', 'marksheets.student_id');
                if ($request->has('year_id') and $request->year_id) {
                 $join->where('marksheets.year_id', '=', $request->year_id);
                }
                if ($request->has('session') and $request->session) {
                 $join->where('marksheets.session', '=', $request->session);
                }
                if ($request->has('semester_id') and $request->semester_id) {
                 $join->where('marksheets.semester_id', '=', $request->semester_id);
                }
            });
         }
         $students = $student_details->where(function($q) use ($request) {
                            if ($request->has('enrollment') and $request->enrollment) {
                                $q->where('enrollment', 'ILIKE', '%'.$request->enrollment.'%');
                            }
                            if ($request->has('year_id') and $request->year_id) {
                                $q->where('year_id', $request->year_id);
                            }
                            if ($request->has('name') and $request->name) {
                                $q->where('name', 'ILIKE', '%'.$request->name.'%');
                            }
                            if ($request->has('father_name') and $request->father_name) {
                                $q->where('father_name', 'ILIKE', '%'.$request->father_name.'%');
                            }
                            if ($request->has('mother_name') and $request->mother_name) {
                                $q->where('mother_name', 'ILIKE', '%'.$request->mother_name.'%');
                            }
                            if ($request->has('course_id') and $request->course_id) {
                                $q->where('course_id', '=', $request->course_id);
                            }
                            if ($request->has('stream_id') and $request->stream_id) {
                                $q->where('stream_id', '=', $request->stream_id);
                            }
                        })
                        ->distinct('students.id')
                        ->paginate(100);

        return view('students.index',compact('students', 'courses', 'request', 'streams','years','semesters'))
        ->with('i', (request()->input('page', 1) - 1) * 5);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();

        return view('students.create',compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Student::rules(), Student::messages());


        Student::create($request->all());

        return redirect()->route('students.index')
                        ->with('success','Student added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $students = Student::where('id', $id)->with('course','stream','marksheets.year','marksheets.semester')->first();
        // foreach ( $students->marksheets as $marksheet)
        // {
        //     dd($marksheet->semester->name);
        // }
        // dd($students);
        return view('students.show',compact('students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $courses = Course::all();
        $streams = Stream::where('course_id',$student->course_id)->get();

        return view('students.edit',compact('student', 'courses', 'streams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate(Student::rules($student->id), Student::messages());


        $student->update($request->all());

        return redirect()->route('students.index')
                        ->with('success','Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

	public function importmarksheet()
    {
        $courseArr=[];$stremArr=[];$semArr=[];$yrArr=[];$contentArr=[];$stuArrr=[];
        return view('students.importmarksheet',compact('courseArr', 'stremArr', 'yrArr', 'semArr', 'contentArr','stuArrr'));
    }

	public function savemarksheet(Request $request)
    {
      $courseArr=[];$stremArr=[];$semArr=[];$yrArr=[];$contentArr=[];$stuArrr=[];
	  if ($request->hasFile('marksheet_file')) {
		    $file = $request->file('marksheet_file');
            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

            if($ext!='csv')
            {
                return redirect()->route('students.importmarksheet')
                     ->with('fail','This file not a csv file.Please uploade valid file.');
                //return view('students.importmarksheet',compact('courseArr', 'stremArr', 'yrArr', 'semArr', 'contentArr','stuArrr'));
            }
		    $name = time().'-'.$file->getClientOriginalName();
		    $file_path = $file->getPathName();
		  	$csv_read_file = fopen($file_path, "r");
			$i=1;
            $arrCheck=[];
			$flag=0; $stu_upd=0; $stu_ins=0; $stuArrr['insert'] = 0;  $stuArrr['update'] = 0;
			while (($column = fgetcsv($csv_read_file, 10000, ",")) !== FALSE) {
                if($i!=1)
                {
                   //student record
                   if($column[0]=='' || $column[4]=='' || $column[6]=='')
                    {
                        return redirect()->route('students.importmarksheet')
                     ->with('fail','Data Uncomplete.Please Uploade Valid CSV File.');
                    }
                    $contentArr[] = $column;
                    $student = DB::table('students')->where('enrollment', trim($column[0]))->first();
                    if(!$student)
                    {
                        $stuArrr['insert'] = ++$stu_ins;
                    }
                    else{
                        $stuArrr['update'] = ++$stu_upd;
                    }
                    //course check
                    $course = DB::table('courses')->where('name', 'ilike',trim($column[4]))->first();

                    if(!$course)
                    {
                        $courseArr[]= $column[4];
                    }
                    else{
                        $flag=1;
                       //strem check
                        $strem = DB::table('streams')->where('name', 'ilike', trim($column[5]))->where('course_id',$course->id)->first();
                        if(!$strem)
                        {
                            $flag=1;
                            if($column[5]!=''){ $stremArr[] = $column[5];}
                        }
                    }
                    //year
                    $year = DB::table('years')->where('name', 'ilike', trim($column[6]))->first();
                    if(!$year)
                    {
                        $flag=1;
                        $yrArr[] = $column[6];
                    }
                    //semester check
                    $sem = DB::table('semesters')->where('name', 'ilike', trim($column[7]))->first();
                    if(!$sem)
                    {
                        $flag=1;
                        if($column[7]!=''){ $semArr[] = $column[7];}
                    }
                }

			$i++;
			}

            return view('students.importmarksheet',compact('courseArr', 'stremArr', 'yrArr', 'semArr', 'contentArr','stuArrr'));
	  }
	  else{

	  }

    }

    public  function saveDetail(Request $request)
    {
        $data = json_decode($request['csvdetail']);


        foreach($data as $key => $data_val)
        {

            $student = DB::table('students')->where('enrollment', trim($data_val[0]))->first();
            $course = DB::table('courses')->where('name', 'ilike',trim($data_val[4]))->first();
            if(!$course)
            {
                $course_data = [
                    'id'=>(string) Uuid::generate(4),
                    'name' => trim($data_val[4]),
                ];

                $course_info  =  Course::create($course_data);
                $courseid     = $course_info->id;
            }
            else{
                $courseid =  $course->id;
            }
            $strem = DB::table('streams')->where('name', 'ilike', trim($data_val[5]))->where('course_id',$courseid)->first();
            if(!$strem)
            {
                if($data_val[5]!='')
                {
                    $strem_data = [
                        'id'=>(string) Uuid::generate(4),
                        'course_id' => $courseid,
                        'name' => trim($data_val[5]),
                    ];

                    $strem_info =  Stream::create($strem_data);
                    $stremid    =  $strem_info->id;
                }
                else{
                    $stremid    = 0;
                }
            }
            else{
                $stremid =  $strem->id;
            }
            //year
            $year = DB::table('years')->where('name', 'ilike', trim($data_val[6]))->first();
            if(!$year)
            {
                $yr_data = [
                    'id'=>(string) Uuid::generate(4),
                    'name' => trim($data_val[6]),
                ];

                $year_info =  Year::create($yr_data);
                $yrid      =  $year_info->id;
            }
            else{
                $yrid =  $year->id;
            }

            $sem = DB::table('semesters')->where('name', 'ilike', trim($data_val[7]))->first();
            if(!$sem)
            {
                if($data_val[7]!="")
                {
                    $sem_data = [
                        'id'=>(string) Uuid::generate(4),
                        'name' => trim($data_val[7]),
                    ];

                    $sem_info =  Semester::create($sem_data);
                    $semid      =  $sem_info->id;
                }else{
                    $semid      =  0;
                }
            }
            else{
                $semid =  $sem->id;
            }


            if(!$student)
            {
                $student_data = [
                    'id'=>(string) Uuid::generate(4),
                    'enrollment' => trim($data_val[0]),
                    'name' => trim($data_val[1]),
                    'father_name' => trim($data_val[2]),
                    'mother_name' => trim($data_val[3]),
                    'course_id' => $courseid,
                    'stream_id' => $stremid,
                ];



                $stdudent_info = Student::create($student_data);
                $stdudent_id = $stdudent_info->id;

                $marksheet_data = [
                    'id'=>(string) Uuid::generate(4),
                    'year_id' => $yrid,
                    'semester_id' => $semid,
                    'student_id' => $stdudent_id,
                    'marksheet_src' => trim($data_val[0]).'-'.trim($data_val[6]).'-'.str_replace(" ","-",trim($data_val[7])).'.pdf',
                    'result' => trim($data_val[8]),
                    'session' => strtolower(trim($data_val[9]))
                ];

                Marksheet::create($marksheet_data);

            }
            else{

                //$student = Student::where('id',$student->id)->get();
                //dd($student->id);
                $student_data = [
                    'name' => $student->name,
                    'father_name' => ($data_val[2]!='')?trim($data_val[2]):$student->father_name,
                    'mother_name' => ($data_val[3]!='')?trim($data_val[3]):$student->mother_name,
                    'course_id' => $courseid,
                    'stream_id' => $stremid,
                ];
                Student::where('id', $student->id)
                    ->update($student_data);
               //$student->update($student_data);
                $marksheet = DB::table('marksheets') ->where('year_id', $yrid)->where('semester_id', $semid)->where('student_id', $student->id)->first();
                if(!$marksheet)
                {
                    $marksheet_data = [
                        'id'=>(string) Uuid::generate(4),
                        'year_id' => $yrid,
                        'semester_id' => $semid,
                        'student_id' => $student->id,
                        'marksheet_src' => trim($data_val[0]).'-'.trim($data_val[6]).'-'.str_replace(" ","-",trim($data_val[7])).'.pdf',
                        'result' => trim($data_val[8]),
                        'session' => strtolower(trim($data_val[9]))
                    ];
                    Marksheet::create($marksheet_data);
                }
                else{
                   $marksheet_data = [
                        'marksheet_src' => trim($data_val[0]).'-'.trim($data_val[6]).'-'.str_replace(" ","-",trim($data_val[7])).'.pdf',
                        'result' => trim($data_val[8]),
                    ];
                Marksheet::where('id', $marksheet->id)
                    ->update($marksheet_data);
                }

            }
        }
         return redirect()->route('students.importmarksheet')
                        ->with('success','Data import successfully.');
    }

	public function sample()
    {
      return view('students.sample');
    }

    public function report(Request $request)
    {
        //Student Count
        $query = Student::leftJoin('marksheets', function($join) use ($request)
                         {
                             $join->on('marksheets.student_id', '=', 'students.id');
                             if ($request->has('year_id') and $request->year_id) {
                              $join->where('marksheets.year_id', '=', $request->year_id);
                             }
                         });
                    if ($request->has('year_id') and $request->year_id) { 
                      $query->where('marksheets.student_id', '!=', NULL);
                    }
        $student =  $query->distinct('students.id')
                    //->get()
                    ->count();
        
        //Marksheet Count
        $marksheets = Marksheet::where(function($q) use ($request) {
                             if ($request->has('year_id') and $request->year_id) {
                                 $q->where('year_id', '=', $request->year_id);
                                }
                        })->count();
        //Result wise student count
        $results = Marksheet::select('result' ,DB::raw('count(result) as total'))
                             ->where(function($q) use ($request) {
                             if ($request->has('year_id') and $request->year_id) {
                                 $q->where('year_id', '=', $request->year_id);
                                }
                        })
                        ->groupBy('result')
                        ->get();
        
        //Session wise count of students
        $sessions = Marksheet::select('session' ,DB::raw('count(session) as total'))
                             ->where(function($q) use ($request) {
                             if ($request->has('year_id') and $request->year_id) {
                                 $q->where('year_id', '=', $request->year_id);
                                }
                        })
                        ->groupBy('session')
                        ->get();
        
        
        //Course wise student count
        $ids= [];
        if ($request->has('year_id') and $request->year_id) {
            $ids = Marksheet::select('student_id')
                             ->where(function($q) use ($request) {
                             if ($request->has('year_id') and $request->year_id) {
                                 $q->where('year_id', '=', $request->year_id);
                                }
                        })->get(); 
        } 
        $query1 = Student::select('course_id',DB::raw('count(id) as total'))
                                    ->with('course')
                                    ->groupBy('course_id');
                                    if ($request->has('year_id') and $request->year_id) {
                                        $query1->whereIn('id',$ids);
                                    }
        $course_wise_students = $query1->get();
          
        //Year wise student count
        $year_wise_students = Marksheet::select('year_id' ,DB::raw('count(student_id) as total'))
                             ->where(function($q) use ($request) {
                             if ($request->has('year_id') and $request->year_id) {
                                 $q->where('year_id', '=', $request->year_id);
                                }
                             })
                            ->with('year')
                            ->groupBy('year_id')
                            ->get();

        //Stream wise student count
        $query2 = Student::select('stream_id',DB::raw('count(id) as total'))
                                    ->with('stream')
                                    ->groupBy('stream_id');
                                    if ($request->has('year_id') and $request->year_id) {
                                        $query2->whereIn('id',$ids);
                                    }
        $stream_wise_students =$query2->get();
         
        //year list
        $years = Year::all()->where('deleted', false);
        return view('students.report',compact('student','marksheets','result_info','session_info','years','request','course_wise_students','year_wise_students','stream_wise_students','results','sessions'));
    }

    public function summery(Request $request)
    {

        $student = Student::leftJoin('marksheets', function ($join)use ($request) {
            $join->on('students.id', '=', 'marksheets.student_id');
                if ($request->has('year_id') and $request->year_id) {
                 $join->where('marksheets.year_id', '=', $request->year_id);
                }
            })
            ->distinct('students.id')
            ->get();

        $marksheets = Marksheet::where(function($q) use ($request) {
                             if ($request->has('year_id') and $request->year_id) {
                                 $q->where('year_id', '=', $request->year_id);
                                }
                        })
                        ->count();

        $result_pass = Marksheet::where('result', 'Pass')
        ->where(function($q) use ($request) {
            if ($request->has('year_id') and $request->year_id) {
                $q->where('year_id', '=', $request->year_id);
                }
        })
        ->count();

        $result_supplementary = Marksheet::where('result', 'Supplementary')
        ->where(function($q) use ($request) {
            if ($request->has('year_id') and $request->year_id) {
                $q->where('year_id', '=', $request->year_id);
                }
        })
        ->count();

        $result_fail = Marksheet::where('result', 'Fail')
        ->where(function($q) use ($request) {
            if ($request->has('year_id') and $request->year_id) {
                $q->where('year_id', '=', $request->year_id);
                }
        })
        ->count();

        $session_winter = Marksheet::where('session', 'winter')
        ->where(function($q) use ($request) {
            if ($request->has('year_id') and $request->year_id) {
                $q->where('year_id', '=', $request->year_id);
                }
        })
        ->count();

        $session_summer = Marksheet::where('session', 'summer')
        ->where(function($q) use ($request) {
            if ($request->has('year_id') and $request->year_id) {
                $q->where('year_id', '=', $request->year_id);
                }
        })
        ->count();




        /*$course_wise_students = Student::select('course_id',DB::raw('count(id) as total'))
            ->join('marksheets', function ($join)use ($request) {
            $join->on('students.id', '=', 'marksheets.student_id');
                if ($request->has('year_id') and $request->year_id) {
                 $join->where('marksheets.year_id', '=', $request->year_id);
                }
            })
            ->groupBy('course_id')
            ->distinct('students.id');*/


        $course_wise_students = Student::select('course_id',DB::raw('count(id) as total'))
                                    ->with('course')
                                    ->groupBy('course_id')
                                    ->get();

        $year_wise_students = Marksheet::select('year_id' ,DB::raw('count(student_id) as total'))
                             ->where(function($q) use ($request) {
                             if ($request->has('year_id') and $request->year_id) {
                                 $q->where('year_id', '=', $request->year_id);
                                }
                             })
                            ->with('year')
                            ->groupBy('year_id')
                            ->get();


        $stream_wise_students = Student::select('stream_id',DB::raw('count(id) as total'))
                                    ->with('stream')
                                    ->groupBy('stream_id')
                                    ->get();
        //year
        $years = Year::all()->where('deleted', false);

        return view('students.summery',compact('student','marksheets','result_pass','result_fail','result_supplementary','session_winter', 'session_summer', 'years','request','course_wise_students','year_wise_students','stream_wise_students'));
    }
}

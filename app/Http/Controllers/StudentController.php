<?php

namespace App\Http\Controllers;

use App\Student;
use App\Course;
use App\Stream;
use Illuminate\Http\Request;

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
         $streams = Stream::all()->where('deleted', false)->where('course_id', $request->course_id);

         $students = Student::with('course','stream')->where(function($q) use ($request) {
                if ($request->has('enrollment') and $request->enrollment) {
                    $q->where('enrollment', 'ILIKE', '%'.$request->enrollment.'%');
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
        })->paginate(30);

        return view('students.index',compact('students', 'courses', 'request', 'streams'))
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
        $students = Student::find($id)->with('course','stream','marksheets.year','marksheets.semester')->first();
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
}

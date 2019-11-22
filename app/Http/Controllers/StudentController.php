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
        $streams = Stream::all()->where('deleted', false);
        
        return view('students.index',compact('courses','streams'));
        
    }

    public function studentSearch(Request $request)
    {
        $courses = Course::all()->where('deleted', false);
        $streams = Stream::all()->where('deleted', false);
        $students = Student::with('course','stream')
                            ->orWhere('enrollment', $request->enrollment)
                            ->orWhere('name', 'ILIKE', '%'.$request->name.'%')
                            ->orWhere('father_name', $request->father_name)
                            ->orWhere('mother_name', $request->mother_name)
                            ->orWhere('course_id', $request->course_id)
                            ->orWhere('stream_id', $request->stream_id)
                            ->paginate(5);

        return view('students.index',compact('students','courses','streams'))
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
        //
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

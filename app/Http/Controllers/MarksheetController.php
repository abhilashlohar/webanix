<?php

namespace App\Http\Controllers;

use App\Marksheet;
use App\Semester;
use App\Year;
use App\Student;
use Illuminate\Http\Request;

class MarksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $semesters = Semester::all();
        $years = Year::all();
        $students = Student::all();
        return view('marksheets.create',compact('semesters','years','students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Marksheet::rules(), Marksheet::messages());
        $fileName = time().'.'.$request->marksheet_file->extension();  
        $request->marksheet_file->move(public_path('uploads'), $fileName);
        $request->request->add(['marksheet_src' => 'uploads/'.$fileName]);
        Marksheet::create($request->all());
   
        return back()
            ->with('success','You have successfully upload file.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marksheet  $marksheet
     * @return \Illuminate\Http\Response
     */
    public function show(Marksheet $marksheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Marksheet  $marksheet
     * @return \Illuminate\Http\Response
     */
    public function edit(Marksheet $marksheet)
    {
        $semesters = Semester::all();
        $years = Year::all();
        $students = Student::all();
        return view('marksheets.edit',compact('marksheet','semesters','years','students'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marksheet  $marksheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marksheet $marksheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marksheet  $marksheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marksheet $marksheet)
    {
        //
    }
}

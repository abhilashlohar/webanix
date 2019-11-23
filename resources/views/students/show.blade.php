@extends('layouts.dashboard')
 
@section('content')
    <div class="row">

      <div class="col-md-12">
        <div class="row mb-2">
          <div class="col-md-6 "><h4 class="screen-title float-left">Student Details</h4></div>
          <div class="col-md-6 ">
            <a href="{{ route('marksheets.create',['student_id'=>$students->id]) }}" class="btn btn-pink float-right">Upload Marksheet</a>
          </div>
        </div>
        <div class="card">
           
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <span style="color: #CCC;">Enrollment Number:</span>
                <span class="ml-2"> {{ $students->enrollment }} </span>
              </div>
              <div class="col-md-4">
                <span style="color: #CCC;">Name:</span>
                <span class="ml-2"> {{ $students->name }} </span>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-4">
                <span style="color: #CCC;">Father:</span>
                <span class="ml-2"> {{ $students->father_name }} </span>
              </div>
              <div class="col-md-4">
                <span style="color: #CCC;">Mother:</span>
                <span class="ml-2">  {{ $students->mother_name }} </span>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-4">
                <span style="color: #CCC;">Course:</span>
                <span class="ml-2">  {{ $students->course->name }} </span>
              </div>
              <div class="col-md-4">
                <span style="color: #CCC;">Stream:</span>
                <span class="ml-2">  {{ $students->stream->name }} </span>
              </div>
            </div>
            <br/>

            <div class="row">
              <div class="col-md-12">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th scope="col">Semester</th>
                      <th scope="col">Result</th>
                      <th scope="col">Year</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ( $students->marksheets as $marksheet)
                    <tr>
                      <td>{{ $marksheet->semester->name ?? '' }}</td>
                      <td>Pass</td>
                      <td>{{ $marksheet->year->name }}</td>
                      <td><a href="{{ $marksheet->marksheet_src }}">Download</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        </div>
      </div>
    </div>
@endsection
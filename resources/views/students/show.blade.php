@extends('layouts.dashboard')
 
@section('content')
    <div class="row">

      <div class="col-md-12">
        <div class="row mb-2">
          <div class="col-md-6 "><h4 class="screen-title float-left">Student Details</h4></div>
          <div class="col-md-6 ">
            <a href="{{ route('marksheets.create',['student_id'=>$students->id]) }}" class="btn btn-pink float-right">Upload New Marksheet</a>
          </div>
        </div>
        <div class="card">
           
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <span style="color: #575555;">Enrollment Number:</span>
                <span class="ml-2"> {{ $students->enrollment }} </span>
              </div>
              <div class="col-md-4">
                <span style="color: #575555;">Name:</span>
                <span class="ml-2"> {{ $students->name }} </span>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-4">
                <span style="color: #575555;">Father:</span>
                <span class="ml-2"> {{ $students->father_name }} </span>
              </div>
              <div class="col-md-4">
                <span style="color: #575555;">Mother:</span>
                <span class="ml-2">  {{ $students->mother_name }} </span>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-4">
                <span style="color: #575555;">Course:</span>
                <span class="ml-2">  {{ $students->course->name }} </span>
              </div>
              <div class="col-md-4">
                <span style="color: #575555;">Stream:</span>
                <span class="ml-2">  {{ $students->stream->name }} </span>
              </div>
            </div>
            <br/>

            <div class="row">
              <div class="col-md-12">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th scope="col">Year</th>
                      <th scope="col">Semester</th>
                      <th scope="col">Session</th>
                      <th scope="col">Result</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ( $students->marksheets as $marksheet)
                    <tr>
                      <td>{{ $marksheet->year->name }}</td>
                      <td>{{ $marksheet->semester->name ?? '-' }}</td>
                      <td>{{ $marksheet->session }}</td>
                      <td>{{ $marksheet->result }}</td>
                      <td>
                        <table>
                            <tr>
                                <td>
                                    <a class="btn btn-sm btn-light" href="{{ route('marksheets.edit',$marksheet->id) }}">Edit</a>
                                </td>
                                <td>
                                    <form action="{{ route('marksheets.destroy',$marksheet->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ asset('uploads/'.$marksheet->marksheet_src) }}" class="btn btn-sm btn-warning" download>Download</a>
                                </td>
                            </tr>
                        </table>
                      </td>
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
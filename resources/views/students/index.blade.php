@extends('layouts.dashboard')
 
@section('content')
    <div class="row">
      <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <span class="float-left">Student Search</span>
              <div class="float-right">
                <a href="{{ route('students.create') }}"> Add New Student</a>
                </div>
            </div>
            
            <div class="card-body">
                <form action="{{ route('students.index') }}" method="GET">
                  
                     <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">
                                <label>Enrollment Number</label>
                                <input type="text" name="enrollment" class="form-control">
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label>Student Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label>Father Name</label>
                                <input type="text" name="father_name" class="form-control">
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label>Mother Name</label>
                                <input type="text" name="mother_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course</label>
                                <select name="course_id" class="form-control">
                                    <option value="">---Select Course---</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stream</label>
                                <select name="stream_id" class="form-control">
                                    <option value="">---Select Stream---</option>
                                    @foreach ($streams as $stream)
                                        <option value="{{ $stream->id }}">{{ $stream->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                          <button type="submit" class="btn btn-pink">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    @if ($students ?? '')
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <span class="float-left">Student Data</span>
                </div>
                <div class="card-body">
                   <table class="table table-sm">
                        <tr>
                            <th>Name</th>
                            <th>Enrollment No.</th>
                            <th>Father Name</th>
                            <th>Mother Name</th>
                            <th>DOB</th>
                            <th>Course</th>
                            <th>Stream</th>
                        </tr>

                        @foreach ($students as $student)
                        <tr>
                            <td>
                                <a class="" href="{{ route('students.show',$student->id) }}">
                                    {{ $student->name }}
                                </a>
                            </td>
                            <td>{{ $student->enrollment }}</td>
                            <td>{{ $student->father_name }}</td>
                            <td>{{ $student->mother_name }}</td>
                            <td>{{ $student->dob }}</td>
                            <td>{{ $student->course->name }}</td>
                            <td>{{ $student->stream->name }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {!! $students->links() !!}
                </div>
            </div>
          </div>
        </div> 
    @endif
@endsection
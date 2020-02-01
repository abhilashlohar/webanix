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
                         <div class="col-md-3">
                            <div class="form-group">
                                <label>Enrollment Number</label>
                                <input type="text" name="enrollment" value="{{ $request->enrollment }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Student Name</label>
                                <input type="text" name="name" value="{{ $request->name }}" class="form-control">
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group">
                                <label>Father Name</label>
                                <input type="text" name="father_name" value="{{ $request->father_name }}" class="form-control">
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group">
                                <label>Mother Name</label>
                                <input type="text" name="mother_name" value="{{ $request->mother_name }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Course</label>
                                <select name="course_id" id="course_id" class="form-control">
                                    <option value="">---Select Course---</option>
                                    @foreach ($courses as $course)
                                        <option 
                                        value="{{ $course->id }}"
                                        {{ ( $request->course_id == $course->id ) ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Stream</label>
                                <select name="stream_id" id="stream_id" class="form-control">
                                    <option value="">---Select Stream---</option>
                                    @foreach ($streams as $stream)
                                        <option 
                                        value="{{ $stream->id }}"
                                        {{ ( $request->stream_id == $stream->id ) ? 'selected' : '' }}>{{ $stream->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Year</label>
                                <select name="year_id" id="year_id" class="form-control">
                                    <option value="">---Select Year---</option>
                                    @foreach ($years as $year)
                                        <option 
                                        value="{{ $year->id }}"
                                        {{ ( $request->year_id == $year->id ) ? 'selected' : '' }}>{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Session</label>
                                <select name="session" class="form-control">
                                    <option value="">---Select Session---</option>
                                    <option value="winter" {{ ( $request->session == 'winter' ) ? 'selected' : '' }}>Winter</option>
                                    <option value="summer" {{ ( $request->session == 'summer' ) ? 'selected' : '' }}>Summer</option>
                                </select>
                        </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Semester</label>
                                <select name="semester_id" id="year_id" class="form-control">
                                    <option value="">---Select Semester---</option>
                                    @foreach ($semesters as $semester)
                                        <option 
                                        value="{{ $semester->id }}"
                                        {{ ( $request->semester_id == $semester->id ) ? 'selected' : '' }}>{{ $semester->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary">Search</button>
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
                  <a href="{{ route('students.importmarksheet') }}" class="float-right"> Import Students</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <p>Showing total {{ $students->total() }} records</p>
                       <table class="table table-sm">
                            <tr>
                                <th>Name</th>
                                <th>Enrollment No.</th>
                                <th>Father Name</th>
                                <th>Mother Name</th>
                                <th>DOB</th>
                                <th>Course</th>
                                <th>Stream</th>
                                <th>Year</th>
                                <th>Semester</th>
                                <th>Result</th>
                                <th>Session</th>
                                <th>Action</th>
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
                                <td>{{ (date('d-m-Y', strtotime($student->dob)) != '01-01-1970') ? date('d-m-Y', strtotime($student->dob)) : "-" }}</td>
                                <td>{{ $student->course->name }}</td>
                                <td>{{ $student->stream->name ?? '-' }}</td>
                                <td>{{ $student->year{'name'} }}</td>
                                <td align="center">{{ $student->semester{'name'} }}</td>
                                <td>{{ $student->result }}</td>
                                <td>{{ $student->session }}</td>
                                <td>
                                    <a class="btn btn-sm btn-light" href="{{ route('students.edit',$student->id) }}">
                                          <i class="fas fa-edit"></i>
                                        </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        {!! $students->appends($_GET)->links() !!}
                    </div>
                </div>
            </div>
          </div>
        </div> 
    @endif
@endsection
@section('JS_Code')
<script type="text/javascript">
$( document ).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( "#course_id" ).on( "change", function() {
        var course_id = $(this).val();
        
        $.ajax({
           type:'POST',
           url:"{{ route('streams.list') }}",
           data:{course_id:course_id},
           success:function(data){
            $( "#stream_id" ).html(data);
           }
        });
    });

});
</script>
@endsection
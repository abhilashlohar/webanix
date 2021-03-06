@extends ('layouts.dashboard')

@section ('content')
<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="card">
        <div class="card-header">
          <span class="float-left">Add Marksheet</span>
          <div class="float-right">
              <a href="{{ route('students.index',$student_id) }}"> Back</a>
          </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
               
            <form action="{{ route('marksheets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_id" value="{{$student_id}}">
                 <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Year</label>
                            <select name="year_id" class="form-control">
                                <option value="">---Select Year---</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="semester_id" class="form-control">
                                <option value="">---Select Semester---</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Result</label>
                            <select name="result" class="form-control">
                                <option value="">---Select Result---</option>
                                <option value="Pass">Pass</option>
                                <option value="Fail">Fail</option>
                                <option value="Supplementary">Supplementary</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Session</label>
                            <select name="session" class="form-control">
                                <option value="">---Select Session---</option>
                                <option value="winter">Winter</option>
                                <option value="summer">Summer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Upload Marksheet</label>
                            <input type="file" name="marksheet_file" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                      <button type="submit" class="btn btn-pink">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
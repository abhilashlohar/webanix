@extends ('layouts.dashboard')

@section ('content')
<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="card">
        <div class="card-header">
          <span class="float-left">Add New Stream</span>
          <div class="float-right">
              <a href="{{ route('semesters.index') }}"> Back</a>
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
               
            <form action="{{ route('streams.store') }}" method="POST">
                @csrf
              
                 <div class="row">
                 	<div class="col-md-12">
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Stream</label>
                            <input type="text" name="name" class="form-control">
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
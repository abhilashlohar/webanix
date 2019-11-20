@extends ('layouts.dashboard')
   
@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">

        <div class="card">
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
          <div class="card-header">
            <span class="float-left">Edit Course</span>
            <div class="float-right">
                <a href="{{ route('courses.index') }}"> Back</a>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('courses.update',$course->id) }}" method="POST">
                @csrf
                @method('PUT')
              
                 <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Course</label>
                            <input type="text" name="name" value="{{ $course->name }}" class="form-control">
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
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
            <span class="float-left">Edit Stream</span>
            <div class="float-right">
                <a href="{{ route('streams.index') }}"> Back</a>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('streams.update',$stream->id) }}" method="POST">
                @csrf
                @method('PUT')
              
                 <div class="row">
                  <div class="col-md-12">
                        <div class="form-group">
                            <label>Course</label>
                            <select name="course_id" class="form-control">
                              <option value="">---Select Course---</option>
                              @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                 @if ($course->id == $stream->course_id)
                                      selected="selected"
                                  @endif
                                 >{{ $course->name }}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Stream</label>
                            <input type="text" name="name" value="{{ $stream->name }}" class="form-control">
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
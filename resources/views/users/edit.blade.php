@extends ('layouts.dashboard')
   
@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">

        <div class="card">
          <div class="card-header">
            <span class="float-left">Edit User</span>
            <div class="float-right">
                <a href="{{ route('users.index') }}"> Back</a>
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
            <form action="{{ route('users.update',$user->id) }}" method="POST">
                @csrf
                @method('PUT')
              
                 <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="{{ $user->username }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            <small id="passwordHelp" class="form-text text-muted">keep this blank, if you don't want to change the password.</small>
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
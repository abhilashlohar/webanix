@extends('layouts.dashboard')
 
@section('content')
<div class="row">
  <div class="col-md-12">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
          <span class="float-left">Years</span>
          <div class="float-right">
              <a href="{{ route('years.create') }}"> Add New</a>
          </div>
        </div>
        <div class="card-body">
           <table class="table table-sm">
                <tr>
                    <th>Name</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($years as $year)
                <tr>
                    <td>{{ $year->name }}</td>
                    <td>
                        <form action="{{ route('years.destroy',$year->id) }}" method="POST">
           
                            <a class="btn btn-sm btn-light" href="{{ route('years.edit',$year->id) }}">
                              <i class="fas fa-edit"></i>
                            </a>
           
                            @csrf
                            @method('DELETE')
              
                            <button class="btn btn-sm btn-light" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
          
            {!! $years->links() !!}
        </div>
    </div>
  </div>
</div> 
@endsection
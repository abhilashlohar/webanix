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
          <span class="float-left">Streams</span>
          <div class="float-right">
              <a href="{{ route('streams.create') }}"> Add New</a>
          </div>
        </div>
        <div class="card-body">
          @foreach ($courses as $course)
            {{ $course }}
          @endforeach
          <!--  <table class="table table-sm">
                <tr>
                    <th>Stream Name</th>
                    <th width="280px">Action</th>
                </tr>

                @foreach ($streams as $stream)
                <tr>
                    <td>{{ $stream->name }}</td>
                    <td>
                        <form action="{{ route('streams.destroy',$stream->id) }}" method="POST">
           
                            <a class="btn btn-sm btn-light" href="{{ route('streams.edit',$stream->id) }}">
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
            {!! $streams->links() !!} -->
        </div>
    </div>
  </div>
</div> 
@endsection
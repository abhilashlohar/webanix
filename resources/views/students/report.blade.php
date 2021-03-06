@extends('layouts.dashboard')
<style>
    .top-cls{
        margin-top: 1%;
    }
@media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
    width:100%
    text-align:center;  }
    .sidebar{
        disply:none;
    }
    tbody {display: table-header-group;}

}
</style>
@section('content')
<div class="row">
    <div class="col-md-12">
    <form action="{{ route('students.report') }}" method="GET">
                  
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Year</label>
                    <select name="year_id" id="year_id" class="form-control">
                        <option value="">---All years---</option>
                        @foreach ($years as $year)
                            <option 
                            value="{{ $year->id }}"
                            {{ ( $request->year_id == $year->id ) ? 'selected' : '' }}>{{ $year->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary" style="margin-top: 12%;">Search</button>
              <button type="button" onclick="myFunction()" class="btn btn-success" style="margin-top: 12%;">Print</button>
            </div>
           
        </div>
    </form>
</div>
</div>
<div id="section-to-print" style="background-color: #FFF;padding: 10px 10px;">
    <div style="width:100%;text-align:center;">
        <h3>Student Statistics</h3>
        <small>showing Statistics of {{ ($request->year_id)?$year_name->name:'All' }}</small>
    </div><hr/>
        <table class="table table-bordered">
            <tr>
                <td width="50%" align="center">
                    <div >
                      <span style="font-size: 26px;color: #4D384B;">{{ $student }}</span><br>
                      <span style="font-size: 16px;color: #4D384B;">Total Students</span>
                    </div>
                </td>
                <td width="50%" align="center">
                    <div >
                        <span style="font-size: 26px;color: #4D384B;">{{ $marksheets }}</span><br>
                        <span style="font-size: 16px;color: #4D384B;">Total Marksheets</span>
                    </div>
                </td>
            </tr>
        </table>
        
        <h4>Marksheets by result</h4>
        <table class="table table-bordered table-sm">
            @foreach($results as $result)
            <tr>
                <td width="50%">
                    <div >
                          <span style="font-size: 16px;color: #4D384B;">{{ $result->result }}</span>
                    </div>
                </td>
                <td width="50%">
                    <div >
                        <span style="font-size: 16px;color: #4D384B;">{{ $result->total }}</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        <h4>Marksheets by session</h4>
        <table class="table table-bordered table-sm">
            @foreach($sessions as $session)
            <tr>
                <td width="50%">
                    <div >
                          <span style="font-size: 16px;color: #4D384B;">{{ $session->session }}</span>
                    </div>
                </td>
                <td width="50%">
                    <div >
                        <span style="font-size: 16px;color: #4D384B;">{{ $session->total }}</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        <h4>Student by course</h4>
        <table class="table table-bordered table-sm">
            @foreach ($course_wise_students as $course_stu)
            <tr>
                <td width="50%">
                    <div >
                          <span style="font-size: 16px;color: #4D384B;">{{ $course_stu->course->name }}</span>
                    </div>
                </td>
                <td width="50%">
                    <div >
                        <span style="font-size: 16px;color: #4D384B;">{{ $course_stu->total }}</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

        <h4>Students by stream</h4>
        <table class="table table-bordered table-sm">
            <tbody>
                @foreach ($stream_wise_students as $stram_stu)
                <tr>
                    <td width="50%">
                        <div >
                              <span style="font-size: 16px;color: #4D384B;">{{ @(!empty($key[@$stram_stu->stream->name]))?$key[@$stram_stu->stream->name].' > ':''}} {{ $stram_stu->stream->name }}</span>
                        </div>
                    </td>
                    <td width="50%">
                        <div >
                            <span style="font-size: 16px;color: #4D384B;">{{ $stram_stu->total }}</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($request->year_id=='')
        <h4>Marksheets by year</h4>
        <table class="table table-bordered table-sm">
            @foreach ($year_wise_students as $yr_stu)
            <tr>
                <td width="50%">
                    <div >
                          <span style="font-size: 16px;color: #4D384B;">{{ $yr_stu->year->name }}</span>
                    </div>
                </td>
                <td width="50%">
                    <div >
                        <span style="font-size: 16px;color: #4D384B;">{{ $yr_stu->total }}</span>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
        @endif
</div>
@endsection
<script>
function myFunction() {
  window.print();
}
</script>
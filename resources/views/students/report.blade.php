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
              <button type="submit" class="btn btn-primary" style="margin-top: 12%;">Search</button>
              <button type="button" onclick="myFunction()" class="btn btn-primary" style="margin-top: 12%;">Ptint</button>
            </div>
           
        </div>
    </form>
</div>
</div>
<div id="section-to-print">
<div style="width:100%;text-align:center;"><h3>Student Statistics</h3></div><hr/>
<table width="100%" border="1">
    <tr>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
              <span style="font-size: 26px;color: #4D384B;">{{ $student }}</span><br>
              <span style="font-size: 16px;color: #4D384B;">Total Students</span>
            </div>
        </td>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                <span style="font-size: 26px;color: #4D384B;">{{ $marksheets }}</span><br>
                <span style="font-size: 16px;color: #4D384B;">Total Marksheets</span>
            </div>
        </td>
    </tr>
</table>
<h4>MarkSheet by Result</h4>
<table width="100%" border="1">
    @foreach($results as $result)
    <tr>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                  <span style="font-size: 16px;color: #4D384B;">{{ $result->result }}</span>
            </div>
        </td>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                <span style="font-size: 16px;color: #4D384B;">{{ $result->total }}</span>
            </div>
        </td>
    </tr>
    @endforeach
</table>
<h4>MarkSheet by Session</h4>
<table width="100%" border="1">
    @foreach($sessions as $session)
    <tr>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                  <span style="font-size: 16px;color: #4D384B;">{{ $session->session }}</span>
            </div>
        </td>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                <span style="font-size: 16px;color: #4D384B;">{{ $session->total }}</span>
            </div>
        </td>
    </tr>
    @endforeach
</table>
<h4>MarkSheet by Course</h4>
<table width="100%" border="1">
    @foreach ($course_wise_students as $course_stu)
    <tr>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                  <span style="font-size: 16px;color: #4D384B;">{{ $course_stu->course->name }}</span>
            </div>
        </td>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                <span style="font-size: 16px;color: #4D384B;">{{ $course_stu->total }}</span>
            </div>
        </td>
    </tr>
    @endforeach
</table>
@if($request->year_id=='')
<h4>MarkSheet by Year</h4>
<table width="100%" border="1">
    @foreach ($year_wise_students as $yr_stu)
    <tr>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                  <span style="font-size: 16px;color: #4D384B;">{{ $yr_stu->year->name }}</span>
            </div>
        </td>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                <span style="font-size: 16px;color: #4D384B;">{{ $yr_stu->total }}</span>
            </div>
        </td>
    </tr>
    @endforeach
</table>
<h4>MarkSheet by Stream</h4>
<table width="100%" border="1">
     @foreach ($stream_wise_students as $stram_stu)
    <tr>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                  <span style="font-size: 16px;color: #4D384B;">{{ $stram_stu->stream->name }}</span>
            </div>
        </td>
        <td width="50%">
            <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
                <span style="font-size: 16px;color: #4D384B;">{{ $stram_stu->total }}</span>
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
@extends('layouts.dashboard')
<style>
    .top-cls{
        margin-top: 1%;
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
            </div>
        </div>
    </form>
</div>
</div>
<div class="row">
  <div class="col-md-4">
    <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
      <span style="font-size: 40px;color: #FF6468;">{{ $student->count() }}</span><br>
      <span style="font-size: 16px;color: #4D384B;">No of Students</span>
    </div>
  </div>
  <div class="col-md-4">
      <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
        <span style="font-size: 40px;color: #FF6468;">{{ $marksheets->count() }}</span><br>
        <span style="font-size: 16px;color: #4D384B;">No of Marksheets</span>
      </div>
  </div>
  <div class="col-md-4">
      <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
        <span style="font-size: 40px;color: #FF6468;">{{ (!empty($result_info['Pass']))?$result_info['Pass']:'0' }}</span><br>
        <span style="font-size: 16px;color: #4D384B;">Total Passed</span>
      </div>
  </div>
</div>
   <div class="row ">
    <div class="col-md-4 top-cls">
      <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
        <span style="font-size: 40px;color: #FF6468;">{{ (!empty($result_info['Fail']))?$result_info['Fail']:'0' }}</span><br>
        <span style="font-size: 16px;color: #4D384B;">Total Failed</span>
      </div>
    </div>
    <div class="col-md-4 top-cls">
      <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
        <span style="font-size: 40px;color: #FF6468;">{{ (!empty($result_info['Supplementary']))?$result_info['Supplementary']:'0' }}</span><br>
        <span style="font-size: 16px;color: #4D384B;">Total Supplementary</span>
      </div>
    </div>
    <div class="col-md-4 top-cls">
      <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
        <span style="font-size: 40px;color: #FF6468;">{{ (!empty($session_info['summer']))?$session_info['summer']:'0' }}</span><br>
        <span style="font-size: 16px;color: #4D384B;">Summer</span>
      </div>
    </div>
   </div>
   <div class="row ">
    <div class="col-md-4 top-cls">
      <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
        <span style="font-size: 40px;color: #FF6468;">{{ (!empty($session_info['winter']))?$session_info['winter']:'0' }}</span><br>
        <span style="font-size: 16px;color: #4D384B;">Winter</span>
      </div>
    </div>
    @foreach ($course_wise_students as $course_stu)
       <div class="col-md-4 top-cls">
          <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
            <span style="font-size: 40px;color: #FF6468;">{{ $course_stu->total }}</span><br>
            <span style="font-size: 16px;color: #4D384B;">{{ $course_stu->course->name }}</span>
          </div>
        </div>
    @endforeach
    @foreach ($year_wise_students as $yr_stu)
     <div class="col-md-4 top-cls">
          <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
            <span style="font-size: 40px;color: #FF6468;">{{ $yr_stu->total }}</span><br>
            <span style="font-size: 16px;color: #4D384B;">{{ $yr_stu->year->name }}</span>
          </div>
        </div>
    @endforeach
    @foreach ($stream_wise_students as $stram_stu)
     <div class="col-md-4 top-cls">
          <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
            <span style="font-size: 40px;color: #FF6468;">{{ $stram_stu->total }}</span><br>
            <span style="font-size: 16px;color: #4D384B;">{{ $stram_stu->stream->name }}</span>
          </div>
        </div>
    @endforeach
   </div>
@endsection
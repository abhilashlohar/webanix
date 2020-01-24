@extends('layouts.dashboard')
<style>
    .top-cls{
        margin-top: 1%;
    }
</style>
@section('content')
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
   <div class="row top-cls">
    <div class="col-md-4">
      <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
        <span style="font-size: 40px;color: #FF6468;">{{ (!empty($result_info['Fail']))?$result_info['Fail']:'0' }}</span><br>
        <span style="font-size: 16px;color: #4D384B;">Total Failed</span>
      </div>
    </div>
    <div class="col-md-4">
      <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
        <span style="font-size: 40px;color: #FF6468;">{{ (!empty($result_info['Supplementary']))?$result_info['Supplementary']:'0' }}</span><br>
        <span style="font-size: 16px;color: #4D384B;">Total Supplementary</span>
      </div>
    </div>
    <div class="col-md-4">
      <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
        <span style="font-size: 40px;color: #FF6468;">{{ (!empty($session_info['summer']))?$session_info['summer']:'0' }}</span><br>
        <span style="font-size: 16px;color: #4D384B;">Summer</span>
      </div>
    </div>
   </div>
   <div class="row top-cls">
    <div class="col-md-4">
      <div align="center" style="background-color: #FFF;border-radius: 5px;border: solid 1px #cccccc;">
        <span style="font-size: 40px;color: #FF6468;">{{ (!empty($session_info['winter']))?$session_info['winter']:'0' }}</span><br>
        <span style="font-size: 16px;color: #4D384B;">Winter</span>
      </div>
    </div>
    
   </div>
@endsection
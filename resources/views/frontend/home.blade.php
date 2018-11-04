<!--Extends parent app template-->
@extends('frontend.layout.app')
<!--Content insert section-->
@section('content')
<style type="text/css">
    .starting_tet{
        float: left;
        margin-left: 2%;
        margin-top: 1%;
    }
    .main_heading{
        font-size: 35px;
        line-height: 20px;
        font-weight: bold;
        color: white;
    }
    .subtext{
        font-size: 20px;
        line-height: 20px;
        font-weight: bold;
        color: #FFE500;
    }
    .jumbo_modified{
        background-color: rgba(0, 0, 0, 0.5);
        /*background-color: #C8C8C8;*/
        left: 20px;
        margin-bottom: 0;
        padding: 45px 10px 60px 10px;
        /*position: absolute;*/
        top: 10px;
        z-index: 100;
        width: 100%;
        margin-top: 15%;
    }
</style>
<!-- Main component for a primary marketing message or call to action -->
<div class="jumbotron jumbo_modified">
    <div class="row">
        <div class="col-md-12">            
            <div class="text-center">
                <h4 class="main_heading">Welcome to Planning Information System (PLIS)</h4>
            </div>
        </div>
    </div>
</div>
@endsection
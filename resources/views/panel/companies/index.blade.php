@extends('panel.layout.app')
@section('head')
@php
$title="الشركات";
@endphp
@endsection
@section('content')

<ul class="breadcrumb pb30">
    <li><a href="#">الرئيسية</a></li>
    <li class="active">الشركات</li>
</ul>

@session('message')
<div class="alert alert-success alert-dismissible shadow" data-sr="wait 0s, then enter bottom and hustle 100%">
    <button type="button" class="close pull-left" data-dismiss="alert">×</button>
    <h4 class="text-lg"><i class="fa fa-check icn-xs"></i> تم بنجاح ...</h4>
    <p>{{$value}}</p>
</div>
@endsession

<form action="{{url()->current()}}" class="form-horizontal" method="GET">
    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
        <div class="col-lg-12 input-grup">
            <i class="fa fa-search-plus"></i>
          <input type="text" name="q" value="{{isset($_GET['q'])?$_GET['q']:""}}" class="form-control text-right" placeholder="ابحث عن شى؟" />
        </div>
      </div>
</form>

<table id="no-more-tables" class="table table-bordered" role="table">
   
    <thead>
        <tr>
            <th width="20%" class="text-right">الاسم</th>
            <th width="20%" class="text-right">الرابط</th>
             <th width="20%" class="text-right">اسم المدير</th>
            <th width="20%" class="text-right">رقم هاتف </th>
            <th width="30%" class="text-right">التحكم</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($companies as $value)
        <tr>
            <td data-title="الاسم">{{$value->name}}</td>
            <td data-title="الرابط">{{$value->url?$value->url:"لا يوجد رابط"}}</td>
            <td data-title="اسم المدير">{{$value->name_manager}}</td>
            <td data-title="رقم هاتف ">{{$value->phone_manager}}</td>
            <td data-title="التحكم" class="text-center">
                <a href="{{route('companies.show',$value->id)}}" class="btn btn-default btn-xs"><i class="fa fa-pencil-square"></i>متابعة</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="col-xs-12 mt30 text-center">
    {{$companies->onEachSide(4)->links()}}
</div>
@endsection

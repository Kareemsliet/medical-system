@extends('panel.layout.app')
@section('head')
    @php
        $title = 'الشركات-اضافة';
    @endphp
@endsection

@section('content')
    <ul class="breadcrumb pb30">
        <li><a href="#">الرئيسية</a></li>
        <li class="active">الشركات</li>
        <li class="active">اضافة</li>
    </ul>

    @session('message')
        <div class="alert alert-success alert-dismissible shadow" data-sr="wait 0s, then enter bottom and hustle 100%">
            <button type="button" class="close pull-left" data-dismiss="alert">×</button>
            <h4 class="text-lg"><i class="fa fa-check icn-xs"></i> تم بنجاح ...</h4>
            <p>{{ $value }}</p>
        </div>
    @endsession

    <div class="well bs-component" data-sr="wait 0s, then enter left and hustle 100%">

        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ route('companies.store') }}">
            @csrf
            @method('POST')

            <fieldset>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">اسم الشركة</label>
                    <div class="col-lg-10 input-grup">
                        <i class="fa fa-user"></i>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control text-right"
                            placeholder="اسم الشركة">
                        @error('company_name')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">رابط الشركة</label>
                    <div class="col-lg-10 input-grup">
                        <i class="fa fa-user"></i>
                        <input type="text" name="url" value="{{ old('url') }}" class="form-control text-right"
                            placeholder="رابط الشركة">
                        @error('url')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">اسم المدير</label>
                    <div class="col-lg-10 input-grup">
                        <i class="fa fa-user"></i>
                        <input type="text" name="name_manager" value="{{ old('name_manager') }}"
                            class="form-control text-right" placeholder="اسم المدير">
                        @error('name_manager')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">رقم هاتف المدير</label>
                    <div class="col-lg-10 input-grup">
                        <i class="fa fa-user"></i>
                        <input type="text" name="phone_manager" value="{{ old('phone_manager') }}"
                            class="form-control text-right" placeholder="رقم هاتف المدير">
                        @error('phone_manager')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">اسم الادمن</label>
                    <div class="col-lg-10 input-grup">
                        <i class="fa fa-user"></i>
                        <input type="text" name="admin_name" value="{{ old('admin_name') }}"
                            class="form-control text-right" placeholder="اسم الادمن">
                        @error('admin_name')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">البريد الاكتروني</label>
                    <div class="col-lg-10 input-grup">
                        <i class="fa fa-user"></i>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control text-right"
                            placeholder="البريد الاكتروني">
                        @error('email')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.3s, then enter bottom and hustle 100%">
                    <label for="select" class="col-lg-2 control-label">الاشتراكات</label>
                    <div class="col-lg-10">
                        <select class="form-control"  name="plan_id" data-title="أختر   الشتراك الخاص بالشركة">
                            <option value="">اختر اشتراك شهري</option>
                            @foreach ($plans as $value)
                                <option @if ($value->id==old('plan_id'))
                                  @selected(true)
                                @endif value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        @error('plan_id')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">كلمة السر</label>
                    <div class="col-lg-10 input-grup">
                        <i class="fa fa-user"></i>
                        <input type="password" name="password" value="{{ old('password') }}"
                            class="form-control text-right" placeholder="كلمة السر">
                        @error('password')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">اعادة كلمة السر</label>
                    <div class="col-lg-10 input-grup">
                        <i class="fa fa-user"></i>
                        <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                            class="form-control text-right" placeholder="كلمة السر">
                        @error('password_confirmation')
                            <span class="help-block text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="form-group" data-sr="wait 0.3s, then enter bottom and hustle 100%">
                    <div class="col-xs-10 col-xs-pull-2">
                        <button type="reset" class="btn btn-default">أبدء من جديد ؟</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </div>

            </fieldset>

        </form>

    </div>
@endsection

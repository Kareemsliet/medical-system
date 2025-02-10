@extends('panel.layout.app')
@section('head')
    @php
        $title = 'الشركات-عرض';
    @endphp
@endsection

@section('content')
    <ul class="breadcrumb pb30">
        <li><a href="#">الرئيسية</a></li>
        <li class="active">الشركات</li>
        <li class="active">عرض</li>
    </ul>

    @session('message')
        <div class="alert alert-success alert-dismissible shadow" data-sr="wait 0s, then enter bottom and hustle 100%">
            <button type="button" class="close pull-left" data-dismiss="alert">×</button>
            <h4 class="text-lg"><i class="fa fa-check icn-xs"></i> تم بنجاح ...</h4>
            <p>{{ $value }}</p>
        </div>
    @endsession

    <div class="well bs-component" data-sr="wait 0s, then enter left and hustle 100%">

        <div class="form-horizontal">
            <fieldset>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">اسم الشركة</label>
                    <div class="col-lg-10 input-grup">
                        {{ $company->name }}
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">رابط الشركة</label>
                    <div class="col-lg-10 input-grup">
                        {{ $company->url ? $company->url : 'لا يوجد رابط' }}
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">رقم هاتف المدير</label>
                    <div class="col-lg-10 input-grup">
                        {{ $company->phone_manager ? $company->phone_manager : 'لا يوجد رقم هاتف' }}
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">اسم المدير</label>
                    <div class="col-lg-10 input-grup">
                        {{ $company->name_manager ? $company->name_manager : 'لا يوجد اسم مدير' }}
                    </div>
                </div>

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">اسم الاشتراك/الحالة</label>
                    <div class="col-lg-10 input-grup">
                        {{ $company->planSubscription('main')->plan->name }} /
                        @if ($company->planSubscription('main')->ended())
                            {{ 'منتهي' }}
                        @else
                            {{ ' مفعلة' }}
                        @endif
                    </div>
                </div>

                @if ($company->planSubscription('main')->active())
                    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                        <label for="inputUser" class="col-lg-2 control-label">تاريخ اضافة الاشترك</label>
                        <div class="col-lg-10 input-grup">
                            {{ $company->planSubscription('main')->created_at->format('Y-m-d') }}
                        </div>
                    </div>

                    @if ($company->planSubscription('main')->plan->hasTrial())
                        <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                            <label for="inputUser" class="col-lg-2 control-label">موعد انتهاء الفترة المجانية</label>
                            <div class="col-lg-10 input-grup">
                                {{ $company->planSubscription('main')->trial_ends_at->format('Y-m-d') }}
                            </div>
                        </div>
                    @endif


                    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                        <label for="inputUser" class="col-lg-2 control-label">بداية الاشتراك</label>
                        <div class="col-lg-10 input-grup">
                            {{ $company->planSubscription('main')->starts_at->format('Y-m-d') }}
                        </div>
                    </div>

                    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                        <label for="inputUser" class="col-lg-2 control-label">نهاية الاشتراك</label>
                        <div class="col-lg-10 input-grup">
                            {{ $company->planSubscription('main')->ends_at->format('Y-m-d') }}
                        </div>
                    </div>
                @endif

                <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
                    <label for="inputUser" class="col-lg-2 control-label">التحكم</label>
                    <div class="col-lg-10 input-grup">
                      
                        @if ($company->planSubscription('main')->ended())
                            <a href="{{ route('supscriptions.update', $company->id) }}"
                                onclick="event.preventDefault();document.getElementById('form-update').submit()"
                                class="btn btn-danger btn-xs">تجديد الاشتراك</a>
                            <form id="form-update" action="{{ route('supscriptions.update', $company->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('POST')
                            </form>
                            @else
                              <a href="{{ route('supscriptions.cancel', $company->id) }}"
                                onclick="event.preventDefault();document.getElementById('form-cancel').submit()"
                                class="btn btn-danger btn-xs">الغاء الاشتراك</a>
                            <form id="form-cancel" action="{{ route('supscriptions.cancel', $company->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('POST')
                            </form>
                        @endif
                    </div>
                </div>

            </fieldset>

        </div>

    </div>
@endsection

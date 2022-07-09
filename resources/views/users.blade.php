@extends('layout')
@section('title', 'Пользователи')
@section('content')
<main id="js-page-content" role="main" class="page-content mt-3">
            @if(!empty($flash))
            <div class="alert alert-success">
                {{$flash}}
            </div>
            @endif
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-users'></i> Список пользователей
                </h1>
            </div>
            <div class="row">
                <div class="col-xl-12">
                @if(Auth::user()->admin)
                    <a class="btn btn-success" href="{{route('create')}}">Добавить</a>
                @endif
                    <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                        <input type="text" id="js-filter-contact" name="filter-contact" class="form-control shadow-inset-2 form-control-lg" placeholder="Найти пользователя">
                        <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                            <label class="btn btn-default active">
                                <input type="radio" name="contactview" id="grid" checked="" value="grid"><i class="fas fa-table"></i>
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="js-contact">
            @php
                $i = 1;
            @endphp

                @foreach($contacts as $contact)
                <div class="col-xl-4">
                    <div id="c_{{$i}}" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="{{mb_strtolower($contact->name)}}">
                        
                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                            <div class="d-flex flex-row align-items-center">
                                    @php
                                    $status = '';
                                    switch ($contact->status){
                                        case 'Онлайн':
                                            $status = 'success';
                                            break;
                                        case 'Отошёл':
                                            $status = 'dark';
                                            break;
                                        case 'Не беспокоить':
                                            $status = 'danger';
                                            break;
                                    }
                                    @endphp
                                    <span class="status status-{{ $status }} mr-3">
                                        <a href="{{ route('profile', ['id' => $contact->user->id]) }}">
                                            <span class="rounded-circle profile-image d-block " style="background-image:url('{{$contact->img}}'); background-size: cover;"></span>
                                        </a>
                                    </span>
                                
                                <div class="info-card-text flex-1">
                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false" style="{{$contact->user_id == Auth::id() ? 'color: blue !important;' : ''}}">
                                        {{$contact->name}}
                                        @if($contact->user_id == Auth::id() || Auth::user()->admin)
                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                        @endif
                                    </a>
                                    @if($contact->user_id == Auth::id() || Auth::user()->admin)
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('edit', ['id' => $contact->user->id]) }}">
                                            <i class="fa fa-edit"></i>
                                        Редактировать</a>
                                        <a class="dropdown-item" href="{{ route('security', ['id' => $contact->user->id]) }}">
                                            <i class="fa fa-lock"></i>
                                        Безопасность</a>
                                        <a class="dropdown-item" href="{{ route('status', ['id' => $contact->user->id]) }}">
                                            <i class="fa fa-sun"></i>
                                        Установить статус</a>
                                        <a class="dropdown-item" href="{{ route('image', ['id' => $contact->user->id]) }}">
                                            <i class="fa fa-camera"></i>
                                        Загрузить аватар
                                        </a>
                                        <a href="{{ route('delete', ['id' => $contact->user->id]) }}" class="dropdown-item" onclick="return confirm('are you sure?');">
                                            <i class="fa fa-window-close"></i>
                                        Удалить
                                        </a>
                                    </div>
                                    @endif
                                    <span class="text-truncate text-truncate-xl">{{$contact->position}}</span>
                                </div>
                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_{{$i}} > .card-body + .card-body" aria-expanded="false">
                                    <span class="collapsed-hidden">+</span>
                                    <span class="collapsed-reveal">-</span>
                                </button>
                                @php
                                    $i++;
                                @endphp
                            </div>
                        </div>
                        <div class="card-body p-0 collapse show">
                            <div class="p-3">
                                <a href="tel:{{$contact->phone}}" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mobile-alt text-muted mr-2"></i>{{$contact->phone}}</a>
                                <a href="mailto:{{$contact->user->email}}" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i>{{$contact->user->email}}</a>
                                <address class="fs-sm fw-400 mt-4 text-muted">
                                    <i class="fas fa-map-pin mr-2"></i>{{$contact->address}}
                                </address>
                                <div class="d-flex flex-row">
                                    <a href="{{$contact->vk}}" target="_blank" class="mr-2 fs-xxl" style="color:#4680C2">
                                        <i class="fab fa-vk"></i>
                                    </a>
                                    <a href="{{$contact->telegram}}" target="_blank" class="mr-2 fs-xxl" style="color:#38A1F3">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                    <a href="{{$contact->instagram}}" target="_blank" class="mr-2 fs-xxl" style="color:#E1306C">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
     
        <!-- BEGIN Page Footer -->
        <footer class="page-footer" role="contentinfo">
            <div class="d-flex align-items-center flex-1 text-muted">
                <span class="hidden-md-down fw-700">2022 © База</span>
            </div>
        </footer>
        <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value == 'grid')
                    {
                        $('#js-contact .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contact .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contact .js-expand-btn').addClass('d-none');
                        $('#js-contact .card-body + .card-body').addClass('show');

                    }
                    else if (this.value == 'table')
                    {
                        $('#js-contact .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contact .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contact .js-expand-btn').removeClass('d-none');
                        $('#js-contact .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contact'), $('#js-filter-contact'));
        });

    </script>
@endsection
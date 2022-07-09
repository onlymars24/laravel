@extends('layout')
@section('title', 'Редактировать')
@section('content')
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-plus-circle'></i> Редактировать
            </h1>

        </div>
        <form action="{{route('edit-act', ['id' => $contact->user_id])}}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Общая информация</h2>
                            </div>
                            <div class="panel-content">
                                <!-- username -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Имя</label>
                                    <input type="text" id="simpleinput" name="name" class="form-control" value="{{$contact->name}}" style="{{ $errors->first('name') ? 'border: 1px red solid;' : '' }}">
                                    @if(!empty($errors->first('name')))
                                        <label style="color: red; display: block;" for="simpleinput">{{ $errors->first('name') }}</label>
                                    @endif
                                </div>

                                <!-- title -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Должность</label>
                                    <input type="text" id="simpleinput" name="position" class="form-control" value="{{$contact->position}}">
                                </div>

                                <!-- tel -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Номер телефона</label>
                                    <input type="text" id="simpleinput" name="phone" class="form-control" value="{{$contact->phone}}">
                                </div>

                                <!-- address -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Адрес</label>
                                    <input type="text" id="simpleinput" name="address" class="form-control" value="{{$contact->address}}">
                                </div>
                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Редактировать</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

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
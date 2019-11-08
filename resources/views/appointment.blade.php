@extends('layouts.app')

@section('content')
    <div class="row justify-content-center py-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Schedule an Appointment</div>

                <div class="card-body">
                    @if (session('status') || session('message'))
                        <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger'}}">
                            {{ session('message') }}
                        </div>
                    @endif
                    <form action="{{ route('appointment.store') }}" method="POST" class="row">
                        <div class="form-group col-md-12">
                            Pet Information
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Gender</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Breed</label>
                            <input type="text" name="breed" class="form-control @error('breed') is-invalid @enderror" value="{{ old('breed') }}">
                            @error('breed')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Color</label>
                            <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('name') }}">
                            @error('color')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Species</label>
                            <select name="species" class="form-control @error('species') is-invalid @enderror">
                                <option value="1">Bovine</option>
                                <option value="2">Camelid</option>
                                <option value="3">Canine</option>
                                <option value="4">Caprine</option>
                                <option value="5">Cavies</option>
                                <option value="6">Cervidae</option>
                                <option value="7">Equine</option>
                                <option value="8">Feline</option>
                                <option value="9">Lapine</option>
                                <option value="10">Murine</option>
                                <option value="11">Ovine</option>
                                <option value="12">Piscine</option>
                                <option value="13">Porcine</option>
                            </select>
                            @error('species')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Date of Birth</label>
                            <div class="input-group date" id="dateOnly" data-target-input="nearest">
                                <input type="text" name="date_birth" class="form-control @error('date_birth') is-invalid @enderror datetimepicker-input" data-target="#dateOnly"/>
                                <div class="input-group-append" data-target="#dateOnly" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>

                                @error('date_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <hr>
                        </div>
                            <div class="form-group col-md-12">
                            <label for="">Appointment Time</label>
                            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                <input type="text" name="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror datetimepicker-input" data-target="#datetimepicker1">
                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @error('appointment_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Message</label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror"></textarea>
                            @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <hr>
                        </div>
                        <div class="form-group col-md-12">
                            @csrf
                            <button class="btn btn-primary">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#datetimepicker1').datetimepicker({
            minDate: new Date(),
            daysOfWeekDisabled : [0],
        });
        $('#dateOnly').datetimepicker({
            maxDate: new Date(),
            format: 'L',
        });
    </script>
@endsection

@extends('master.back')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class=" mb-0"><b>{{ __('Courier Information') }}</b></h3>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="row">
            <div class="container mt-3">
                <form action="{{route('back.setting.courier.update')}}" method="post">
                    @csrf
                    <div class="mb-3 mt-3">
                        <label for="email">Message:</label>
                        <textarea type="email" class="form-control" cols="8" rows="8" id="email"
                                  placeholder="Enter message"
                                  name="courier_message">{!! $courier->courier_message !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

        </div>

@endsection

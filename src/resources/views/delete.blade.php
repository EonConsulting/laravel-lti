@extends('layouts.app')

@section('custom-styles')
    <style>
        .thumbnail {
            position: relative;
            padding: 0px;
            margin-bottom: 20px;
        }

        .thumbnail img {
            width: 100%;
        }

        .card {
            background: #FFF;
            padding: 40px 20px 20px 20px;
            overflow-y: auto;
            margin-top: 50px;
        }

    </style>
@endsection

@section('content')
    <div class="container-fluid" id="app-install">

        <div class="row">
            <div class="col-md-12">
                @if (session('error_message'))
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            {{ session('error_message') }}
                        </div>
                    </div>
                @endif

                @if (session('success_message'))
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            {{ session('success_message') }}
                        </div>
                    </div>
                @endif

                @if($errors->count() > 0)
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">

            <div class="col-md-3"></div>

            <div class="col-md-6">
                <div class="card shadow">
                    <form class="form" method="POST" action="{{ route('eon.laravellti.delete', $context->context_id) }}">

                        <div class="col-md-12">
                            <p>Are you sure you want to delete the <strong>{{ $context->title }}</strong> tool?</p>
                        </div>

                        <div class="col-md-12">
                            <hr />
                        </div>

                        <div class="col-md-12">
                            <div class="form-group pull-left">
                                <a href="{{ url()->previous() }}" class="btn btn-primary">Cancel</a>
                            </div>

                            <div class="form-group pull-right">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>

                        {{ csrf_field() }}
                    </form>

                </div>

            </div>

            <div class="col-md-3"></div>
        </div> <!-- /row -->
    </div> <!-- /container -->
@endsection

@section('custom-scripts')
@endsection

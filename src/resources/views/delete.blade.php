@extends('layouts.app')

@section('custom-styles')
    <link href="/vendor/laravellti/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        .thumbnail {
            position: relative;
            padding: 0px;
            margin-bottom: 20px;
        }

        .thumbnail img {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container" id="app-install">

        <div class="row">
            <div class="col-md-12">
                <h1>EON LTI - Delete a LTI Tool</h1>
                <br />
                <br />
            </div>
        </div>

        <div class="row">
            <form class="form-horizontal" method="POST" action="{{ route('eon.laravellti.delete', $context->context_id) }}">

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

                <div class="form-group" style="border: 1px solid #e7e7e7; background: #f8f8f8;padding: 10px 5px;">
                    <div class="col-md-10">
                        <p>Are you sure you want to delete the <strong>{{ $context->title }}</strong> tool?</p>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">Delete</button>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-4">
                    <hr />
                </div>

                <div class="clearfix"></div>

                <div class="col-md-2">
                    <a a href="{{ url()->previous() }}" class="btn btn-primary btn-block">Cancel</a>
                </div>

                <div class="clearfix"></div>

                {{ csrf_field() }}
            </form>

        </div>

    </div> <!-- /row -->

    </div> <!-- /container -->
@endsection

@section('custom-scripts')
    <script src="/vendor/laravellti/js/jquery.min.js"></script>
    <script src="/vendor/laravellti/js/bootstrap.min.js"></script>
@endsection
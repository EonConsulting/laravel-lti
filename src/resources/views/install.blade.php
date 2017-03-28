@extends('layouts.lecturer')

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
                <h1>EON LTI - Add a new LTI Tool</h1>
                <br />
                <br />
            </div>
        </div>

        <div class="row">
                <form class="form-horizontal" method="POST" action="{{ route('eon.laravellti.install') }}">

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

                    <div class="form-group">
                        <div class="col-md-6">
                            <label>Key</label>
                            <input type="text" placeholder="Key" name="key" class="form-control" value="{{ old('key') }}"/>
                        </div>
                        <div class="col-md-6">
                            <label>Secret</label>
                            <input type="text" placeholder="Secret" name="secret" class="form-control" value="{{ old('secret') }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Title</label>
                            <input type="text" placeholder="Title" name="title" class="form-control" value="{{ old('title') }}"/>
                        </div>
                        <div class="col-md-8">
                            <label>Launch URL</label>
                            <input type="text" placeholder="Launch URL" name="launch_url" class="form-control" value="{{ old('launch_url') }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-10">
                            <label>Config URL</label>
                            <input type="text" placeholder="Config URL" name="config_url" class="form-control" value="{{ old('config_url') }}"/>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">GO!</button>
                        </div>
                    </div>

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
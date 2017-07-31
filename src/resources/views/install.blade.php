@extends('layouts.app')

@section('custom-styles')
    <link href="/vendor/laravellti/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

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
            padding: 20px;
            overflow-y: auto;
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
            <form class="form" method="POST" action="{{ route('eon.laravellti.install') }}">
                <div class="col-md-12">
                    <div class="card shadow">

                            <div class="col-md-12">
                                <h3>Enter App Details</h3>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>LTI Tool Logo</label>
                                    <input type="text" placeholder="Enter a Logo URL e.g http://logourl.co/logo.png" name="logo_uri" class="form-control" value="{{ old('logo_uri') }}"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Key</label>
                                    <input type="text" placeholder="Key" name="key" class="form-control" value="{{ old('key') }}"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Secret</label>
                                    <input type="text" placeholder="Secret" name="secret" class="form-control" value="{{ old('secret') }}"/>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" placeholder="Title" name="title" class="form-control" value="{{ old('title') }}"/>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Config URL</label>
                                    <input type="text" placeholder="Config URL" name="config_url" class="form-control" value="{{ old('config_url') }}"/>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Launch URL</label>
                                    <input type="text" placeholder="Launch URL" name="launch_url" class="form-control" value="{{ old('launch_url') }}"/>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label>Application Category</label>
                                <select class="form-control select" name="categories">
                                    @foreach ($categories as $category)
                                    <option value="{{$category['id']}}">{{$category['title']}}</option>
                                    @endforeach
                                </select>
                            <div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">GO!</button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                    {{ csrf_field() }}
            </form>
            </div>
        </div> <!-- /row -->
    </div> <!-- /container -->
    <script type="text/javascript">
        $('#select').select2({
            placeholder: "Select App Category",
            allowClear: true
        });

    </script>
@endsection

@section('custom-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="/vendor/laravellti/js/jquery.min.js"></script>
    <script src="/vendor/laravellti/js/bootstrap.min.js"></script>
@endsection

@extends('layouts.app')

@section('custom-styles')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            @if (session('error_message'))
                <div class="alert alert-danger">
                    {{ session('error_message') }}
                </div>
            @endif

            @if (session('success_message'))
                <div class="alert alert-success">
                    {{ session('success_message') }}
                </div>
            @endif

            @if($errors->count() > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('eon.laravellti.cats.create') }}" method="post" >
                {{csrf_field()}}
                <div class="form-group">
                    <label for="Title">Title</label>
                    <input type="title" name="title" class="form-control" id="title" placeholder="title">
                </div>
                <div class="form-group">
                    <label for="Description">Category Description</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="tags">Tags</label>
                    <input type="tags" name="tags" class="form-control" id="tags" placeholder="Comma Separated tags">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Categories<div class="col-md-8 pull-right"><input type="text" id="txt_search" class="form-control" onkeyup="search()" placeholder="Search Categories"></div><div class="clearfix"></div></div>
                <table class="panel-body table table-hover table-striped" id="courses-table">
                    <thead>
                    <tr>
                        <th class="col-md-1">#</th>
                        <th class="col-md-5">Title</th>
                        <th class="col-md-2">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->title }}</td>
                            <td><a href="{{ route('eon.laravellti.delete', $category->id) }}" class="btn btn-danger btn-xs">Delete</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <script src="{{url('/js/app.js')}}"></script>
    <script src="{{url('/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.js')}}"></script>
@endsection

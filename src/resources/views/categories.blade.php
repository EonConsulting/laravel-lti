@extends('layouts.app')

@section('custom-styles')

@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <input type="hidden" id="tok" value="{{ csrf_token() }}" />
                <div class="panel panel-default">
                    <div class="panel-heading">Categories <a href="{{ route('eon.laravellti.cats.create') }}" class="btn btn-primary btn-xs"><span class="fa fa-plus"></span></a><div class="col-md-6 pull-right"><input type="text" id="txt_search" class="form-control" onkeyup="search()" placeholder="Search Categories.."></div><div class="clearfix"></div></div>
                    <table class="panel-body table table-hover table-striped" id="courses-table">
                        <thead>
                        <tr>
                            <th class="col-md-1">#</th>
                            <th class="col-md-2">Title</th>
                            <th class="col-md-3">Owner</th>
                            <th class="col-md-4">Date Created</th>
                            <th class="col-md-2">Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category['title'] }}</td>
                                <td>{{ $category->creator['name'] }}</td>
                                <td>{{ $category['created_at'] }}</td>
                                <td><a href="{{ route('eon.laravellti.cats.delete', $category['id']) }}" class="btn btn-danger btn-xs">Delete</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('custom-scripts')
    <script src="{{url('/js/app.js') }}"></script>
    <script>
        $(document).ready(function($) {
            var _token = $('#tok').val();

            $('.clickable-row').on('click', '.manage-course', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var group_id = $(this).data('courseid');

                $('.clickable-row[data-courseid="' + group_id + '"]').hide();

//                $.ajax({
//                    url: url,
//                    type: 'POST',
//                    data: {_token: _token},
//                    success: function(res) {
//                        console.log('res', res);
//                        if(res.hasOwnProperty('success')) {
//                            if(res.success) {
//                                $('.clickable-row[data-courseid="' + group_id + '"]').remove();
//                            } else {
//                                $('.clickable-row[data-courseid="' + group_id + '"]').show();
//                                alert(res.error_messages);
//                            }
//                        }
//                    },
//                    error: function(res) {
//                        console.log('res', res);
//                        $('.clickable-row[data-courseid="' + group_id + '"]').show();
//                    }
//                });
            });

            $(".clickable-row").click(function() {
                window.document.location = $(this).data("href");
            });
        });
        function search() {
            // Declare variables
            var input, filter, table, tr, td, i;
            input = document.getElementById("txt_search");
            filter = input.value.toLowerCase();
            table = document.getElementById("courses-table");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    if (td.innerHTML.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection

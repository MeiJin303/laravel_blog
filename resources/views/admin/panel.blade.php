<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href=" {{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ __('Admin Panel') }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="py-2">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                         <x-alert :session="true"></x-alert>
                    </div>
                </div>
                <div class="container mx-auto">
                    <a href="{{ url('admin/add') }}" class="text-center btn btn-success mb-1">Add API URL</a>
                    <table class="table table-bordered" id="laravel-datatable-crud">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>API URL</th>
                            <th>Duration(h)</th>
                            <th>Created At</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    </table>
                </div>
            </main>
        </div>
    </body>
    <script>
        $(document).ready( function () {
         $('#laravel-datatable-crud').DataTable({
              processing: true,
              serverSide: true,
             ajax: {
               url: "{{ url('admin') }}",
               type: 'GET',
              },
              columns: [
                       { data: 'user_name', name: 'user_name' },
                       { data: 'api_url', name: 'api_url' },
                       { data: 'duration', name: 'duration' },
                       { data: 'created_at', name: 'created_at' },
                       { data: 'active', name: 'active' },
                       { data: 'action', name: 'action' }
                    ]
          });
        });

        $('body').on('click', '.remove', function () {

           var id = $(this).data("id");
           if(confirm("Are You sure want to delete !"))
           {
             $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                 type: "post",
                 url: "{{ url('admin/remove') }}"+'/'+id,
                 success: function (data) {
                 var oTable = $('#laravel-datatable-crud').dataTable();
                 oTable.fnDraw(false);
                 },
                 error: function (data) {
                     console.log('Error:', data);
                 }
             });
          }
       });

      </script>
</html>

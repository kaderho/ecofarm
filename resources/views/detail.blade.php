<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        <div class="container">
            <div class="row mt-5 text-center">
                <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th scope="col">Nom</th>
                        <td>{{ $tree->name }}</td>
                    </tr>
                     <tr>
                        <th scope="col">Date</th>
                        <td>{{ $tree->date->diffForHumans() }}</td>
                    </tr>
                     <tr>
                        <th scope="col">Description</th>
                        <td>{{ $tree->description }}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> --}}
    </body>
</html>

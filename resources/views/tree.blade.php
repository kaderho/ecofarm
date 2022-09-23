<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <form class="form-inline" action="{{ route('tree.store') }}" method="POST">
                @csrf
                <div class="form-group mb-2">
                    <input type="text" class="form-control" name="name" placeholder="Nom de l'arbre">
                </div>
                <div class="form-group mb-2">
                    <input type="date" class="form-control" name="date" placeholder="Âge de l'arbre">
                </div>
                <div class="form-group mb-2 ml-1">
                    <input type="text" class="form-control" name="description" placeholder="Description de l'arbre">
                </div>
                <button type="submit" class="btn btn-primary ml-1 mb-2">Enregistrer</button>
            </form>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">date</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trees as $tree)
                        <tr>
                            <td>{{ $tree->name }}</td>
                            <td>{{ $tree->date->diffForHumans() }}</td>
                            <td>{{ $tree->description }}</td>
                            <td>
                                <a href="{{ route('generate', $tree->id) }}" class="btn btn-primary">Générer</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('generates') }}" class="btn btn-primary ml-1 mb-2">Générer tous les QRcodes</a>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
</body>

</html>

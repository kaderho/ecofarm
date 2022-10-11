<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container" style="padding: 30px;">
        <form id="form" action="{{ route('tree.store') }}" method="POST">
            @csrf
            <div id="csrf"></div>
            <div class="form-group row mb-4">
                <div class="col-md-3 mt-2">
                    <input type="text" class="form-control form-control-sm" name="name" id="name"
                        placeholder="Nom de l'arbre">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="date" class="form-control form-control-sm" name="date" id="date"
                        placeholder="Âge de l'arbre">
                </div>
                <div class="col-md-4 mt-2">
                    <textarea type="text" class="form-control form-control-sm" name="description" id="description"
                        placeholder="Description de l'arbre" rows="1"></textarea>
                </div>
                <div class="col-md-2 mt-2">

                    <button type="submit" class="btn btn-success btn-sm btn-block"><i class="fas fa-check"></i>
                        Enregistrer</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped nowrap">
                    <thead>
                        <tr>
                            <th scope="col" class="nowrap">#</th>
                            <th scope="col" class="nowrap">Nom</th>
                            <th scope="col" class="nowrap">date</th>
                            <th scope="col" class="nowrap">Description</th>
                            <th scope="col" class="nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trees as $tree)
                            <tr>
                                <td style="white-space: nowrap !important;">{{ $loop->iteration }}</td>
                                <td style="white-space: nowrap !important;">{{ $tree->name }}</td>
                                <td style="white-space: nowrap !important;">{{ $tree->date->diffForHumans() }}</td>
                                <td style="white-space: nowrap !important;">{{ $tree->description }}</td>
                                <td style="white-space: nowrap !important;">
                                    <a href="{{ route('generate', $tree->id) }}" class="btn btn-info btn-sm"><i
                                            class="fas fa-qrcode"></i></a>
                                    <a href="#" data-tree="{{ $tree }}"
                                        data-route="{{ route('tree.update', ['tree' => $tree->id]) }}"
                                        class="btn btn-primary btn-sm btn-edit"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('generate', $tree->id) }}"
                                        data-route="{{ route('tree.destroy', ['tree' => $tree->id]) }}"
                                        class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-9">
                {!! $trees->links() !!}
            </div>
            <div class="col-md-3 d-flex justify-content-end">
                <a href="{{ route('generates') }}" class="btn btn-primary btn-sm">Tous <i
                        class="fas fa-qrcode"></i></a>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="" id="delete" method="POST">
                    @csrf
                    @method("DELETE")
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression d'un arbre</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        La suppression est irréversible
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer <i class="fas fa-trash"></i></button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>

    <script>
        $('.btn-edit').each(function(index, element) {
            $(element).click(function(e) {
                var tree = $(element).data('tree');
                var date = new Date(tree.date);
                $("#name").val(tree.name);
                $("#date").val(dateToSQLFormat(date));
                $("#description").val(tree.description);

                $("#form").attr('action', $(element).data('route'));
                $("#csrf").html('@method('PUT')');
            });
        });

         $('.btn-delete').each(function(index, element) {
            $(element).click(function(e) {
                $("#delete").attr('action', $(element).data('route'));
            });
        });

        function dateToSQLFormat(date) {
            var pad = function(num) {
                return ("00" + num).slice(-2);
            };
            var newDate = date.getUTCFullYear() +
                "-" +
                pad(date.getUTCMonth() + 1) +
                "-" +
                pad(date.getUTCDate())
            return newDate;
        }
    </script>
</body>

</html>

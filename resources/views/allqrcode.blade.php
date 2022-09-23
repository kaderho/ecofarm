<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </style>
</head>

<body>
<div class="container">
      <div class="row">
          @foreach ($trees as $tree)
            <div class="col-md-6">
                <img src="data:image/png;base64, {!! base64_encode(
                    QrCode::format('png')->size(200)->generate(route('tree.show', ['tree' => $tree->id])),
                ) !!} ">
            </div>
        @endforeach
      </div>
    </div>
</body>

</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enuygun ToDo</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>
<body>
<div class="container-fluid bg-dark">
    <div class="row">

        <div class="col-sm-12">
            <div class="alert alert-info  my-3" role="alert">
                Tüm çalışmalar {{ $deadline }} hafta içerisinde sona eriyor.
            </div>
            @foreach($developers as $developer)
                <div class="bg-dark  my-3 text-light">
                    <h5>{{ $developer['name'] }}</h5>
                        Developer Seviyesi:{{ $developer['level'] }}
                        Toplam Çalışma Saati:{{ $developer['time'] }}
                </div>
                <div class="row">
                    @foreach($developer['weekly'] as $week => $daily)
                        <div class="col-sm">
                            <h5 class="text-light">{{ ($week + 1) }}. Hafta</h5>
                            @foreach($daily['tasks'] as $task)

                                <div class="card col-md-12 my-3 p-2 bg-light">
                                    <h5 class="card-title p-0 m-0"> {{ $task['id'] }}</h5>
                                    <div class="card-body p-0">
                                        <hr class="m-1">
                                        <div>
                                            <span class="col-sm-6 p-0 m-0">Zorluk: {{ $task['level'] }}</span>
                                            <span class="col-sm-6 p-0 m-0">Süre: {{ $task['time'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <hr class="py-5">

            @endforeach

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>

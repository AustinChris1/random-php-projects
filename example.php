<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Projects</title>
</head>

<body>
    <div class="container-fluid  px-4">
        <div class="row mt-4">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h2>Mail From Spectra Web-X </h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="Web capture_23-6-2022_111842_www.chelseafc.com.jpeg" alt="">
                            </div>
                            <h4>Hello {{name}} Welcome to Spectra Web-X</h4>
                            <h4>I guess your email is {{email}} {{str}} </h4>
                            <a href="{{token}}" class="btn btn-info w-100">Click Here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>

</html>
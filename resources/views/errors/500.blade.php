<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Neqat &mdash; 500</title>

    @include('errors.css.style')

</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="page-error">
                    <div class="page-inner">
                        <h1>500</h1>
                        <div class="page-description">
                            Kesalahan Internal Server. Maaf, terjadi kesalahan internal pada server.
                        </div>
                        <div class="page-search">
                            <div class="mt-3">
                                <a href="{{ route('home.index') }}"><i class="ion-arrow-left-c" data-pack="default"
                                        data-tags=""></i> Back to Home</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simple-footer mt-5">
                    Copyright &copy; Neqat 2023
                </div>
            </div>
        </section>
    </div>

    @include('errors.js.script')

</body>

</html>

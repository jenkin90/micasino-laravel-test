<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->

    <!-- Styles -->
    <style>

    </style>
</head>

<body class="font-sans antialiased">
    <div class="container">
        <div class="row justify-content-center">
            @if ($status==200)
            <div class="success">
                @elseif ($status==400 || $status==500)
                <div class="error">
                    @endif
                    <h4>Transaction result</h4>
                    <p>{{ $message }}</p>
                </div>
            </div>
            <style>
                .container {
                    width: 100%;
                    font-family: sans-serif;
                    margin-top: 20px;
                }

                .success {
                    background-color: green;
                    color: white;
                }

                .error {
                    background-color: red;
                    color: white;
                }
            </style>

</html>
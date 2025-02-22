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
            <h1>Transaction List</h1>

            @foreach ($transactions as $transaction)
            <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 10px;">
                <h3>Transaction #{{ $transaction->id }}</h3>
                <p>Payment method: {{ $transaction->pay_method }}</p>
                <p>Amount: {{ $transaction->amount }}</p>
                <p>Coin: {{ $transaction->currency }}</p>
                <p>Status: {{ $transaction->status }}</p>
                <p>Creation date: {{ $transaction->created_at }}</p>

                <!-- Historial de logs para esta transacción -->
                <h4>Historial</h4>
                @if($transaction->logs->count())
                <ul>
                    @foreach ($transaction->logs as $log)
                    <li>
                        <strong>Type:</strong> {{ $log->type }} <br>
                        <strong>Payload:</strong> {{ $log->payload }} <br>
                        <strong>Date:</strong> {{ $log->created_at }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p>There are no transactions</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    <style>
        .container {
            width: 100%;
            font-family: sans-serif;
            max-width: 960px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 5px;
            display: inline-block;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            box-sizing: border-box;
        }

        .form-control:focus {
            color: #212529;
            background-color: #fff;
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn {
            cursor: pointer;
            display: inline-block;
            font-weight: 400;
            color: #ddd;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: gray;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1.4rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn:hover {
            color: #212529;
            text-decoration: none;
        }
    </style>

</html>
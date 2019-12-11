<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>فرهنگ</title>
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Vazir', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .app-name {
                font-weight: 100;
                font-size: 5em;
            }
            .search-bar {
                width: 800px;
                position: relative;
            }
            .search-bar input {
                box-sizing: border-box;
                border: 3px solid #aaa;
                border-radius: 5px;
                padding: 1em;
                width: 100%;
                font-family: 'Vazir', sans-serif;
            }
            .search-bar .has-results {
                border-radius: 5px 5px 0 0;
            }
            .search-bar input:focus {
                border: 3px solid #a0c0ff;
                outline: none;
            }
            .autocomplete {
                box-sizing: border-box;
                margin: 0;
                width: 100%;
                position: absolute;
                background: white;
                border: 3px solid #ddd;
                border-top: none;
                border-radius: 0 0 5px 5px;
                text-align: start;
                padding: 0;
            }
            .autocomplete li {
                list-style: none;
                padding: 5px 10px;
            }
        </style>
</head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">خانه</a>
                    @else
                        <a href="{{ route('login') }}">ورود</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">ثبت نام</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <h1 class="app-name">{{ config('app.name') }}</h1>
                @livewire('search-bar')
                @foreach(DB::connection('dehkhoda')->table('t01')->inRandomOrder()->limit(10)->get() as $entry)
                    {{--{{ $entry->word }}--}}
                @endforeach
            </div>
        </div>
        @livewireAssets
        @stack('scripts')
    </body>
</html>

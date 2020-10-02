<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 25px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0.5rem 1rem;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .mt-5 {
                margin-top: 3rem !important;
            }

            .pt-5 {
                padding-top: 3rem !important;
            }

            .title {
                text-align: center;
                font-size: 2.25rem;
            }
        </style>
    </head>
    <body>
        <div class="container">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a class="btn btn-link" 
                            href="{{ route('home') }}">
                            Home
                        </a>

                        <a class="btn btn-outline-secondary" 
                           href="{{ route('register') }}">
                           Register
                        </a>
                        
                        <a class="btn btn-primary text-white" 
                           href="{{ route('login') }}">
                           Login
                        </a>
                    @endauth
                </div>
            @endif
            
            <h1 class="mt-5 pt-5 title">DESIGN OF APPLICATION</h1>
            <div>
                <div class="mxgraph" style="max-width:100%;border:1px solid transparent;" data-mxgraph="{&quot;highlight&quot;:&quot;#0000ff&quot;,&quot;nav&quot;:true,&quot;resize&quot;:true,&quot;toolbar&quot;:&quot;zoom layers lightbox&quot;,&quot;edit&quot;:&quot;_blank&quot;,&quot;xml&quot;:&quot;&lt;mxfile host=\&quot;app.diagrams.net\&quot; modified=\&quot;2020-08-18T01:21:41.575Z\&quot; agent=\&quot;5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36\&quot; etag=\&quot;A-rmA3ubRIFNied4bdZ2\&quot; version=\&quot;13.6.2\&quot; type=\&quot;device\&quot;&gt;&lt;diagram id=\&quot;yi-14oO17tSPmKgDZsPc\&quot; name=\&quot;Page-2\&quot;&gt;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&lt;/diagram&gt;&lt;/mxfile&gt;&quot;}">
                </div>
            </div>
        </div>

        <script type="text/javascript" src="https://app.diagrams.net/js/viewer-static.min.js"></script>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Php Web Scraper</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                height: 100%;
                font-size: 14px;
            }
            h5{
                font-weight: bold;
            }
            .gap-20{
                gap:20px;
            }
            textarea:focus { 
                outline: none !important;
                border-color: #dee2e6;
                box-shadow: 0 0 10px #dee2e6;
            }
            #response_status_code{
                left: 0;
                background-color: #dee2e6;
                border: 1px solid #dee2e6;
                color: black;
                font-weight: bold;
                text-align: center;
            }
        </style>
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    </head>
    <body>
        <header class="nav-header py-2 px-2 d-flex align-items-center justify-content-start shadow-md border-bottom">
            <h5>PHP Web Scraper using Abstract API</h5>
        </header>
        <main class="container-fluid" style="min-height: 500px;">
            <div class="row py-1 justify-content-center">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <span>PHP Web Scraper Request</span>
                </div>
                <div class="d-flex col-12 justify-content-center p-1">
                    <form method="post" class="col-6" id="request_form" action="{{url('/')}}/requestapi">
                        @csrf
                        <div class="row mb-2 align-items-center justify-content-center">
                            <div class="col-12">
                                <input type="text" required class="form-control" id="url" name="url" value="" placeholder="Enter Url here">
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center justify-content-center">
                            <div class="col-auto">
                                <button id="submit_button" class="btn btn-sm btn-primary" type="submit">Submit</button>
                            </div>     
                            <div class="col-auto">
                                <button id="reset_button" class="btn btn-sm btn-danger" onclick="resetform()" type="button">Reset</button>
                            </div>     
                        </div>
                    </form>
                </div>
                <div id="loading" class="col-12 justify-content-center gap-20 w-100" style="display:none;">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div id="request_status">Loading...</div>
                    </div>
                </div>
                <div id="error_response" class="col-12 w-100 justify-content-center px-4" style="display:none;">
                    <div id="error_response_text" class="alert-danger text-center"></div>
                </div>
                <div id="apiresponse" style="display:none;" class="col-12 py-2 px-4 align-items-center justify-content-center position-relative">
                    <textarea id="response" style="height:500px;" class="p-2 container overflow-auto border bg-light">
                    </textarea>
                </div>
            </div>
        </main>
        <footer class="container-fluid">
            <div class="w-100 py-2 px-2 text-center text-sm">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </footer>
        <script type="text/javascript">

            var spinnerHtml = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            var form_el = document.getElementById("request_form");
            document.getElementById("url").focus();
            
            function resetform()
            {
                document.getElementById("url").value = '';
                document.getElementById("url").focus();
                document.getElementById("loading").style.display = 'none';
                document.getElementById("submit_button").classList.remove('disabled');
                document.getElementById("reset_button").classList.remove('disabled');
                document.getElementById("apiresponse").style.display = "none";
                document.getElementById("error_response").style.display = "none";
                document.getElementById("error_response_text").innerHTML = '';
                document.getElementById("response").value = '';
                return true;
            }

            function make_request(url)
            {
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function() 
                {
                    if (this.status != 200) 
                    {
                        document.getElementById("loading").style.display = 'none';
                        document.getElementById("submit_button").classList.remove('disabled');
                        document.getElementById("reset_button").classList.remove('disabled');
                        document.getElementById("apiresponse").style.display = "none";
                        var responseText = "Server Http Status: "+this.status+" : "+this.responseText;
                        document.getElementById("error_response_text").innerHTML = responseText;
                        document.getElementById("error_response").style.display = "flex";
                    } 
                    else 
                    { 
                        document.getElementById("loading").style.display = 'none';
                        document.getElementById("submit_button").classList.remove('disabled');
                        document.getElementById("reset_button").classList.remove('disabled');
                        document.getElementById("apiresponse").style.display = "flex";
                        document.getElementById("error_response").style.display = "none";
                        document.getElementById("error_response_text").innerHTML = '';
                        document.getElementById("response").value = this.responseText;
                    }
                }

                xhttp.open("POST", form_el.action);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.setRequestHeader("Cache-Control", "no-cache, no-store, must-revalidate");
                xhttp.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
                var url = document.getElementById("url").value.trim();
                url = encodeURIComponent(url);
                xhttp.send("url="+url);
            }

            form_el.addEventListener("submit", function(evt) 
            {
                evt.preventDefault();
                var url = document.getElementById("url").value.trim();
                document.getElementById("loading").style.display = 'flex';
                
                document.getElementById("error_response_text").innerHTML = "";
                document.getElementById("apiresponse").style.display = "none";
                document.getElementById("error_response").style.display = "none";

                document.getElementById("request_status").innerHTML = "Making Request..";
                
                document.getElementById("response").value = 'Processing...';
                document.getElementById("submit_button").classList.add('disabled');
                document.getElementById("reset_button").classList.add('disabled');
                make_request(url);
            });

        </script>
    </body>
</html>

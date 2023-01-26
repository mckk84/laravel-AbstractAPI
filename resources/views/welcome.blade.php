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
            <h5>PHP Web Scraper using Abstract API Demo</h5>
        </header>
        <main class="container-fluid" style="min-height: 500px;">
            <div class="row py-1 justify-content-center">
                <div class="col-6 py-2 ">
                    <div class="border py-2 bg-light d-flex align-items-center justify-content-center">
                        <span>PHP Web Scraper Demo</span>
                    </div>
                    <div class="d-flex border col-12 justify-content-center p-1">
                        <form method="post" class="col-6" id="request_form" action="{{url('/')}}/requestapi">
                            @csrf
                            <div class="row mt-1 mb-2 align-items-center justify-content-center">
                                <div class="col-12">
                                    <input type="text" required class="form-control" id="url" name="url" value="" placeholder="Enter url here">
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center justify-content-center">
                                <div class="col-auto">
                                    <button id="submit_button" class="btn btn-sm btn-primary" type="submit">Submit</button>
                                </div>     
                                <div class="col-auto">
                                    <button id="reset_button" class="btn btn-sm btn-danger" type="button">Reset</button>
                                </div>     
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row py-1 justify-content-center">
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
            <!-- footer html -->
        </footer>
        <!-- Latest Jquery -->
        <script src="{{asset('js/jquery-3.6.3.min.js')}}"></script>

        <script type="text/javascript">

            $(document).ready(function(){

                var spinnerHtml = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
                $("#url").focus();

                $("#reset_button").click(function(){
                    $("#url").val('');
                    $("#url").focus();
                    $("#loading").hide();
                    $("#submit_button").removeClass('disabled');
                    $("#reset_button").removeClass('disabled');
                    $("#apiresponse").hide();
                    $("#error_response").hide();
                    $("#error_response_text").html('');
                    $("#response").val('');
                });
            });

            function make_request(url)
            {
                url = encodeURIComponent(url);
                var form_el = $("#request_form");
                $.ajax({
                    type:'POST',
                    url: form_el.attr('action'),
                    headers: {
                         'X-CSRF-TOKEN':'{{ csrf_token() }}',
                         'Content-type':'application/x-www-form-urlencoded',
                         'Cache-Control': 'no-cache, no-store, must-revalidate', 
                         'Pragma': 'no-cache', 
                         'Expires': '0'
                       },
                    data: "url="+url,
                    dataType:"text",
                    processData: false,
                    error: function(xhr, textStatus, errorThrown){
                        $("#loading").hide();
                        $("#submit_button").removeClass('disabled');
                        $("#reset_button").removeClass('disabled');
                        $("#apiresponse").hide();
                        var responseText = "Server Http Status: "+xhr.status+" : "+errorThrown;
                        $("#error_response_text").html(responseText);
                        $("#error_response").css('display', "flex");
                    },
                    success: function(data, status, xhr){
                        $("#loading").hide();
                        $("#submit_button").removeClass('disabled');
                        $("#reset_button").removeClass('disabled');
                        $("#apiresponse").css('display', 'flex');
                        $("#error_response").hide();
                        $("#error_response_text").html('');
                        $("#response").val(data);
                    }
                });
            }

            $("#request_form").submit(function(evt) 
            {
                evt.preventDefault();

                var url = $("#url").val().trim();
                $("#loading").css('display', 'flex');
                
                $("#error_response_text").html("");
                $("#apiresponse").hide();
                $("#error_response").hide();

                $("#request_status").html("Making Request..");
                
                $("#response").val('Processing...');
                $("#submit_button").addClass('disabled');
                $("#reset_button").addClass('disabled');
                make_request(url);
            });

        </script>
    </body>
</html>

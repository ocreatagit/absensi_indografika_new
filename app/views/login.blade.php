<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>IndoGrafika Administrator Page</title>

        {{ HTML::style('assets/css/bootstrap.css') }}
        {{ HTML::style('assets/css/font-awesome.css') }}
        {{ HTML::style('assets/css/myCSS.css') }}
    </head>
    <body>
        <div id="custom-bootstrap-menu" class="navbar navbar-default navbar-fixed-top">
            <p class="text-center text-white" id="adminpageheader"><i class="fa fa-users"></i> Indografika Administator Page</p>
        </div>

        <div class="container" id="loginBox">
            <div class="row">
                <div class="panel panel-default siku col-lg-6 col-lg-offset-3">
                    <div class="panel-body">
                        <form action="{{ url('login') }}" method="POST" class="form-horizontal">
                            <div class="form-group">
                                <h4 class="col-lg-4 text-left"><i class="fa fa-user"></i> No Absensi</h4>
                            </div>
                            @if(Session::has('login_failed'))
                            <div class="form-group alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <i class="fa fa-info-circle"></i> {{ $login_failed }}
                            </div>
                            @endif
                            <div class="form-group">
                                <div class="col-lg-12">
                                    {{ Form::text('usernm','',array('placeholder' => 'Username', "required"=>"required", "class" => "form-control siku", "autofocus" => "")) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <h4 class="col-lg-4 text-left"><i class="fa fa-lock"></i> Password</h4>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    {{ Form::password('password',array('placeholder' => 'Password', "required"=>"required", "class" => "form-control siku")) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <button type="submit" value="btn_submit" class="btn btn-primary btn-block siku"><i class="fa fa-sign-in"></i> Login</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="custom-bootstrap-menu" class="navbar navbar-default navbar-fixed-bottom">
        </div>

        <!-- /. WRAPPER  -->
        {{ HTML::script('assets/js/jquery-1.10.2.js') }}
        {{ HTML::script('assets/js/bootstrap.min.js') }}
        {{ HTML::script('assets/js/jquery.metisMenu.js') }}
        {{ HTML::script('assets/js/custom.js') }}

        @yield('script')
    </body>
</html>

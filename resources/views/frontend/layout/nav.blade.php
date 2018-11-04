<style type="text/css">
    .navbar-brand > div{
        height: 50px;
        width: 48px;
        float: left;
    }
    .navbar-brand > div > img{
        position: relative;
        bottom: 9px;
    }
</style>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/')}}">
                <div>
                    
                <img src="{{ asset('images/icons/bangladesh_logo.png')}}" style="width: 45px; float: left;">
                </div>
                <strong>Bangladesh Planning Commission</strong>
            </a>
        </div>
        <?php if(!isset($login)){ ?>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ route('login') }}"><strong>LOGIN</strong>&nbsp;<img src="{{ asset('images/icons/login_icon.png')}}"></a></li>              
            </ul>
        </div><!--/.nav-collapse -->
        <?php } ?>
    </div>
</nav>

    
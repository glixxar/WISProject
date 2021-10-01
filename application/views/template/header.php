<html>
        <head>
                <title>INFS3202 Project</title>
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
                <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
                <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
                <script src="<?php echo base_url().'assets/js/jquery-ui.js'?>" type="text/javascript"></script>
                <script src="<?php echo base_url().'assets/js/dropzone.min.js'?>" type="text/javascript"></script>
                <script src="<?php echo base_url().'assets/js/dropzone.js'?>" type='text/javascript'></script>
                <link rel="stylesheet" href="<?php echo base_url().'assets/css/jquery-ui.css'?>">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" >
                <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/dropzone.min.css'?>">
                <meta name="google-site-verification" content="t3koRoIvCbv5wbBJ4CNwID8BmtRFVLcnvfZU4FZU4T0" />
                <script type="text/javascript">
                var timer = 0;
                function set_interval() {
                // the interval 'timer' is set as soon as the page loads
                timer = setInterval("auto_logout()", 5000000);
                // the figure '10000' above indicates how many milliseconds the timer be set to.
                // Eg: to set it to 5 mins, calculate 5min = 5x60 = 300 sec = 300,000 millisec.
                // So set it to 300000
                }

                function reset_interval() {
                //resets the timer. The timer is reset on each of the below events:
                // 1. mousemove   2. mouseclick   3. key press 4. scroliing
                //first step: clear the existing timer

                if (timer != 0) {
                    clearInterval(timer);
                    timer = 0;
                    // second step: implement the timer again
                    timer = setInterval("auto_logout()", 5000000);
                    // completed the reset of the timer
                }
                }

                function auto_logout() {
                // this function will redirect the user to the logout script
                window.location = "<?php echo base_url('login/logout') ?>";
                }
                </script>
        </head>
  <body onload="set_interval()" onmousemove="reset_interval()" onclick="reset_interval()" onkeypress="reset_interval()" onscroll="reset_interval()">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">StudenTube</a>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto ">
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>home"> Home </a>
            </li>
            <?php if(!$this->session->userdata('logged_in')) : ?>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>login"> Login </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>register"> Register </a>
                </li>
            <?php endif; ?>
            <?php if($this->session->userdata('logged_in')) : ?>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>account/load_user_data"> Account </a>
                </li>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>favourites"> Favourites </a>
                </li>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>login/logout"> Logout </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    
            <form class="form-inline my-2 my-lg-0" id="form_search" action="<?php echo site_url('home/view_search');?>" method="GET">
                <div class="input-group">
                <input class="form-control mr-sm-2" name="title" class="form-control" id="title" 
                type="search" id="search_text" placeholder="Search" name="search" aria-label="Search">
                    <span class="input-group-btn">
                            <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                 </div>
            </form>


</nav>

<div class="container">
<div class="collapse" id="collapseExample">
  <div class="card card-body" id="result">

  </div>
</div>
<script>
    $(document).ready(function(){
        $( "#title" ).autocomplete({
              source: "<?php echo site_url('Ajax/fetch/?');?>",

              select: function (event, ui) {
                    $(this).val(ui.item.label);
                    $("#form_search").submit(); 
                }
    });
    
    });
</script>


<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);


.navbar-nav > li{
  padding-left:15px;
  padding-right:15px;
}

body {
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;  

}

</style> 

<div class="login-page">
  <div class="form">
    <h1 id="form_heading">Login</h1>
    <?php echo form_open(base_url().'login/check_login'); ?>
        <input type="text" name="username"  value="<?=set_value('username')?>" placeholder="username"/>
        <?php echo form_error('username'); ?>
        <input type="password"  name="password" placeholder="password"/>
        <?php echo form_error('password'); ?>
      <div id="remember" class="form-group form-check">
      <input id="input_box" name="remember" type="checkbox" class="form-check-input" id="exampleCheck1">
      <label id="label_remember"class="form-check-label" for="exampleCheck1">Remember me</label>
      </div>
      
      <h4>Submit Captcha Code</h4>
      <p id="captImg"><?php echo $captchaImg; ?></p>
      <p>Can't read the image? click <a href="javascript:void(0);" class="refreshCaptcha">here</a> to refresh.</p>
      Enter the code : 
      <input type="text" name="captcha" value=""/>
        <button>login</button>
        <?php echo $error; ?>
        <p class="message">Not registered? <a href="<?php echo base_url(); ?>register">Create an account</a></p>
        <p class="message">Forgot Passwrd? <a href="<?php echo base_url(); ?>reset">Click here</a></p>
      <?php echo form_close(); ?>
  </div>
</div>

<script>
$(document).ready(function(){
    $('.refreshCaptcha').on('click', function(){
        $.get('<?php echo base_url().'login/refresh'; ?>', function(data){
            $('#captImg').html(data);
        });
    });
});
</script>


<style>


#form_heading {
	padding-bottom:1em;
}

#remember {
	text-align:left;
	padding-left: 0;
	padding-bottom:15px;
}

#input_box {
	margin:5px 0 1em;
	float:left !important;
	width:auto;
}

#label_remember {
	float:left;
	margin-left:18px;
}

.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #4CAF50;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #43A047;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}

</style>

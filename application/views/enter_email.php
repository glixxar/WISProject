<div class="enter_email">
  <div class="col-sm-12 my-auto">
    <h1 id="form_heading">Enter your email</h1>
    <?php echo form_open(base_url().'reset/check_email'); ?>
    <input type="text" name="email"  value="" placeholder="Email"/>
    <button style="margin:5% 5% 0 0;display:block;">reset</button>
    <?php echo $message; ?>
    <?php echo form_close(); ?>
  </div>
</div>

<style>
.enter_email {  
  width: 360px;
  padding: 5% 0 0;
  margin: auto;
}
</style>
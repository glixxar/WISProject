<h1 class="display-11">Change your email</h3>
    <?php echo form_open('account/change_username', 'method="POST"'); ?>
      <input type="text" required="required" name="email" placeholder="username"/>
        <input type="submit" name="save" value="Save Data"/>
    <?php echo form_close(); ?>
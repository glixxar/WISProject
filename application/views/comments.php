
<div class="container bg-light" style="flex-wrap:wrap;">
    <h1 class="bg-light">Add Commment:</h1>
    <?php echo form_open_multipart('play/add_comment');?> 
      <textarea style="width:400px; height:150px;" name="comments" class="comment"> </textarea>
      <br>
      <input type="hidden" name="url" value="<?=$filename?>" />
      <input style="margin-top:1.5em;padding:0 1em 0 1em;"type="submit" name="submit" value="Add">
    <?php echo form_close(); ?> 
</div>

<?php foreach($comments as $row):?>
<div class="container bg-light text-dark">
<div class="row">
    <div style="padding-left: 20px; margin-bottom:25px;margin-top:25px;"class="geser">
    <div class="media">
        <div class="media-body">
          <h4 class="media-heading" style="font-size: 19px; font-weight:bold;"><?php echo $row['username'];?></h4>
          <p style="font-size:14px;" class="komen">
             <?php echo $row['comment'];?>  <br>
          </p>
        </div>
    </div>
    </div>
</div>
</div>
<?php endforeach;?>
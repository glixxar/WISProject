<?php foreach($watch_list as $row):?>
    
<div class="container bg-light text-dark">
<div class="row">
    <div style="padding-left: 20px; margin-bottom:25px;margin-top:25px;"class="geser">
    <div class="media">
        <div class="media-body">
          <h4 class="media-heading" style="font-size: 19px; font-weight:bold;"><?php echo $row['title'];?></h4>
          <video style="border-radius:20px; width: 50%;height: auto;margin-bottom:2em;" controls>
          <source  src="<?php echo sprintf("%s/uploads/%s",base_url(), $row['filename']);?>"></video>
            <?php echo form_open_multipart('favourites/remove_video');?> 
                <?php echo form_hidden('filename',$row['filename']);?>
                <button>Remove video</button>
            <?php echo form_close(); ?>
        </div>
    </div>
    </div>
</div>
</div>
<?php endforeach;?>
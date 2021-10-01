<div class="container bg-light">
    <video style="border-radius:20px; width: 100%;height: auto;" controls>
    <source  src="<?php echo sprintf("%s/uploads/%s",base_url(), $filename);?>"></video>
</div>
<div class="d-flex align-items-center bg-light" style="height: 100px;padding:0 30px 0 30px;">
    <div class="mr-auto">
        <?php echo $details['title'];?>
    </div>
    <div class="p-2">
    <i class="fa">&#xf087;</i>
    <a href="<?php echo site_url("play/like") ?>">   
        <?php if($like_status['liked'] == 1) : ?>
            <button  id = "like" type="button" disabled>like </button>
        <?php endif; ?>
        <?php if($like_status['liked'] != 1) : ?>
            <button  id = "like" type="button">like </button>
        <?php endif; ?>
    </a>
    <?php echo $likes;?>
    </div>

    <div class="p-2">
    <i class="fa">&#xf088;</i>
    <a href="<?php echo site_url("play/dislike") ?>">   
        <?php if($like_status['disliked'] == 1) : ?>
            <button  id = "like" type="button" disabled>dislike </button>
        <?php endif; ?>
        <?php if($like_status['disliked'] != 1) : ?>
            <button  id = "like" type="button">dislike </button>
        <?php endif; ?>
    </a>
    <?php echo $dislikes;?>
    </div>

    <?php if($this->session->userdata('logged_in')) : ?>
    <div class="p-2">
        <?php if(!$in_watchlist) : ?>    
            <?php echo form_open_multipart('play/add_to_watch_list','style="margin:0;"');?> 
                Add to watch-list ?  <button>Add</button>
            <?php echo form_close(); ?> 
        <?php else: ?>
        <p>Added to watch-list</p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</div>

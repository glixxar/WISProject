<div class="bg">

</div>


<div class="row">
    <div class="col-lg-11 mx-auto">
        <div class="row py-5">
            <div class="col-lg-4">
                <figure class="rounded p-3 bg-white shadow-sm">
                    <a href="<?php echo site_url("play/load_video/" . $images->row(0)->filename) ?>">
                        <img class="thumbnail" src="<?php echo sprintf("%s/uploads/images/%s",base_url(), $images->row(0)->thumb_name);?>" alt="" class="w-100 card-img-top" style="height: 200px;">
                    </a>
                    <figcaption class="p-4 card-img-bottom">
                    <h2 class="h5 font-weight-bold mb-2 font-italic"><?php echo $images->row(0)->title;?></h2>
                    <p class="mb-0 text-small text-muted font-italic"><?php echo $images->row(0)->description;?></p>
                    </figcaption>
                </figure>
            </div>
            <div class="col-lg-4">
                <figure class="rounded p-3 bg-white shadow-sm">
                    <a href="<?php echo site_url("play/load_video/" . $images->row(1)->filename) ?>">
                    <img  class="thumbnail" src="<?php echo sprintf("%s/uploads/images/%s",base_url(), $images->row(1)->thumb_name);?>" alt="" class="w-100 card-img-top" style="height: 200px;">
                    </a>
                    <figcaption class="p-4 card-img-bottom">
                    <h2 class="h5 font-weight-bold mb-2 font-italic"><?php echo $images->row(1)->title;?></h2>
                    <p class="mb-0 text-small text-muted font-italic"><?php echo $images->row(1)->description;?></p>
                    </figcaption>
                </figure>
            </div>
            <div class="col-lg-4">
                <figure class="rounded p-3 bg-white shadow-sm">
                    <a href="<?php echo site_url("play/load_video/" . $images->row(2)->filename) ?>">   
                    <img class="thumbnail" src="<?php echo sprintf("%s/uploads/images/%s",base_url(),$images->row(2)->thumb_name);?>" alt="" class="w-100 card-img-top" style="height: 200px;">
                    </a>
                    <figcaption class="p-4 card-img-bottom">
                    <h2 class="h5 font-weight-bold mb-2 font-italic"><?php echo $images->row(2)->title;?></h2>
                    <p class="mb-0 text-small text-muted font-italic"><?php echo $images->row(2)->description;?></p>
                    </figcaption>
                </figure>
            
    </div>
</div>






<style>
.thumbnail {
  width:280px;
  transition: transform .2s; /* Animation */
}

.thumbnail:hover {
  transform: scale(1.1); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}


.bg {
  /* The image used */
  background-image: url("assets/img/background_img.jpg");

  /* Full height */
  height: 50%; 

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}



</style>
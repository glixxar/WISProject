
<!-- <div>
    <h1 class="display-11">Upload your videos</h1>
    <?php echo form_open_multipart('account/upload_profile_pic','class="dropzone" id="image_upload"');?>
    <?php echo form_close(); ?> 
    <button id="uploadProfile" class="btn btn-light" type="submit">Submit</button>
    <?php echo $profile_pic_error;?>
</div> -->

<h5 style="padding-top:10px;padding-bottom:10px;">Upload your video:</h5>
<?php echo form_open_multipart('account/add_video','class="d-flex flex-column"');?> 
     <div class="p-2">
        <p>Video title:</p>
        <input type="text" name="video_title" required pattern="\S+">
     </div> 
     <div class="p-2">
     <p>Video description:</p>
     <input type="text" name="desc" style="width:400px; height:150px">
     </div>      
     <input type="file" name="userfile" size="20"> 
     <div class="p-2">
        <input type="submit" value="Upload" > 
     </div>   

     <?php echo $error;?>
<?php echo form_close(); ?> 

<div class="d-flex flex-column m-3">
    <div class="p-2">
    <h5>Video preview</h5>
    <?php echo $video_title;?>

    </div> 
    <div class="p-2" style="max-width:500px;max-height:300px;">
    <?php echo $video_preview;?>
     </div>     
</div>

<?php echo form_open_multipart('account/add_image');?> 
    <h5 style="padding-top:10px;padding-bottom:10px;">Add thumbnail:</h5>
     <input type="file" name="image" size="20" />

     <input type="text" name="video_title" value="<?php echo $video_title;?>"/>
     <input type="submit" value="upload" /> 
</form>

<style>

.upload_box {
    width:50%;
}

</style>

<script>
//Disabling autoDiscover
Dropzone.autoDiscover = false;

    //Dropzone class
    var myDropzone = new Dropzone("#image_upload", {
    autoProcessQueue: false,
    parallelUploads: 20,
    maxFilesize: 50,
    maxFiles: 20,
    acceptedFiles: ".mp4,.mkv"
    });

      
      $('#uploadProfile').click(function(){    
          myDropzone.processQueue();
      });
    
</script>
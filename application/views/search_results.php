<div class="container">
        <div class="row">
            <h2>Search Result</h2>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Video</th>
                        <th>Title</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($data as $row):?>
                    <tr>
                        <td>
                        <a href="<?php echo site_url("play/load_video/" .  $row->filename) ?>">
                        <img  class="thumbnail" src="<?php echo sprintf("%s/uploads/images/%s",base_url(),  $row->thumb_name);?>" 
                        alt="" class="w-100 card-img-top" style="height: 200px;width:400px;">
                        </a>
                        </td>
                        <td><?php echo $row->title;?></td>
                        <td><?php echo $row->description;?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
</div>
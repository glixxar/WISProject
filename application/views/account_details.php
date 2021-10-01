
<div id="title" style="padding-top:2.5em;">
    <h1 class="display-12">Welcome <?php echo $this->session->userdata('username');?></h2>
</div>
<div>
    <h1 class="display-11">Your current account details</h3>
    <p>Account Name: <?php echo $data['username'];?></p>
    <p>Email: <?php echo $data['email'];?></p>
    <p>Status: 
    <?php  if($data['status'] == 0) {
        echo 'Unverified';
    } else {
        echo 'Verified';
    };?></p>
</div>


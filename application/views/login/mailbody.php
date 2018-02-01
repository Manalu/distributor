<html>
    <div>
        <div><left><p>Dear <?php echo $this->data['name']; ?>,</p></left></div>
        <div><p> Recently you have asked to change your password, Please click on the below link to reset your password, If clicking the link does not work then please copy & paste the link into your web browser address bar.</p></div>
       <br><br> <div><a href="<?php echo site_url('reset/index/'.$this->data['rend']);?>">Reset Password</a></div>
        <br><div><?php echo site_url('reset/index/'.$this->data['rend']);?></div>
        <br><div>Please keep in mind that the link will only be available for the next 24 Hours.</div>
        <br><br><div> <b> If you have not asked for a reset password then please do click the link below and help us protecting fraud.</b></div>
        <br> <div><a href="<?php echo site_url('reset/reportspam/'.$this->data['rend']);?>">Report Fraud</a></div>
    </div>
</html>

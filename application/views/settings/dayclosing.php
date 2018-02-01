
<?php
if(!is_object($cashinhand)){
    $CashOfTheDay = $cashinhand;
}
else{
    foreach ($cashinhand->result() as $cashinhand){
        $CashOfTheDay = $cashinhand->cl_balance;
        $LastCashOfTheDay = $cashinhand->cl_date;
    }
}
?>


<div class="">
    <h5>Today's Cash-in: <?php echo '&#2547; ' . number_format($cashinofday, 2, ".", ","); ?></h5>
    <h5>Today's Cash-out: <?php echo '&#2547; ' . number_format($cashoutofday, 2, ".", ","); ?></h5>
    <h5>
        Previous Cash-in-hand: 
        <?php 
        if(!is_object($cashinhand)) {
            echo '&#2547; ' . number_format($CashOfTheDay, 2, ".", ","); 
            
        } else {
            echo '&#2547; ' . number_format($CashOfTheDay, 2, ".", ",");
            echo '<br />';
            echo 'Last closed on: ' . $LastCashOfTheDay;
        } 
        ?>
    </h5>
</div>
<hr />
<div>
    <h4 style="color: green; font-weight: bold;">
        এই মুহুর্তে অপনার কেশ এর সংগ্রহ হ​য়া উচিত :  &#2547; 
        <?php 
        $totalDay = (($cashinofday + $CashOfTheDay) - $cashoutofday);
        echo number_format($totalDay, 2, ".", ",");
        ?>
    </h4>
    <input type="hidden" name="valueoftheday" id="valueoftheday" value="<?php echo number_format($totalDay, 2, ".", "");; ?>" />
</div>
<input type="button" class="btn btn-success" value="Close the day" id="letscallitaday" />
<script>
    $("#letscallitaday").click(function(){
        var valueoftheday = $("#valueoftheday").val();
        $.ajax({
            type: "POST",
            url: "<?php  echo base_url() . 'settings/finalclosing'; ?>",
            data: { amount: valueoftheday },
            cache: false,
            beforeSend: function(){
                $('#closinginfo').html(
                    '<img src="<?php echo base_url(); ?>/img/ajaxloader.gif" />'
                );
            },
            success: function(html){
                $("#closinginfo").html(html);
            }
        });
    });
</script>
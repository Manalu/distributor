            <div class="row-fluid center-align-text success">
                Page rendered in <strong>{elapsed_time}</strong> seconds!!
            </div>
            <footer class="footer">
                <span  class ="center-align-text">
                    <?php echo date('Y',  time())?> &COPY; All rights reserved to <a href="<?php echo base_url(); ?>">CAPSOL</a> .
                    A Product of -  <a href="http://exploriasolution.com/" target="_blank">E<span style="color: #F00;">X</span>ploria Solutions</a>
                </span>
            </footer>
        </div>
    </div><!-- dashboard-container -->
</div><!-- container-fluid -->
  
        <script src="<?php echo $js;?>flot/jquery.flot.js"></script>
        <script src="<?php echo $js;?>flot/jquery.flot.selection.js"></script>
        <script src="<?php echo $js;?>flot/jquery.flot.pie.js"></script>
        <script src="<?php echo $js;?>flot/jquery.flot.tooltip.js"></script>


        <!-- Jquery Datepicker JS -->
        <script src="<?php echo $js;?>wysiwyg/bootstrap-wysihtml5.js"></script>
        <script type="text/javascript" src="<?php echo $js;?>date-picker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo $js;?>date-picker/date.js"></script>
        <script type="text/javascript" src="<?php echo $js;?>bootstrap-timepicker.js"></script>

        <!-- Editable Inputs -->
        <script src="<?php echo $js;?>bootstrap-editable.min.js"></script>
        <script src="<?php echo $js;?>select2.js"></script>

        <!-- Jquery Datatables JS -->
        <script src="<?php echo $js;?>jquery.dataTables.js"></script>

        <!-- Easy Pie Chart JS -->
        <script src="<?php echo $js;?>pie-charts/jquery.easy-pie-chart.js"></script>

        <!-- Tiny scrollbar js -->
        <script src="<?php echo $js;?>tiny-scrollbar.js"></script>

        <!-- Sparkline charts -->
        <script src="<?php echo $js;?>sparkline.js"></script>

        <!-- List Nav JS -->
        <script src="<?php echo $js;?>listnav.js"></script>

        <!-- Custom Js -->
        <script src="<?php echo $js;?>custom-profile.js"></script>
        <script src="<?php echo $js;?>custom-forms.js"></script>
        <script src="<?php echo $js;?>theming.js"></script>
        <script src="<?php echo $js;?>custom.js"></script>
    </body>
</html>
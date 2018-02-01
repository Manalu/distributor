$(document).ready(function() { 
    $("#todaysalesrpt").click(function(){
        jQuery .ajax({
           type: "POST",
           url: "http://localhost/gulf/dashboard/todaysales",
           data: {sup: "2015-06-08"},
           cache: false,
           beforeSend: function(){
              $('#todaysalesresult').html(
                  '<img src="http://localhost/gulf/img/ajaxloader.gif" style="margin-left: 0%; margin-top:0%;" />'
              );
           },
           success: function(html){
              $("#todaysalesresult").html(html);
           } 
        });
    });
});
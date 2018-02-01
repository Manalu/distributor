/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function getRefreshTodaysSalesInformationWidget(url, imglink){
    jQuery .ajax({
        type: "POST",
        url: url,
        cache: false,
        beforeSend: function(){
            $('#todaysalesresult').html(
                '<img src="' + imglink + '" title="Loading..." />'
            );
        },
        success: function(html){
           $("#todaysalesresult").html(html);
        }
    });
}



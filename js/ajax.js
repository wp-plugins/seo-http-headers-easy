jQuery(document).ready( function() {
    jQuery("#http-form").submit(function(){
        jQuery("#loaderImage").stop().animate({opacity: 1},0);
        jQuery("#http_submit").attr('disabled',true);
        data = {action : httpVar['action'], nonceHttp : httpVar['nonceHttp']};
        data.massiv = sendFormDinamic('http-form');
        jQuery.ajaxSetup({cache: false});
        jQuery.post(ajaxurl, data, function(response){
            response = JSON.parse(response);
            if(response.type == true){
                jQuery('#index').html(response.index);
                jQuery('#single').html(response.single);
                jQuery('#page').html(response.page);
                jQuery('#author').html(response.author);
                jQuery('#category').html(response.category);
                jQuery('#tag').html(response.tag);
                jQuery('#search').html(response.search);
            }else{
                jQuery('#index,#single,#page,#autor,#category,#tag,#search').html(response.msg);
            }
            jQuery("#loaderImage").stop().animate({opacity: 0},2500);
            jQuery("#http_submit").attr('disabled',false);
        });
        return false;
    });
    
    function sendFormDinamic(formID){
        allInputs = jQuery("#"+formID+" :input");
        postStr = "";
        for(i=0;i<allInputs.length;i++){
            type = allInputs.eq(i).attr("type");
            is = true;
            if(type == "checkbox"){is = allInputs.eq(i).is(":checked");}
            if(type == "radio"){is = allInputs.eq(i).is(":checked");}
            name = allInputs.eq(i).attr("name");
            if(type == "textarea"){
                val = allInputs.eq(i).val();
            }else {
                val = allInputs.eq(i).val();
            }
            g = i;
            if(is && name != ""){
                if(++g<allInputs.length){
                    postStr = postStr + '"' + name + '":"' + val + '",';
                }else{
                    postStr = postStr + '"' + name + '":"' + val + '"';
                }
            }
        }
        return '{' + postStr + '}';
    }
});
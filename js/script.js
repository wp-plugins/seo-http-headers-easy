jQuery(document).ready(function(){
    tabsHttp = jQuery('#tabs');
    jQuery(tabsHttp).tabs({hide:{effect:"drop",duration:300},show:{effect:"drop",duration:550}});
    /*jQuery('#tabs').tabs({hide:{effect:"drop",duration:300},show:{effect:"drop",duration:550}});*/
    sliderRange = jQuery("#slider-range-min-index,#slider-range-min-single,#slider-range-min-page,#slider-range-min-author,#slider-range-min-cat,#slider-range-min-serch,#slider-range-min-tag");
    sliderRange.width(jQuery('#indexcctm').width()+5);
    
    function myDate(mTime){
        mDate = new Date();
        mDate.setUTCSeconds(mTime);
        mDate.setUTCMinutes(Math.floor(mTime/60));
        mDate.setUTCHours(Math.floor(mTime / 3600));
        if(mDate.getUTCHours() < 10){hors = '0' + mDate.getUTCHours();}else{hors = mDate.getUTCHours();}
        if(mDate.getUTCMinutes() < 10){min = '0' + mDate.getUTCMinutes();}else{min = mDate.getUTCMinutes();}
        if(mDate.getUTCSeconds() < 10){sec = '0' + mDate.getUTCSeconds();}else{sec = mDate.getUTCSeconds();}
        loadDate = hors + ':' + min + ':' + sec;
        return loadDate;
    }

    jQuery(function(){
        /* INDEX */
        jQuery("#slider-range-min-index").slider({range:"min",value:httpVar.setMyTime.index,min:0,max:86399,slide: function( event, ui ){jQuery("#indexcctm").val(myDate(ui.value));}});
        jQuery("#indexcctm" ).val(myDate( jQuery("#slider-range-min-index").slider( "value" )));
        /* SINGLE */
        jQuery("#slider-range-min-single").slider({range:"min",value:httpVar.setMyTime.single,min:0,max:86399,slide: function( event, ui ) {jQuery("#singlecctm").val(myDate(ui.value));}});
        jQuery("#singlecctm" ).val(myDate(jQuery("#slider-range-min-single").slider( "value" )));
        /* PAGE */
        jQuery("#slider-range-min-page").slider({range:"min",value:httpVar.setMyTime.page,min:0,max:86399,slide: function( event, ui ){jQuery("#pagecctm").val(myDate(ui.value));}});
        jQuery("#pagecctm" ).val(myDate(jQuery("#slider-range-min-page").slider( "value" )));
        /* AUTHOR */
        jQuery("#slider-range-min-author").slider({range:"min",value:httpVar.setMyTime.author,min:0,max:86399,slide: function( event, ui ) {jQuery("#authorcctm").val(myDate(ui.value));}});
        jQuery("#authorcctm" ).val(myDate(jQuery("#slider-range-min-author").slider( "value" )));
        /* CAT */
        jQuery("#slider-range-min-cat").slider({range:"min",value:httpVar.setMyTime.cat,min:0,max:86399,slide: function( event, ui ){jQuery("#catcctm").val(myDate(ui.value));}});
        jQuery("#catcctm" ).val(myDate(jQuery("#slider-range-min-cat").slider( "value" )));
        /* SEARCH */
        jQuery("#slider-range-min-serch").slider({range:"min",value:httpVar.setMyTime.search,min:0,max:86399,slide: function( event, ui ){jQuery("#searchcctm").val(myDate(ui.value));}});
        jQuery("#searchcctm" ).val(myDate(jQuery("#slider-range-min-serch").slider( "value" )));
        /* TAG */
        jQuery("#slider-range-min-tag").slider({range:"min",value:httpVar.setMyTime.tag,min:0,max:86399,slide: function( event, ui ){jQuery("#tagcctm").val(myDate(ui.value));}});
        jQuery("#tagcctm" ).val(myDate(jQuery("#slider-range-min-tag").slider( "value" )));
        
    }); 

    jQuery('#url-for-headers').width(jQuery('#settings-headers').width());
});
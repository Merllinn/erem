$(document).ready(
	function() {

        if($(".countrySelect").length>0){
            function checkCountry(){
                if($(".differentDeliveryCheck").prop('checked')){
                    var pickedCountry = $(".countrySelectDel").val().replace(" ", "-");
                }
                else{
                    var pickedCountry = $(".countrySelect").val().replace(" ", "-");
                }
                $(".countryRow").hide();
                $(".countryRow."+pickedCountry).show();
            }

            $(".countrySelect, .countrySelectDel, .differentDeliveryCheck").on("change", function(){
                $(".countryRow input").prop('checked', false);
                checkCountry();
            });

            checkCountry();
        }

        $('.chocolat-parent').Chocolat();
        $(".product .thumbnail img").mouseover(function(){
            var img = $(this).attr("src");
            $(".product .product-image img").attr("src", img);
        });

        $(".differentDeliveryCheck").change(function(){
            checkDifferentDelivery($(this));
        });
        checkDifferentDelivery($(".differentDeliveryCheck"));
        
        function checkDifferentDelivery(el){
            if(el.prop('checked')){
                $(".deliveryBlock").show();
            }
            else{
                $(".deliveryBlock").hide();
            }
        }

        $(".companyCheck").change(function(){
            checkCompany($(this));
        });
        checkCompany($(".companyCheck"));
        
        function checkCompany(el){
            if(el.prop('checked')){
                $(".companyBlock").show();
            }
            else{
                $(".companyBlock").hide();
            }
        }


        $(function () {
            $("#differentDeliveryCheck").click(function () {
                if ($(this).is(":checked")) {
                    $(".delivery.hide").show();
                } else {
                    $(".delivery.hide").hide();
                }
            });
        });

        var tickTimer;
        
        if($(".countdown").length > 0){
            var el;
            var start;
            var remaining;
            tickCounters()
        }
        
        function tickCounters(){
            var els = $(".countdown");
            els.each(function(){
                el = $(this);
                start = parseInt(el.data("start"));
                millis = Date.now();
                seconds = Math.floor(millis / 1000);
                remaining = start - seconds;
                if(remaining<=0){
                    clearTimeout(tickTimer);
                    location.reload();
                }
                else{
                   el.text(timeToText(remaining));
                }
                
            })
            tickTimer = setTimeout(tickCounters, 1000);
        }
        
        function timeToText(time){
            var days = Math.floor(time/(60*60*24));
            time = time - days*(60*60*24);
            
            var hours = Math.floor(time/(60*60));
            time = time - hours*(60*60);
            
            var minutes = Math.floor(time/60);
            time = time - minutes*60;
            
            var seconds = time;
            
            var text = "";
            if(days>0){
                itemText = "dní";
                if(days==1){
                    itemText = "den";
                }
                if(days>1 && days<5){
                    itemText = "dny";
                }
                text = text+days+" "+itemText+" ";
            }
            if(hours>0){
                itemText = "hodin";
                if(hours==1){
                    itemText = "hodinu";
                }
                if(hours>1 && hours<5){
                    itemText = "hodiny";
                }
                text = text+hours+" "+itemText+" ";
            }
            if(minutes>0){
                itemText = "minut";
                if(minutes==1){
                    itemText = "minutu";
                }
                if(minutes>1 && minutes<5){
                    itemText = "minuty";
                }
                text = text+minutes+" "+itemText+" ";
            }
            itemText = "sekund";
            if(seconds==1){
                itemText = "sekundu";
            }
            if(seconds>1 && seconds<5){
                itemText = "sekundy";
            }
            text = text+seconds+" "+itemText;
            return text;
        }

        $( "a#collapseSizeTable" ).click(function() {
            $("div#collapseSizeTable").toggle();
        });

    }
    
);
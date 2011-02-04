/*!
 * **************************************************************
 ****************  ProQuiz V2.0.0b ******************************
 ***************************************************************/
 /* documentation at: http://proquiz.softon.org/documentation/
 /* Designed & Maintained by
 /*                                    - Softon Technologies
 /* Developer
 /*                                    - Manzovi
 /* For Support Contact @
 /*                                    - proquiz@softon.org
 /* version 2.0.0 beta (2 Feb 2011)
 /* Licensed under GPL license:
 /* http://www.gnu.org/licenses/gpl.html
 */jQuery(document).ready(function() {
    var jsondata;
    var speed_slow = 2000;
    var speed_fast = 200;
    pq_setup();
    $('#counter').attr('value','1');
    instidata = $('#headerResults span').html();
    $('.pq_container div div div div').removeClass().addClass('pq_opt');
    $.post('functions.php',{action: "ssget",instid: instidata},function(data){
        jsondata = $.parseJSON(data);
    });
    $('#headerResults span').html('Your Quiz ID #'+ instidata );

    function newCall(i){
        $('*').stop();
        $('#qstn'+(i-1)).hide();
        $('#headerResults span').html('Question No. '+i);
        $('#headerResults span').show(speed_slow,function(){
            $('#qstn'+i).show();
            $('#qstn'+i+' div').show();
            $('#qstn'+i+' div div div div').hide();
            $('#qstn'+i+' div div div div').fadeIn(speed_slow,function(){
                $('#headerResults span').hide();
                $('#headerResults span').html('The Correct Answer was');
                $('#headerResults span').show(speed_fast,function(){
                    var coptid = checkCorrect(i,jsondata['correct'][i-1]);
                    $('#qstn'+i+' div div div .pq_opt').fadeTo(speed_fast,0.33,function(){
                         $('#qstn'+i+' div div div #'+coptid).addClass('pq_opt_correct').fadeTo(speed_slow,1,function(){
                            var yopt = checkYour(i,jsondata['correct'][i-1],jsondata['your'][i-1]);
                            if(yopt['flag'] == 2){
                                $('#headerResults span').hide();
                                $('#headerResults span').html(yopt['status']);
                                $('#headerResults span').show('fast',function(){
                                    $('#qstn'+i+' div div div #'+yopt['optid']).removeClass().addClass('pq_opt_wrong').fadeTo(speed_fast,1,function(){
                                        
                                    });
                                });    
                            }else{
                                if(yopt['flag'] == 0){
                                    $('#headerResults span').hide();
                                    $('#headerResults span').html(yopt['status']);
                                    $('#headerResults span').show('fast',function(){
                                        $('#qstn'+i+' div div div #'+yopt['optid']).removeClass().addClass('pq_opt_urrgt').fadeTo(speed_fast,1,function(){
                                            
                                        });
                                    });
                                }else{
                                    $('#headerResults span').hide();
                                    $('#headerResults span').html(yopt['status']);
                                    $('#headerResults span').show();
                                }
                            }
                         });
                    });
                });
            });
            
        }); 
    
    }
    // end main function
newCall(1);
$('#ss_next').click(function(){
   var count = $('#counter').attr('value'); 
   count = parseInt(count);
   newCall(count+1);
   $('#counter').attr('value',count+1);
});
        
function checkCorrect(j,data){
    var opt = $('#qstn'+j+' div div div div');
    var len = opt.length;
    for(k=0;k<len;k++){
        if($('#qstn'+j+' div div div #'+j+'_'+k).html() == '<span></span>'+data){
            return j+'_'+k;
        }
    }
}


function checkYour(j,cans,yans){
    var ans = new Array;
    if(cans == yans){
        ans['flag'] = 0;
        ans['status'] = 'Your ans was Correct';  
        var opt = $('#qstn'+j+' div div div div');
        var len = opt.length;
        for(k=0;k<len;k++){
            if($('#qstn'+j+' div div div #'+j+'_'+k).html() == '<span></span>'+cans){
                ans['optid'] =  j+'_'+k;
            }
        }  
    }else{
        if(yans == '0' || yans == null){
            ans['status'] = 'You Did not Attempt this one.';
            ans['optid'] =  false;
            ans['flag'] = 1;    
        }else{
            ans['status'] = 'Your ans was Wrong';
            ans['optid'] =  false;
            ans['flag'] = 2;
            var opt = $('#qstn'+j+' div div div div');
            var len = opt.length;
            for(k=0;k<len;k++){
                if($('#qstn'+j+' div div div #'+j+'_'+k).html() == '<span></span>'+yans){
                    ans['optid'] =  j+'_'+k;
                }
            }
        }
        
    }
    
    return ans;
}

function pq_setup(){
    $('.pq_container').hide();
    
}

});
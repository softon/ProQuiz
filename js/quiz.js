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
 */
jQuery(document).ready(function() {
			 
             //Timer Show/Hide Button
                $('#pqtimebtn').click(function(){
                   $('#countdown_dashboard').slideToggle(500);
                   $(this).toggleClass('pq_btnd');
                });
             
             $('#side_ua_cnt').slideToggle();
                
             // HSelect Answer   
                $('.pq_opt').click(function(){
                    var opt_id = $(this).attr('id');
                    var opt_arr = opt_id.split("_");
                    qstn_no = opt_arr[0];
                    $('#qstn'+qstn_no+' div div div div').removeClass('opt_clicked');
                    $('#qstn'+qstn_no+' div div div div').addClass('pq_opt');
                    $(this).removeClass('pq_opt');
                    $(this).addClass('opt_clicked');
                    $('#qstn'+qstn_no+' div div div div input').attr('checked','');
                    $('input',this).attr('checked','checked');
                    $('.paginationc ul li a:contains('+qstn_no+')').eq(0).addClass('pagin_btnd');
                    var qstn_qid = $('input',this).attr('name');
                    var ans = $('input',this).attr('value');
                    $.post('functions.php',{action: "interm_ans",qid: qstn_qid,answer: ans});
                });

				var time_var;
                pq_setup();
                
                // Start Quiz Event Trriger
                $('#pq_start').click(function(){
                    var speed = 800;
                    var img_url = $('.sideImg img').attr('src');
                    $('.sideImg img').attr('src','images/smileys/goodluck.gif');
                    $(this).addClass('pq_btnd');
                    $(this).html('Loading...');
                    $('#pq_progress').show();
                    var jsondata;
                    $.post('functions.php',{action: "getquizdata"},function(data){
                        jsondata = $.parseJSON(data);
                        time_var = $('#countdown_dashboard').countDown({
        					targetOffset: {
        						'day': 		00,
        						'month': 	00,
        						'year': 	0000,
        						'hour': 	0,
        						'min': 		Number(jsondata.total_time),
        						'sec': 		0
        					}
        				});
                        time_var.stopCountDown();
                    });
                    $('#side_ua_cnt').slideToggle(speed,function(){
                        $('#countdown_dashboard').fadeIn(speed,function(){
                            $('#qstn1').fadeIn(speed,function(){
                                $('.pq_ft').fadeIn(speed,function(){
                                    $(".start_quiz_hld").fadeOut(speed,function(){
                                        $('.pagination').fadeIn(speed,function(){
                                            $('.paginationc ul').append('<li><a class="pagin_btn" href="#">1</a></li>');
                                            if(Number(jsondata.total_qstn)>10){
                                                var k =10;
                                            }else{
                                                k = Number(jsondata.total_qstn);
                                            }
                                            
                                            for(var j=2;j<=k;j++){
                                                $('.paginationc ul').append('<li><span>|</span></li><li><a class="pagin_btn" href="#">'+j+'</a></li>');
                                            }
                                            pagin_click();
                                            $('#current_qstn').attr('value','1');
                                            $('#total_qstn').attr('value',jsondata.total_qstn);
                                            time_var.startCountDown();
                                            $('.sideImg img').attr('src',img_url);
                                        });
                                    });
                                });
                            });
                        });
                    });

    
                });
                
                // Next Question display
                $('#pq_next,#pagin_next').click(function(){
                    
                    var total_qstn = Number($('#total_qstn').attr('value'));
                    var current_qstn = Number($('#current_qstn').attr('value'));
                    var next_qstn = current_qstn + 1;
                    if(next_qstn>total_qstn){
                        next_qstn = 1;
                    }
                    $('#qstn'+current_qstn).hide();
                    $('#qstn'+next_qstn).show();
                    $('#current_qstn').attr('value',next_qstn);
                    
                    pagin_click();
                    
                });
                
                // Previous Question Display
                
                    $('#pq_prev,#pagin_prev').click(function(){
                    
                    var total_qstn = Number($('#total_qstn').attr('value'));
                    var current_qstn = Number($('#current_qstn').attr('value'));
                    var prev_qstn = current_qstn - 1;
                    if(prev_qstn<=0){
                        prev_qstn = total_qstn;
                    }
                    $('#qstn'+current_qstn).hide();
                    $('#qstn'+prev_qstn).show();
                    $('#current_qstn').attr('value',prev_qstn);
                    
                    pagin_click();
                    });
                
                
                
                // Selected Question Display
                function pagin_click(){
                    $('.paginationc ul li a').click(function(){
                    var this_qstn = Number($(this).html());
                    var current_qstn = Number($('#current_qstn').attr('value'));
                    $('#qstn'+current_qstn).hide();
                    $('#qstn'+this_qstn).show();
                    $('#current_qstn').attr('value',this_qstn);
                    
                    
                    });
                }
                
                
                
                // Previous Page Display for pagination
                $('#pagin_prev_sec').click(function(){
                    var page_ele = 10;
                    var page = Number($('.paginationc ul li a').html());
                    var total_qstn = Number($('#total_qstn').attr('value'));
                    if(page-page_ele > 0){
                       $('.paginationc ul').html('<li><a class="pagin_btn" >'+(page-page_ele)+'</a></li>');
                        getChecked(page-page_ele);
                        k=page-1;                        
                        for(var j=page-page_ele+1;j<=k;j++){
                            $('.paginationc ul').append('<li><span>|</span></li><li><a class="pagin_btn" >'+j+'</a></li>');
                            getChecked(j);
                        } 
                    }else{
                        page = Math.floor(total_qstn/10)*10 + 1;
                        if(page > total_qstn){
                            page = (Math.floor(total_qstn/10)-1)*10 + 1;
                              
                        }
                        $('.paginationc ul').html('<li><a class="pagin_btn" >'+page+'</a></li>');
                        getChecked(page);
                                                
                        for(var j=page+1;j<=total_qstn;j++){
                            $('.paginationc ul').append('<li><span>|</span></li><li><a class="pagin_btn" >'+j+'</a></li>');
                            getChecked(j);
                        }
                    }
                    pagin_click();
                });
                
                // Next Page Display for pagination
                $('#pagin_next_sec').click(function(){
                    var page_ele = 10;
                    var page = Number($('.paginationc ul li a').html());
                    var total_qstn = Number($('#total_qstn').attr('value'));
                    if(page+page_ele < total_qstn){
                       $('.paginationc ul').html('<li><a class="pagin_btn" >'+(page+page_ele)+'</a></li>');
                       getChecked(page+page_ele);
                        if(page+2*page_ele-1 < total_qstn){
                            k =page+2*page_ele-1;    
                        }else{
                            k = total_qstn;
                        }
                                                
                        for(var j=page+page_ele+1;j<=k;j++){
                            $('.paginationc ul').append('<li><span>|</span></li><li><a class="pagin_btn" >'+j+'</a></li>');
                            getChecked(j);
                        } 
                    }else{
                        $('.paginationc ul').html('<li><a class="pagin_btn" >1</a></li>');
                        getChecked(1);
                        k =10;                        
                        for(var j=2;j<=k;j++){
                            $('.paginationc ul').append('<li><span>|</span></li><li><a class="pagin_btn" >'+j+'</a></li>');
                            getChecked(j);
                        }
                    }
                    pagin_click();
                });
                
                
                // To find whether question answered or not
                function getChecked(qs){
                    if($('#qstn'+qs+' div div div div input:checked').length > 0 ){
                         $('.paginationc ul li a:contains('+qs+')').eq(0).addClass('pagin_btnd');
                    }                    
                   
                }
                
                // Submit Form When timer Expires
                $.fn.timerExpire = function(){
                    var speed = 1000;
                    $('#side_ua_cnt').slideToggle(speed,function(){
                        $('#countdown_dashboard').fadeOut(speed,function(){
                            $('.pq_container').fadeOut(speed,function(){
                                $('.pq_ft').fadeOut(speed,function(){
                                    
                                        $('.pagination').fadeOut(speed,function(){
                                            $('#pq_quiz_form').submit();
                                        });
                                    
                                });
                            });
                        });
                    });
                    
                    
                }
                
                function pq_setup(){
                    $('#countdown_dashboard').hide();
                    $('.pagination').hide();
                    $('.pq_ft').hide();
                    var start_str = '<span style="font-size:1.1em;" ><b>Your Quiz is ready,To start the Quiz Please click the "Start Quiz" Button Below.</b><br /><p><span style="font-weight:bold;color:red;font-size:0.9em;">Note:</span> <span style="font-size:1.1em;" >Please Do Not Refresh the Page from this point onwards otherwise all your progress will be lost.</span></span></p><div style="position: relative;"><div id="pq_start"  class="pq_btn">Start Quiz</div><br /></div><div id="pq_progress"><img src="images/progress.gif" /></div>';
                    $('.start_quiz_hld').html(start_str);
                    $('#pq_progress').hide();
                    $('.pq_container').hide();
                    
                }
                
                

                        

			});
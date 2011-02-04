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
 // Update User Online
function updateUserOnline(){
    passkey = getPassKey();
    $.post('functions.php?action=uuonline',{key:passkey},function(data){
        str = "";
        count = 0;
        for(i=0;i<data.online.length;i++){
            if(data.online[i].username == 'guest'){
                count++;
            }else{
                str += '<li><img src="images/online.png" />'+data.online[i].username+'</li>';     
            }
        }
        if(count>0){
            str += '<li><img src="images/online.png" />GUESTS ('+count+')</li>';   
        }
        $('#onlineUsersList').html(str);
        setTimeout('updateUserOnline()',6000);
    },"json");
    
}

// Get Pass Key
function getPassKey(){
    str1 = String.fromCharCode(115,111,102,116,111,110);
    str2 = $('#'+str1).html();
    return $.md5(str2);
}

jQuery(document).ready(function() {
    var options = {
		speed: 700,
		pause: 2000,
		showItems: 3,
		animation: '',
		mousePause: true,
		isPaused: false,
		direction: 'up',
		height: 150
	};
    $('#rankScroller').vTicker(options);
    
    // Profile Details Show/Hide Button
                $('#sideBtmCenter span').click(function(){
                   $('#side_ua_cnt').slideToggle(200);
                });
    $('#side_ua_cnt').slideToggle(200);
});
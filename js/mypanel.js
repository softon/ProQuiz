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
    // Profile Details Show/Hide Button
    $('#sideBtmCenter span').click(function(){
       $('#side_ua_cnt').slideToggle(200);
    });

    
    
    // TextQrea TinyMce Conversion
    $('#pq_question').tinymce({
			// Location of TinyMCE script
			script_url : 'js/tinymce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "style,table,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,fontsizeselect",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_buttons5 : "link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
            height : "300px"


		});
        
        //  TinyMCE for Content Editing *******************************************
        //************************************************************************/
    $('#cnt_value').tinymce({
			// Location of TinyMCE script
			script_url : 'js/tinymce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "style,table,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,fontsizeselect",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_buttons5 : "link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
            height : "300px"


		});
        
        $('#cnt_name').change(function(){
            var cntd = $(this).attr('value');
            if( cntd != ""){
                $.post('functions.php',{action:'getCntDetails',cnt:cntd},function(data){
                   $('#cnt_value').html(data); 
                });
            } 
        });
        
        
    // Table Design
		$('#results').dataTable( {
			"sPaginationType": "full_numbers",
            "aaSorting": [[ 0, "asc" ]]

		} );
        
        // Activate Table
        $('#activateQstn').dataTable( {
        	"sPaginationType": "full_numbers",
            "aaSorting": [[ 0, "asc" ]],
            "bStateSave": true

        } );
        
        $('.dataTables_length').corner('5px');
        $('.headDisp2').corner('5px');
        $('.dataTables_filter').corner('5px');
        $('.display').corner('5px');
        $('.dataTables_info').corner('5px');
        $('.paging_full_numbers span.paginate_button').corner('5px');
        $('.paging_full_numbers span.paginate_active').corner('5px');
        
        
    
    
    // Validation 
    $('#profile_edit').validate({
        rules: {
                    password: {
        				required: true,
        				minlength: 5
        			},
        			cpassword: {
        				required: true,
        				minlength: 5,
        				equalTo: "#edit_password"
        			},
                    email: {
        				required: true,
        				email: true,
        				remote: "functions.php"
        			},
                    username: {
        				required: true,
        				minlength: 4,
                        maxlength: 30,
        				remote: "functions.php"
        			}
                
                },
        messages: {
                   email: {
        				required: "Please enter a valid email address",
        				minlength: "Please enter a valid email address",
        				remote: jQuery.format("{0} is already in use")
        			}, 
                    username: {
        				remote: jQuery.format("{0} is already in use")
        			}
        }
        
    });

    
    
    
    
    
    
    
    /****************************************************************
    *****************  Add / Edit Category & Sub Caterory ***********
    ****************************************************************/
    $('li.cat_action').css('display','none');
    $('li.sub_cat_action').css('display','none');
    $('fieldset#subcat').css('display','none');
    
    //category action
    $('a#cat_add').click(function(){
         $('li.cat_action label span').html('Add New Category');
         $('li.cat_action input:[type=hidden]').attr('value','add');
         $('li.cat_action').show(200);
    });
    
    $('a#cat_edit').click(function(){
         $('li.cat_action label span').html('Edit Selected Category');
         $('li.cat_action input:[type=hidden]').attr('value','edit');
         $('li.cat_action').show(200);
    });
    
    $('li.cat_action #cat_cancel').click(function(){
        $('li.cat_action').hide(200);
    });
    
    
    // subcategory action
    $('a#sub_cat_add').click(function(){
         $('li.sub_cat_action label span').html('Add New Sub-Category');
         $('li.sub_cat_action input:[type=hidden]').attr('value','addsub');
         $('li.sub_cat_action').show(200);
    });
    
    $('a#sub_cat_edit').click(function(){
         $('li.sub_cat_action label span').html('Edit Selected Sub-Category');
         $('li.sub_cat_action input:[type=hidden]').attr('value','editsub');
         $('li.sub_cat_action').show(200);
    });
    
    $('li.sub_cat_action #sub_cat_cancel').click(function(){
        $('li.sub_cat_action').hide(200);
    });
    
    function updateCategory(){
        str = '<option value="" class="inactive" selected="selected" > -- </option>';
        $.post('functions.php',{action:'updatecat'},function(data){
            $('#cat_list').html(str+data);
        });
        
    }
    
    function updateSubCategory(cat){
        str = '<option value="" class="inactive" selected="selected" > -- </option>';
        $.post('functions.php',{action:'updatesubcat',category: cat},function(data){
            $('#sub_cat_list').html(str+data);
        });
        
    }
    
    $('li.cat_action #cat_save').click(function(){
        $('div#cat_ajax_status').addClass('cat_ajax_loading');
        $('div#cat_ajax_status').html('Saving...');
        var action = $('li.cat_action input:[type=hidden]').attr('value');
        var cat_data = $('li.cat_action input:[type=text]').attr('value');
        var cat_sel = $('select#cat_list option:[selected]').attr('value');
        if(action == 'add'){
            $.post('functions.php',{action:'necat',type: action,catdata: cat_data,curcat: cat_sel},function(data){
                if(data.error =='Done'){
                    updateCategory();
                    $('div#cat_ajax_status').removeClass().addClass('cat_ajax_done');
                    $('div#cat_ajax_status').html(data.status);
                    $('li.cat_action').hide(200);
                }else{
                    $('div#cat_ajax_status').removeClass().addClass('cat_ajax_error');
                    $('div#cat_ajax_status').html(data.status);
                }
            },"json");    
        }
        if(action == 'edit'){
            $.post('functions.php',{action:'necat',type: action,catdata: cat_data,curcat: cat_sel},function(data){
                if(data.error =='Done'){
                    updateCategory();
                    $('div#cat_ajax_status').removeClass().addClass('cat_ajax_done');
                    $('div#cat_ajax_status').html(data.status);
                    $('li.cat_action').hide(200);
                }else{
                    $('div#cat_ajax_status').removeClass().addClass('cat_ajax_error');
                    $('div#cat_ajax_status').html(data.status);
                }
            },"json");    
        }
        
    });
    
    
    $('li.sub_cat_action #sub_cat_save').click(function(){
        $('div#sub_cat_ajax_status').addClass('cat_ajax_loading');
        $('div#sub_cat_ajax_status').html('Saving...');
        var action = $('li.sub_cat_action input:[type=hidden]').attr('value');
        var sub_cat_data = $('li.sub_cat_action input:[type=text]').attr('value');
        var sub_cat_sel = $('select#sub_cat_list option:[selected]').attr('value');
        var cat_sel = $('select#cat_list option:[selected]').attr('value');
        if(action == 'addsub'){
            $.post('functions.php',{action:'nesubcat',type: action,subcatdata: sub_cat_data,cursubcat: sub_cat_sel,curcat: cat_sel},function(data){
                if(data.error =='Done'){
                    updateSubCategory(cat_sel);
                    $('div#sub_cat_ajax_status').removeClass().addClass('cat_ajax_done');
                    $('div#sub_cat_ajax_status').html(data.status);
                    $('li.sub_cat_action').hide(200);
                }else{
                    $('div#sub_cat_ajax_status').removeClass().addClass('cat_ajax_error');
                    $('div#sub_cat_ajax_status').html(data.status);
                }
            },"json");    
        }
        if(action == 'editsub'){
            $.post('functions.php',{action:'nesubcat',type: action,subcatdata: sub_cat_data,cursubcat: sub_cat_sel,curcat: cat_sel},function(data){
                if(data.error =='Done'){
                    updateSubCategory(cat_sel);
                    $('div#sub_cat_ajax_status').removeClass().addClass('cat_ajax_done');
                    $('div#sub_cat_ajax_status').html(data.status);
                    $('li.sub_cat_action').hide(200);
                }else{
                    $('div#sub_cat_ajax_status').removeClass().addClass('cat_ajax_error');
                    $('div#sub_cat_ajax_status').html(data.status);
                }
            },"json");    
        }
        
    });
    
    
    $('a#cat_del').click(function(){
        $('div#cat_ajax_status').addClass('cat_ajax_loading');
        $('div#cat_ajax_status').html('Saving...');
            var cat_sel = $('select#cat_list option:[selected]').attr('value');
            var cat_data = cat_sel;
             $.post('functions.php',{action:'necat',type: 'del',catdata: cat_data,curcat: cat_sel},function(data){
                if(data.error =='Done'){
                    updateCategory();
                    $('div#cat_ajax_status').removeClass().addClass('cat_ajax_done');
                    $('div#cat_ajax_status').html(data.status);
                }else{
                    $('div#cat_ajax_status').removeClass().addClass('cat_ajax_error');
                    $('div#cat_ajax_status').html(data.status);
                }
            },"json");   
    });
    
    $('a#sub_cat_del').click(function(){
        $('div#sub_cat_ajax_status').addClass('cat_ajax_loading');
        $('div#sub_cat_ajax_status').html('Saving...');
            var cat_sel = $('select#cat_list option:[selected]').attr('value');
            var sub_cat_sel = $('select#sub_cat_list option:[selected]').attr('value');
            var sub_cat_data = sub_cat_sel;
             $.post('functions.php',{action:'nesubcat',type: 'delsub',subcatdata: sub_cat_data,cursubcat: sub_cat_sel,curcat: cat_sel},function(data){
                if(data.error =='Done'){
                    updateSubCategory(cat_sel);
                    $('div#sub_cat_ajax_status').removeClass().addClass('cat_ajax_done');
                    $('div#sub_cat_ajax_status').html(data.status);
                }else{
                    $('div#sub_cat_ajax_status').removeClass().addClass('cat_ajax_error');
                    $('div#sub_cat_ajax_status').html(data.status);
                }
            },"json");   
    });
    
    
    
    
     $('#cat_list').change(function(){
        var action = $('li.cat_action input:[type=hidden]').attr('value');
        var cat_sel = $('select#cat_list option:[selected]').attr('value');
        if(action =='edit'){
            $('li.cat_action input:[type=text]').attr('value',cat_sel);
        }   
        if(cat_sel != ""){
            $('div#cat_ajax_status').addClass('cat_ajax_loading');
            $('div#cat_ajax_status').html('Getting Sub-Categories...');
            updateSubCategory(cat_sel);
            $('fieldset#subcat').show(200);
            $('div#cat_ajax_status').removeClass().addClass('cat_ajax_done');
            $('div#cat_ajax_status').html('Sucessfully Recieved Sub-categories for '+cat_sel);
        }else{
            $('#sub_cat_list').html('');
            $('fieldset#subcat').hide(200);
        } 
            
     });
     
     
     $('#sub_cat_list').change(function(){
        var action = $('li.sub_cat_action input:[type=hidden]').attr('value');
        var sub_cat_sel = $('select#sub_cat_list option:[selected]').attr('value');
        if(action =='editsub'){
            $('li.sub_cat_action input:[type=text]').attr('value',sub_cat_sel);
        }  
        
     });
     
     
     /****************************************************************
    *****************  Add / Edit New Question MCQ ***********
    ****************************************************************/
    $('li#quiz_sub_category').hide();
    $('#opt_count').attr('value','4');
    hideExtra();
    $('.errorDispCnt').hide();
    var options = { 
        //target:        '#output1',   // target element(s) to be updated with server response 
        beforeSubmit:  validateThis,  // pre-submit callback 
        success:       showResponse,  // post-submit callback 
 
        // other available options: 
        url:       "functions.php?action=getpage&page=newqstn&type=mcq&subaction=addqstn&submitType=ajax",         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    };
    
    $('#newqstn_mcq').ajaxForm(options);
    function validateThis(formData, jqForm, options){
        //$('#newqstn_mcq').validate();
        $('#errorDispDiv div').removeClass().addClass('errorDispLoading');
        $('#errorDispDiv div').html('Saving Data....');
        $('.errorDispCnt').show();
    }
    function showResponse(responseText, statusText, xhr, $form){
        if(responseText.type == 'Done'){
            $('div.ans_col2 div.sel_ans').html('Your Answer');
            $('#newqstn_mcq').resetForm();
            $form[0]['quiz_category'];
            $('#errorDispDiv div').removeClass().addClass('errorDispDone');
            $('#errorDispDiv div').html(responseText.reason);
            $('.errorDispCnt').show();
            $('.errorDispCnt').fadeOut(8000);

        }else{
            $('#errorDispDiv div').removeClass().addClass('errorDispError');
            $('#errorDispDiv div').html(responseText.reason);
            $('.errorDispCnt').show();
            $('.errorDispCnt').fadeOut(8000);

        }
        
        
    }

    
    
    
    $('select#quiz_category').change(function(){
        var cat = $('select#quiz_category option:[selected]').attr('value');
        str = '<option value="" class="inactive" selected="selected" > -- </option>';
        $.post('functions.php',{action:'updatesubcat',category: cat},function(data){
            $('select#quiz_sub_category').html(str+data);
            $('li#quiz_sub_category').show(200);
        });
    });
    
    $('select#quiz_sub_category').change(function(){
        var cat = $('select#quiz_category option:[selected]').attr('value');
        var subcat = $('select#quiz_sub_category option:[selected]').attr('value');
        if(cat=="" && subcat == ""){
             hideExtra();
        }else{
            unhideExtra();
        }
    });
    
    $('#options_cnt_new').click(function(){
        var cur_opt = $('#opt_count').attr('value');
        cur_opt++;
        add_opt = '<div class="options_cnt" id="option_'+cur_opt+'"><table><tr><td class="opt_input"><span>'+cur_opt+'</span></td><td class="opt_tarea"><textarea name="option_'+cur_opt+'" class="opt_ta"></textarea></td></tr></table></div>';
        $('#options_cnt').append(add_opt);
        add_ans = '<tr id="ans_opt_'+cur_opt+'"><td><span><input type="radio" name="opt_ans" value="" /></span></td><td><input type="button" name="option_'+cur_opt+'" class="sbutton" value="Option '+cur_opt+'" /></td></tr>';
        $('div.ans_col1 table').append(add_ans);
        $('#opt_count').attr('value',cur_opt);
        $('.opt_ta').corner('5px');
        $('.options_cnt').corner('5px');
    });
    
    $('#options_cnt_del').click(function(){
        var cur_opt = $('#opt_count').attr('value');
        $('div#option_'+cur_opt).remove();
        $('tr#ans_opt_'+cur_opt).remove();
        cur_opt--;
        $('#opt_count').attr('value',cur_opt);
    });
    
    $('div.ans_col1 table tr').click(function(){
        var opt_str = $(this).attr('id'); 
        var opt_num = opt_str.split('_');
        var ans = $('div#option_'+opt_num[2]+' table tr td textarea').val(); 
        if(ans!=''){
            $('tr#ans_opt_'+opt_num[2]+' td span input:[type="radio"]').attr('checked','checked');
            $('div.ans_col2 div.sel_ans').html(ans);
            $('#correct_ans').attr('value',ans);
        }
        
        
    });
    
    
    function hideExtra(){
            $('fieldset#mcq_qstn_ta').hide();
            $('fieldset#mcq_option_ta').hide();
            $('fieldset#mcq_ans_input').hide();
            $('fieldset#mcq_oq_flag').hide();
            $('fieldset#new_qstn_submit').hide();
    }
    function unhideExtra(){
            $('fieldset#mcq_qstn_ta').show();
            $('fieldset#mcq_option_ta').show();
            $('fieldset#mcq_ans_input').show();
            $('fieldset#mcq_oq_flag').show();
            $('fieldset#new_qstn_submit').show();
    }
    
    // contact admin form validation
    $('#ca_form').validate();
    $('#captchaInput input').click(function(){
        $(this).attr('value','')   
    });
    
});
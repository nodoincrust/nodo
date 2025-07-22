/*
 * Name: 
 * Date: 16/8/2014
 * Create by :Mahendra Kadam
 * Summary : To validate report form
 */

var flag;

$(document).ready(function() {
    $('#form_report').find('[name="problem_category"]')
					 .selectpicker()
					 .change(function(e) {
                     // revalidate the problem_category when it is changed
                     $('#form_report').bootstrapValidator('revalidateField', 'problem_category');
                      })
                     .end()
			         .bootstrapValidator({
						excluded: ':disabled',
                        message: 'This value is not valid',

					//        threshold: 11,
							fields: {
								report_type: {
									validators: {
										notEmpty: {
											message: 'The problem title is required and can\'t be empty'
										}
										
									}
								},            
								txtarea_report:{
									validators: {
										notEmpty: {
											message: 'The description is required and can\'t be empty'
										}
										
									}
								},
								problem_category:{
									validators: {
										notEmpty: {
											message: 'The problem category is required and can\'t be empty'
										}
										
									}
								}	
							}
						})
    .on('success.field.bv', function(e, data) {
            var $parent = data.element.parents('.form-group');
            $parent.removeClass('has-success');
            $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
			flag = true;
        })
	.on('error.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target),
        bootstrapValidator1 = $form.data('bootstrapValidator');
		flag = bootstrapValidator1.isValid();
	});

});

/*
 * Summary : To show read more on click 
 */


$('article').readmore({
	maxHeight: 30,
	speed: 100, 
	moreLink: '<a href="#">Read More</a>',
	lessLink: '<a href="#">Close</a>',
	embedCSS: true,
	sectionCSS: 'display: block; width: 100%;',
	startOpen: false,
	expandedClass: 'readmore-js-expanded',
	collapsedClass: 'readmore-js-collapsed',
	 
	// callbacks
	beforeToggle: function(){},
	afterToggle: function(){}
});		


 /*
 * Summary : The function is used to add class to articles at run time .
 */

function call_readmore()
{
	$('article').readmore({
		maxHeight: 30,
		speed: 100, 
		moreLink: '<a href="#">Read More</a>',
		lessLink: '<a href="#">Close</a>',
		embedCSS: true,
		sectionCSS: 'display: block; width: 100%;',
		startOpen: false,
		expandedClass: 'readmore-js-expanded',
		collapsedClass: 'readmore-js-collapsed',
		// callbacks
		beforeToggle: function(){},
		afterToggle: function(){}
	});		
}



function showdiv()
{
    $('.replydiv').css('display','block');
    $('.reply').css('display','none');
}
/*
 * Summary : The function is get to report details from database. The id passed is of DefectLog _id 
 */
var dialogInstance2 = new BootstrapDialog({draggable: true});
function show_defect_log_history(id)
{
  
	$.ajax({
			type: "POST",
			data:{
					id:id,
					type:'retrieve'
				},
			//dataType: "json",
			url: "report_process.php",
			success:function(response){
				var data = $.parseJSON(response);
				var comments = data.commentArray;
				var raised = data.raisedArray;
				var status = data.statusArray;
				var date = data.dateArray;
				
				dialogInstance2.setTitle('Report');
				var str = "";
				for(i=0 ; i<comments.length ;i++ )
				{
					str = str + "<a>Send By: </a>"+ raised[i]+"<br><a> Dated On:</a>"+date[i]+"<br><a> Comments :</a>"+comments[i]+"<br><a>Status :</a>"+status[i]+"<br><br>";
				}
                                if(status[comments.length-1]!='Closed'){
                                    str +="<div class='row'><div class='col-md-offset-10 reply'><input type='button' class='btn btn-info replybtn' value='Reply' onclick='showdiv();'></div></div>";
                                    str +='<div class="replydiv hide"><div class="form-group row">';
                                    str +='<label for="txt_report_title" class="col-md-2 control-label" id="" style="text-align:right;">Solution</label>';
                                    str +='<div class="col-md-6"><textarea class="form-control" id="solutioncomments" placeholder="" name=""></textarea></div>';
                                    str +='<div class="col-md-4"><select class="form-control selectpicker" id="sel_status" name="problem_category">';
                                    str +='<option value="">Status</option>';
                                    str +='<option value="Notification">Notification</option>';
                                    str +='<option value="opened">Opened</option>';
                                    str +='<option value="inprogress">InProgress</option>';
                                    str +='<option value="resolved">Resolved</option>';
                                    str +='<option value="colsed">Closed</option>';
                                    str +='</select></div>';               

                                    str +='</div>';
                                    str +='<div class="row"><div class="col-md-10 col-md-offset-1"><input type="button" class="btn btn-success btn-space" value="Send" onclick="sendreply(\''+id+'\');"><input type="button" class="btn btn-default" value="Cancel" onclick="closeDialog();"></div></div>';
                                    str +='</div>';
                                }
				dialogInstance2.setMessage(str);
                                dialogInstance2.setType(BootstrapDialog.TYPE_SUCCESS);
				dialogInstance2.open();

			}
		});
}

function closeDialog()
{
    dialogInstance2.close();
}
//$('button.close').click(function(){
//    dialogInstance2.close();
//
//});
/*
 * Summary : The function is used to send report data to database .
 */

function sendreply(id)
{
    comments = $('#solutioncomments').val();
    status =$('#sel_status option:selected').text()
    //alert(comments+' '+ id+' '+status);
    
        if(status != '' && status != 'Notification')
        {
            if(comments != '')
            {
            var q = confirm("Do You want to report a problem");
            if(q)
            {
                 $.ajax({
                        type: "POST",
                        data:{
                                id:id,
                                status:status,
                                comments:comments,
                                type:'reply'
                              },
                        url: "report_process.php",
                        success:function(response){
                           // alert(response);
                                        $.ajax({
                                                type: "POST",
                                                data:{
                                                        id:id,
                                                        status:status,
                                                        comments:comments,
                                                        mailto:"",
                                                        mailfrom:'dmstree.helpline@gmail.com',
                                                        type:'admin'
                                                      },
                                                url: "adminsendmail.php",
                                                success:function(response){
                                                    //alert(response);
                                                    dialogInstance2.close();
                                                    location.reload();
                                                }
                                            });
                                //alert(response);
                                //location.reload();
                        }
                    });
               }
            } else{
            alert('Solution is required it cannot be empty');
        }
               
            }
            else if(status == 'Notification'){
                 
                        $.ajax({
                                    type: "POST",
                                    data:{
                                            id:id,
                                            status:status,
                                            comments:comments,
                                            mailto:"dmstree.helpline@gmail.com",
                                            mailfrom:'dmstree.helpline@gmail.com',
                                            type:'admin'
                                          },
                                    url: "adminsendmail.php",
                                    success:function(response){
                                        //alert(response);
                                        dialogInstance2.close();
                                        location.reload();
                                    }
                                });
            }
            else{
                 alert('Please select status');
            }
        
       
}
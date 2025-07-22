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


/*
 * Summary : The function is used to send report data to database .
 */

function send()
{
	var  category=$('#sel_problem_category').val();
	var title = $('#txt_report_title').val();
	var discription = $('#txtarea_description').val();
	var comments =  $('#txtarea_comments').val();
	$('#form_report').bootstrapValidator('validate');
	if(flag)
	{
            var q = confirm("Do You want to report a problem");
            if(q)
            {
		$.ajax({
				type: "POST",
				data:{
						category:category,
						title:title,
						discription:discription,
						comments:comments,
						type:'save'
					 },
				url: "report_process.php",
				success:function(response){
                                                $.ajax({
                                                            type: "POST",
                                                            data:{
                                                                            category:category,
                                                                            title:title,
                                                                            discription:discription,
                                                                            comments:comments,
                                                                            mailto:"dmstree.helpline@gmail.com",
                                                                            mailfrom:'',
                                                                            type:'user'
                                                                            
                                                                     },
                                                            url: "adminsendmail.php",
                                                            success:function(response){
                                                            }
                                                    });
                                                var actiontext = '';
                                                actiontext = title+" Problem is created";
                                                    $.ajax({
                                                        type: "POST",
                                                        data: {
                                                            actiontext : actiontext
                                                        },
                                                        url: "track_history.php",
                                                        success: function(response){ 
                                                            alert('Problem mail send Successfully.');
                                                        }   
                                                    });
					location.reload();
				}
			});
            }
	}
}
/*
 * Summary : The function is get to report details from database. The id passed is of DefectLog _id 
 */
function show_defect_log_history(id)
{
	$.ajax({
			type: "POST",
			data:{
					id:id,
					type:'retrieve'
				},
			url: "report_process.php",
			success:function(response){
				var data = $.parseJSON(response);
				var comments = data.commentArray;
				var raised = data.raisedArray;
				var status = data.statusArray;
				var date = data.dateArray;
				var dialogInstance2 = new BootstrapDialog();
				dialogInstance2.setTitle('Report');
				var str = "";
				for(i=0 ; i<comments.length ;i++ )
				{
					str = str + "<a>Send By: </a>"+ raised[i]+"<br><a> Dated On:</a>"+date[i]+"<br><a> Comments :</a>"+comments[i]+"<br><a>Status :</a>"+status[i]+"<hr> <br>";
				}
				dialogInstance2.setMessage(str);
				dialogInstance2.setType(BootstrapDialog.TYPE_SUCCESS);
				dialogInstance2.open();
			}
		});
}
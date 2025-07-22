/*
* Name: 
* Date: 22/8/2014
* Create by :Mahendra Kadam
* Summary : This function is used to focus the text box on click of anchor(comment)
*/
function focusComment(txt) 
 {	

	var values1 =  $(txt).parent().parent().parent().prop('id');
	var dis_value=$('#'+values1).children(':eq(2)').css('display');
	values=$(txt).parent().parent().children(':eq(1)').children().prop('id');
	if(dis_value=='none'){
		$('#'+values1).children(':eq(2)').css('display','block');
		$('#'+values).attr('src','img/delete.png');
	}
	$(txt).parent().parent().parent().children(':eq(2)').children().children().children(':eq(1)').children(':eq(0)').children().focus();
}
function focusTag(txt) 
 {	

	var values1 =  $(txt).parent().parent().parent().prop('id');
	var dis_value=$('#'+values1).children(':eq(2)').css('display');
	values=$(txt).parent().parent().children(':eq(1)').children().prop('id');
	if(dis_value=='none'){
		$('#'+values1).children(':eq(2)').css('display','block');
		$('#'+values).attr('src','img/delete.png');
	}
	$('.tag-editor').attr('onclick','hideFocus()');
	$('#'+values1).find('ul').css('box-shadow','inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6)');
	
}
function hideFocus()
{
	$('.tag-editor').css('box-shadow','');
}
$('.tag-editor').click(function(){
	alert('Please.....');
});

/*
 * Name: 
 * Date: 22/8/2014
 * Create by :Mahendra Kadam
 * Summary : This function is used to hide all div which class is .hide_div.
 */

$(document).ready(function (){
	//$('.hide_div').css('display','none');
});

/*
 * Summary : This function is used to hide all div which class is .hide_div.
 */
 
function showHideDiv(values)
{

	var values1 =  $('#'+values).parent().parent().parent().prop('id');
	var dis_value=$('#'+values1).children(':eq(2)').css('display');
	if(dis_value=='none'){
		$('#'+values1).children(':eq(2)').css('display','block');
		$('#'+values).attr('src','img/delete.png');
	}
	if(dis_value=='block'){
		$('#'+values1).children(':eq(2)').css('display','none');
		$('#'+values).attr('src','img/add-icon.png');
	}
}

/*
 * Summary : This code is use to change the image and text on click of image.
 */
$('.checkin').click(function() {
	var img=$(this).children(':eq(0)').attr('src');
	img1=img.substring(img.lastIndexOf('/')+1,img.indexOf('.'));
	if(img1=='checkin')
	{
		$(this).children(':eq(0)').attr('src','img/checkout.png');
		
		$(this).children(':eq(0)').siblings().text('Check Out');
	}
	if(img1=='checkout')
	{
		$(this).children(':eq(0)').attr('src','img/checkin.png');
		
		$(this).children(':eq(0)').siblings().text('Check In');
	}

});    

/*******************************************************/


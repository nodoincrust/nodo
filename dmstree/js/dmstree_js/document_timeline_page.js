/*
 * Name: 
 * Date: 21/8/2014
 * Create by :Mahendra Kadam
 * Summary : This code create a comment block which is show on document time line page.
 */
$('.btn_comment').click(function() {
    var day=new Date();
    var hour = day.getHours();
    var min = day.getMinutes();
    

    day=day.toDateString();
	 text=$(this).parent().parent().children().children().val();  //to fetch the value of input box
	commenthtml='<div class="more-comment div-padding" >';
	commenthtml+='<a><i>Comment By:</i></a>'+text;									 
	commenthtml+='<div class="date colour">'+ day+' at'+hour+':'+min+'</div> </div>'										
	if(text!='')
	{

     $(commenthtml).insertAfter($(this).parent().parent().parent().children().children().siblings().first());//to insert new block of comment #comment-more class
     $(this).parent().parent().children().children().first().val("");
	}
	else{
		alert('Please Enter some Comments' );
	}
});

/*
 * Summary : This code is use to change the image and text on click of image.
 */
$('.checkin').click(function() {
	var img=$(this).children(':eq(0)').attr('src');
	//alert(img);
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

/*
 * Summary : This code focus the text box on anchor click.
 */
function focusComment(txt) 
{
    $("#"+txt).focus();
}

/*
 * Name: 
 * Date: 30/8/2014
 * Create by :Mahendra Kadam
 * Summary : This function is used to hide all div which class is .hide_div.
 */

$(document).ready(function (){
	$('.hide_div').css('display','none');
});

/*
 * Summary : This function is used to hide all div which class is .hide_div.
 */
 
function showHideDiv(values)
{

	var values1 =  $('#'+values).parent().parent().parent().prop('id');
	//alert(values1);
	var dis_value=$('#'+values1).children(':eq(2)').css('display');
	//alert(dis_value);
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
 * Summary : This code is for tags 
 */
(function($){
	var proto=$.ui.autocomplete.prototype,initSource=proto._initSource;
	function filter(array,term){
		var matcher=new RegExp($.ui.autocomplete.escapeRegex(term),"i");
		return $.grep(array,function(value){
	return matcher.test($("<div>").html(value.label||value.value||value).text());
	});}
	$.extend(proto,{_initSource:function(){
		if(this.options.html&&$.isArray(this.options.source))
		{
		this.source=function(request,response){
			response(filter(this.options.source,request.term));
		};}
		else{initSource.call(this);}
	},_renderItem:function(ul,item){
return $("<li></li>").data("item.autocomplete",item).append($("<a></a>")[this.options.html?"html":"text"](item.label)).appendTo(ul);}});})
(jQuery);

        var cache = {};
        function googleSuggest(request, response) {
            var term = request.term;
			
            if (term in cache) { response(cache[term]); return; }
            $.ajax({
                url: '',
                dataType: 'JSONP',
                data: { format: 'json', q: 'select * from xml where url="http://google.com/complete/search?output=toolbar&q='+term+'"' },
                success: function(data) {
                    var suggestions = [];
                    try { var results = data.query.results.toplevel.CompleteSuggestion; } catch(e) { var results = []; }
                    $.each(results, function() {
                        try {
                            var s = this.suggestion.data.toLowerCase();
                            suggestions.push({label: s.replace(term, '<b>'+term+'</b>'), value: s});
                        } catch(e){}
                    });
                    cache[term] = suggestions;
                    response(suggestions);
                }
            });
        }

            $('.hero-demo').tagEditor({
                placeholder: 'Enter tags ...',
            });
			 
/*
* Name: 
 * Date: 22/8/2014
 * Create by :Mahendra Kadam
 * Summary : This function is used to focus the text box on click of anchor(comment)
 */
function focusComment(txt) 
 {	

	var values1 =  $(txt).parent().parent().parent().prop('id');
	//alert(values1);
	var dis_value=$('#'+values1).children(':eq(2)').css('display');
	//alert(dis_value);
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
	//alert(values1);
	var dis_value=$('#'+values1).children(':eq(2)').css('display');
	//alert(dis_value);
	values=$(txt).parent().parent().children(':eq(1)').children().prop('id');
	if(dis_value=='none'){
		$('#'+values1).children(':eq(2)').css('display','block');
		$('#'+values).attr('src','img/delete.png');
	}
	//$(txt).parent().parent().parent().children(':eq(2)').children(':eq(1)').children().children(':eq(1)').children(':eq(0)').children().focus();
	// $('#'+values1+' ul').focus();
	$('.tag-editor').attr('onclick','hideFocus()');
	$('#'+values1).find('ul').css('box-shadow','inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6)');
	//$('.tag-editor').css('box-shadow','inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6)');
	
}
function hideFocus()
{
	$('.tag-editor').css('box-shadow','');
	//alert('ddddddddddddddd');
}

jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			loadingImage : 'facebox-master/src/loading.gif',
			closeImage   : 'facebox-master/src/closelabel.png'
		  })
		})   
		
$(document).bind('afterClose.facebox', function(){
                    $('a[rel*=facebox]').show();
            });

function show_article()
{
	  var dialogInstance2 = new BootstrapDialog();
        dialogInstance2.setTitle('Dialog instance 2');
        dialogInstance2.setMessage('Hi Orange!');
        dialogInstance2.setType(BootstrapDialog.TYPE_SUCCESS);
        dialogInstance2.open();
}

 $('a[rel*=facebox]').click(function(){
	$('a[rel*=facebox]').hide();
 });
 $('#facebox').hide(function(){
	alert('hi');
	$('a[rel*=facebox]').show();
 });
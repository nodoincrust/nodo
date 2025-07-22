function redirectPage(){
 var bouquetname = $('#txt_bouquet_name').val();
 if(bouquetname != '')
   $('#bouquetname').val(bouquetname);
   document.getElementById("bouquetnameForm").submit(); 

}
function removeDiv(txt)
{
$(txt).parent().parent().parent().remove();
}
function dynamicURL(documentName,revisionNo,docid)
{
    $.facebox.settings.closeImage = 'img/close_button.png';
    $.facebox.settings.loadingImage = 'img/loading.gif';
    var ajaxpostID = "view_document.php?doc="+documentName+"&revision="+revisionNo+"&documentid="+docid; 
    jQuery.facebox({ajax: ajaxpostID});

}
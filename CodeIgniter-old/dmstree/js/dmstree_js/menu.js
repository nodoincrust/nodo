function list_menu(list)
{
   // var menu;
 switch(list)
 {
//     case 'Dashboard':
//         
////          menu="<div><?php include_once'body_dash.php'?></div>";
//         $('#body-content').load('body_dash.php');
//         break;
//     case 'upload':
//         
////          menu="<div><?php include_once'upload_document.php'?></div>";
//         $('#body-content').load('upload_document.php');
//         break;
 
    case 'create_custom':
        alert("switch");
//        alert($('#body-content').html());
//         $('#body-content').load("document_template.php");
//         alert($('#body-content').html());
         var test_content = '<p>This is testing load function</p>';
         alert($('#body-content').find("#test_load").html());
         $('#body-content').find("#test_load").load("sign_up.php");
 }   
}
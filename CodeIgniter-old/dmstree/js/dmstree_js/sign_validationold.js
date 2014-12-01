/*
 * Name: Sign form 
 * Date: 26/7/2014
 * Create by :Mahendra Kadam
 * Summary : To select individual or corporate and then package, depending on package display the infornation.  
 */


$( "input[type='radio']" ).on( "click", function() {
  var check=$( this ).val();
  var rate1=100;
  var rate2=200;
  var rate3=300;
  var tax_rate=0.10;
  var recharge_one_month=1;
  var recharge_six_month=3;
  var recharge_nine_month=9;
  var today = new Date().toString('M/d/yyyy');

 switch(check)
 {
            case "corporate":  
                                $("#rd_individual_package1").prop("checked",false);
                                $("#rd_individual_package2").prop("checked",false);
                                $("#rd_individual_package3").prop("checked",false);
                                $("#rd_individual_package1").prop("disabled",true);
                                $("#rd_individual_package2").prop("disabled",true);
                                $("#rd_individual_package3").prop("disabled",true);
                                $("#rd_corporate_package1").prop("disabled",false);
                                $("#rd_corporate_package2").prop("disabled",false);
                                $("#rd_corporate_package3").prop("disabled",false);
                                $("#txt_package").val("");
                                $("#txt_recharge_date").val("");
                                $("#txt_package_price").val("");
                                $("#txt_taxes").val("");
                                $("#txt_total_amount").val("");
                                $(".individual").hide();
                                break;
            case "individual": 
                                $("#rd_corporate_package1").prop("checked",false);
                                $("#rd_corporate_package2").prop("checked",false);
                                $("#rd_corporate_package3").prop("checked",false);
                                $("#rd_corporate_package1").prop("disabled",true);
                                $("#rd_corporate_package2").prop("disabled",true);
                                $("#rd_corporate_package3").prop("disabled",true);
                                $("#rd_individual_package1").prop("disabled",false);
                                $("#rd_individual_package2").prop("disabled",false);
                                $("#rd_individual_package3").prop("disabled",false);
                                $("#txt_package").val("");
                                $("#txt_recharge_date").val("");
                                $("#txt_package_price").val("");
                                $("#txt_taxes").val("");
                                $("#txt_total_amount").val("");
                                 $(".individual").show();
                            break;
     case "individual_package1": 
                                    $("#txt_package").val("Package-1");
                                    $("#txt_recharge_date").val( recharge_one_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
                                    $("#txt_package_price").val(rate1);
                                    tax=rate1*tax_rate;
                                    $("#txt_taxes").val(tax);
                                    price =rate1+tax;
                                    $("#txt_total_amount").val(price);
                                    break;
     case "individual_package2":
                                    $("#txt_package").val("Package-2");
                                    $("#txt_recharge_date").val(recharge_six_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
                                    $("#txt_package_price").val(rate2);
                                    tax=rate2*tax_rate;
                                    $("#txt_taxes").val(tax);
                                    price =rate2+tax;
                                    $("#txt_total_amount").val(price);
                                    break;
     case "individual_package3": 
                                    $("#txt_package").val("Package-3");
                                    $("#txt_recharge_date").val(recharge_nine_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
                                    $("#txt_package_price").val(rate3);
                                    tax=rate3*tax_rate;
                                    $("#txt_taxes").val(tax);
                                    price =rate3+tax;
                                    $("#txt_total_amount").val(price);
                                    break;
     case "corporate_package1": 
                                    $("#txt_package").val("Package-1");
                                    $("#txt_recharge_date").val(recharge_one_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
                                    $("#txt_package_price").val(rate1);
                                    tax=rate1*tax_rate;
                                    $("#txt_taxes").val(tax);
                                    price =rate1+tax;
                                    $("#txt_total_amount").val(price);
                                    break;
     case "corporate_package2":
                                    $("#txt_package").val("Package-2");
                                    $("#txt_recharge_date").val(recharge_six_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
                                    $("#txt_package_price").val(rate2);
                                    tax=rate2*tax_rate;
                                    $("#txt_taxes").val(tax);
                                    price =rate2+tax;
                                    $("#txt_total_amount").val(price);
                                    break;
     case "corporate_package3": 
                                    $("#txt_package").val("Package-3");
                                    $("#txt_recharge_date").val(recharge_nine_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
                                    $("#txt_package_price").val(rate3);
                                    tax=rate3*tax_rate;
                                    $("#txt_taxes").val(tax);
                                    price =rate3+tax;
                                    $("#txt_total_amount").val(price);
                                    break;
 }
});

$( "#doc-1" ).on( "click", function() {
    $(".doc1").show();
    $(".doc2").hide();
    
});
$( "#doc-2" ).on( "click", function() {
    $(".doc2").show();
    $(".doc1").hide();
    
});
$(document).ready(function(){
    $(".doc1").hide();
    $(".doc2").hide();
}
);


/*
 * Name: Reset sign form
 * Date: 26/7/2014
 * Create by :Mahendra Kadam
 * Summary : To reset the sign up form 
 */

function reset_registrationform()
{
     $('#registrationForm').data('bootstrapValidator').resetForm();
}


/*
 * Name: Reset login form
 * Date: 26/7/2014
 * Create by :Mahendra Kadam
 * Summary : To reset the login form 
 */
function reset_loginform()
{
     $('#loginForm').data('bootstrapValidator').resetForm();

}

/*
 * Name: Usage Meter
 * Date: 27/7/2014
 * Create by :Mahendra Kadam
 * Summary : To show useage meter 
 */
      var g1;
      
      window.onload = function(){
      var g1 = new JustGage({
          id: "g1", 
          value: getRandomInt(0, 100), 
          min: 0,
          max: 100,
          title: "Usage Meter",
          label: "",
          levelColorsGradient: false
        });
        setInterval(function() {
          g1.refresh(getRandomInt(0, 100));
        }, 5000);
      };



$('.template').change( function(){
   // alert($(this).val());
    $("#template").load("demo2.php");
});

function focusComment(txt) 
{
    $("#"+txt).focus();
}

/*
 * Name: 
 * Date: 31/7/2014
 * Create by :Mahendra Kadam
 * Summary : To add comment on click of comment button
 */
$('.btn_comment').click(function() {
    var day=new Date();
    var hour = day.getHours();
    var min = day.getMinutes();
    

    day=day.toDateString();
   

    var att=document.createAttribute("class");
    att.value="div-padding more-comment";
    
    var div1=document.createElement("div");
    div1.setAttributeNode(att);
    
    var a=document.createElement("a");
    var i=document.createElement("i");
    a.appendChild(i);
    var div2=document.createElement("div");
    att=document.createAttribute("class");
    att.value="colour";
    text=document.createTextNode(day+" at "+hour+":"+min);
    div2.setAttributeNode(att);
    div2.appendChild(text);
    
    var text=document.createTextNode("Comment By:");
    i.appendChild(text);

      text=document.createTextNode($(this).parent().parent().children().children().val());  //to fetch the value of input box      

    
    div1.appendChild(a);
    div1.appendChild(text);
    div1.appendChild(div2);

     $(div1).insertAfter($(this).parent().parent().parent().children().children().siblings().first());//to insert new div after #comment-more class
     $(this).parent().parent().children().children().first().val("");
});

/*
 * Name: 
 * Date: 31/7/2014
 * Create by :Mahendra Kadam
 * Summary : To add tag on click of tag button
 */

$('.btn_tag').click(function() {
    var day=new Date();
    var hour = day.getHours();
    var min = day.getMinutes();
    

    day=day.toDateString();
   
    var com=document.getElementById("add-comment");
    var att=document.createAttribute("class");
    att.value="div-padding more-comment";
    
    var div1=document.createElement("div");
    div1.setAttributeNode(att);
    
    var a=document.createElement("a");
    var i=document.createElement("i");
    a.appendChild(i);
    var div2=document.createElement("div");
    att=document.createAttribute("class");
    att.value="colour";
    text=document.createTextNode(day+" at "+hour+":"+min);
    div2.setAttributeNode(att);
    div2.appendChild(text);
    
    var text=document.createTextNode("Comment By:");
    i.appendChild(text);

      text=document.createTextNode($(this).parent().parent().children().children().val());  //to fetch the value of input box      

    
    div1.appendChild(a);
    div1.appendChild(text);
    div1.appendChild(div2);

     $(div1).insertAfter($(this).parent().parent().parent().children().children().siblings().first());//to insert new div after #comment-more class
     $(this).parent().parent().children().children().first().val("");
});



function show_doc(doc)
{
    if(doc=='doc1_1')
        {
            $('#doc2_1').hide();
            $('#doc1_1').show()
        }
     if(doc=='doc2_1')
        {
            $('#doc1_1').hide();
            $('#doc2_1').show()
        }
}
$( document ).ready(function() {
  $('#doc1_1').hide();
  $('#doc2_1').hide();


});

$('#pdffile').change(function(){
     $('#subfile').val($(this).val());
});
$('#txt_pic').change(function(){
     $('#txt_picture').val($(this).val());
});

   
 $(document).ready(function(){
    $("#div_pic").hide();
}
);   
 
 $( "input[type='checkbox']").on( "click", function() {
      if($(this).prop('checked')) {
           $("#div_pic").show(); 
      } else {
          $("#div_pic").hide();
      }
 });
 
function reset_upload(){
    location.reload();
}

function reset_pic(){
    $("#txt_picture").val("");
    $("#target").attr("src","");
}
 


$(function () {
    
                $('#datetimepicker').datetimepicker({
                    pickTime: true
                });
            });

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                $('#target').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#txt_pic").change(function(){
        readURL(this);
    });
    
    
   
<?php 
        ob_start();
	session_start();
        include 'session_timeout.php';
	include 'session_config.php';
        require('CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
	$g1 = new Get_mongodb();
        
	$userId = $_SESSION['userid'];
	$tenantId = $_SESSION['usertenant'];
	$result = $g1->get_mongodb->getStandardListName($tenantId);
?>


<html>
    <head>
        <link rel="stylesheet" href="Photo-Tagging-Plugin-jTag/css/jquery-ui.custom.css">
        <link rel="stylesheet" href="Photo-Tagging-Plugin-jTag/css/jquery.tag.css">
        
        <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js'></script>
        <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js'></script>
        <script type='text/javascript' src='jquery-browser-plugin-master/dist/jquery.browser.min.js'></script>
        <script type="text/javascript" src="Photo-Tagging-Plugin-jTag/source/jquery.tag.js"></script>
    </head>
    <body>
        <div>
            <img id="target" src="<?php echo $_POST['photoloc'].$_POST['photoname']; ?>" class="" alt="your image" heigth="400px" width="400px" />

            <div class="row">
                <div class="col-md-12">
                    <input type="button" value="Save Image Tags" onclick="save_imagetags();">
                </div>
            </div>

       </div>
        <script>
            <?php  $temp = ''; if(isset($_POST['defaulttaglist'])) { $temp = $_POST['defaulttaglist']; } ?>    
            var imgid = [];
            var imglabel = [];
            var imgwidth =[];
            var imgheight = [];
            var imgtop = [];
            var imgleft = [];
            var imgname = <?php echo "'".$_POST['photoname']."'";?>;

            $(document).ready(function(){
            $("#target").tag({
                                  
                                  
                                   defaultTags: [
                                                                       <?php 
                                                                       if($temp != 'undefined')
                                                                       {    
                                                                        $taglists = (explode("||",$temp));    
                                                                        $countindex = 0;
                                                                        foreach ($taglists as $tagvalue) {
                                                                           if($countindex == 0){  echo $tagvalue; }
                                                                           else {echo ","; echo $tagvalue;}
                                                                           $countindex++;
                                                                        }
                                                                       }
                                                                       else{
                                                                           $temp = '';
                                                                       }
                                                                       ?>
                                                    
                                                ],
                                    save: function(width,height,top_pos,left,label,the_tag){
                                    },
                                    remove: function(id){
                                            alert('Do you want to delete this Tag?');
                                    }
				});
	});
        
        $('.jTagDeleteTag').click(function(){
                alert($(this).parent().parent().html());
        });
        
        function save_imagetags()
        {
            var imagetaglist = new Array();
            var count = 0;
            $('.jTagOverlay .jTagTag').each(function(){
                var tagposition = $(this).attr('style');
                if(tagposition != '')
                    {
                        var tagname = $(this).children().find('span').text();
                        var taginfo = tagposition+'::'+tagname;
                        imagetaglist[count] = taginfo;
                        count++;
                    }
                
            });
            if(imagetaglist != '')
                {
                    $('.imagetags').val(imagetaglist);
                    var imageurl = $('#target').parent().find('img').attr('src');
                    //alert("img"+imageurl);
                    var lastslash = imageurl.lastIndexOf('/');
                    var imgname = imageurl.substr(lastslash+1,imageurl.length);
                    //alert(imgname);
                    $.ajax({
                                 type: "POST",
                                 data: {
                                           imagetaglist:imagetaglist,
                                           imgname : imgname
                                       },
                                 url: "setImagetagofPhotogallery.php",
                                 success: function(msg){
                                                        alert("Tags added successfully");
                                                         var actiontext = '';
                                            actiontext = "Tags are added on "+imgname+" successfully.";
                                            $.ajax({
                                                    type: "POST",
                                                    data: {
                                                        actiontext : actiontext
                                                    },
                                                    url: "track_history.php",
                                                    success: function(response){ 
                                                    }   
                                            });
                                                        window.close();
                                                        refreshParent();
                                }
                           });
                    //window.close();
                }
        }
        window.onunload = refreshParent;
            function refreshParent() {
                window.opener.location.reload();
            }
        </script>
    </body>
</html>




   
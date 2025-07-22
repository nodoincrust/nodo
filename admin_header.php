<?php
	//include 'session_config.php';
	$user = '';

	if(isset($_SESSION['username']))
	{
		$user = $_SESSION['username'];
	}
	$tenantId = $_SESSION['usertenant'];
?>
<div class="header_nav">  
    <div class="header-container ">
        <div class="row row-margin">
            <!------ Company logo --------------------------------->
            <div class="col-md-3"><img src="img/LOGO-2.PNG" alt="Logo_image" id="dms_logo" width="230" height="75"></div>
            <div class="col-md-9 txt-padding ">
                <div class="row pull-right">
                    <div class="col-md-12 ">
                        <h4><?php if($user != ''){ echo $user;} else {echo "Default User";}?></h4>  
                        <!--<h4>   Welcome Administrator</h4>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div> 
  

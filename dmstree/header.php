<?php
$user = '';
$tenantid = '';
if(isset($_SESSION['username']))
{
    $user = $_SESSION['username'];
}
if(isset($_SESSION['usertenant']))
{
    $tenantid = $_SESSION['usertenant'];
} 
?>
<!----  header of dashboard ----------------------->
<script>
    function clear_session_var()
    {
        var bouquetname = 1;
         $.ajax({
             type: "GET",
             data:{
                    bouquetname          : bouquetname
                  },
             url: "setsession_variable.php",
             success: function(response){
                 //alert(response);
             }
         });
    }
</script>    
<div class="header_nav">  
    <div class="header-container ">
        <div class="row row-margin">
            <!------ Company logo --------------------------------->
            <div class="col-md-3"><img src="img/LOGO-2.jpg" alt="Logo_image" id="dms_logo" width="230" height="75"></div>
            <div class="col-md-9 txt-padding ">
                <div class="row pull-right">
                    <div class="col-md-12 ">
                          <h4><?php if($user != ''){ echo $user;} else {echo "Default User";}?></h4>
<!--                        <h4>   Welcome Administrator</h4>-->
                                        
                    </div>
                 </div>
                 <div class="row ">
                    <div class="col-md-12 ">
                        <nav class="navbar">
                                    <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    </div>

                                    <!-- Top menus -->
                                    <div class="collapse navbar-collapse" id="navbar-collapse-1">
                                    <ul class="nav navbar-nav navbar-right">
                                        <?php
                                        if ($tenantid != -999) {
                                        ?>
                                            <li><a href="dashboard.php">Dashboard</a></li>
                                            <li><a href="upload.php">Upload Document</a></li>
                                            <li><a href="upload_template.php">Upload Template</a></li>
                                            <li><a href="search.php">SMART Search</a></li>
                                            <li><a href="document_bouquet.php" onclick="clear_session_var();">Create Bouquet</a></li>
                                            <li><a href="document_checkout.php">Document Checkout</a></li>
                                            <li><a href="profile.php">Edit Profile</a></li>
                                            <li><a href="logout.php">Logout</a></li>
                                       <?php
                                        } 
                                        else if ($tenantid == -999) {
                                       ?>
                                            <!--<li><a href="">Create Custom Template</a></li>
                                            <li><a href="">Create Bouquet</a></li>
                                            <li><a href="">Create Packages</a></li>-->
                                       <?php
                                            }
                                        ?>
                                    </ul>                
                                    </div><!-- Top Menu ends -->
                                </nav>
                     </div>
                 </div>
            </div>
        </div>
                                  
    </div>
 </div> 
  

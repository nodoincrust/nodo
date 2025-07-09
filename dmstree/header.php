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
        <div class="row row-margin row_class_img">
                    <!------ Company logo --------------------------------->
            <div class="col-md-3 logo_cls" style="background-color: #32465a;">
                
            </div>
            <div class="col-md-9 txt-padding ">
                <!-- <div class="row pull-right">
                    <div class="col-md-12 ">
                          <h4><?php if($user != ''){ echo $user;} else {echo "Default User";}?></h4>

                                        
                    </div>
                 </div> -->
                 <div class="row row_class">
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
                                   <div class="collapse navbar-collapse navbar_cont_div" id="navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right navbar_ul">
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        if ($tenantid != -999) {
        ?>
        <div class="li_div">
            <li class="list1 <?= ($current_page == 'dashboard.php') ? 'active-nav' : '' ?>">
                <a href="dashboard.php" class="list_of_nav2">
                    <img src="img/Dashboard.svg" alt="">
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="list2 <?= ($current_page == 'upload.php') ? 'active-nav' : '' ?>">
                <a href="upload.php" class="list_of_nav2">
                    <img src="img/Upload Document.svg" alt="">
                    <span>Upload Document</span>
                </a>
            </li>
            <li class="list3 <?= ($current_page == 'upload_template.php') ? 'active-nav' : '' ?>">
                <a href="upload_template.php" class="list_of_nav2">
                    <img src="img/Upload Template.svg" alt="">
                    <span>Upload Template</span>
                </a>
            </li>
            <li class="list4 <?= ($current_page == 'search.php') ? 'active-nav' : '' ?>">
                <a href="search.php" class="list_of_nav2">
                    <img src="img/Search.svg" alt="">
                    <span>SMART Search</span>
                </a>
            </li>
            <li class="list5 <?= ($current_page == 'document_bouquet.php') ? 'active-nav' : '' ?>">
                <a href="document_bouquet.php" onclick="clear_session_var();" class="list_of_nav2">
                    <img src="img/folder-open-02.svg" alt="">
                    <span>Create Bouquet</span>
                </a>
            </li>
            <li class="list6 <?= ($current_page == 'document_checkout.php') ? 'active-nav' : '' ?>">
                <a href="document_checkout.php" class="list_of_nav2">
                    <img src="img/Checkout Document.svg" alt="">
                    <span>Document Checkout</span>
                </a>
            </li>
            <!-- <li class="list7 <?= ($current_page == 'profile.php') ? 'active-nav' : '' ?>">
                <a href="profile.php" class="list_of_nav2">
                    <img src="img/Edit Profile.png" alt="">
                    <span>Edit Profile</span>
                </a>
            </li>
            <li class="list8 <?= ($current_page == 'logout.php') ? 'active-nav' : '' ?>">
                <a href="logout.php" class="list_of_nav2">
                    <img src="img/logout.png" alt="">
                    <span>Logout</span>
                </a>
            </li> -->
        </div>
        <?php
        } else if ($tenantid == -999) {
        ?>
            <!--<li><a href="">Create Custom Template</a></li>-->
        <?php
        }
        ?>
    </ul>                
</div>

                                    <!-- Top Menu ends -->
                                </nav>
                     
                            </div>
             
               
           
                    <div class="col-md-12 row_class">
                        </div>
            </div>
        </div>
                                  
    </div>
 </div> 
  

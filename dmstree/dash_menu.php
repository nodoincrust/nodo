<style>
  /* .header-container{
         width: 1440px;
  height: 873px;
  transform: rotate(0deg);
  opacity: 1;
  background-color: #FFFFFF;
  .left-most-container{}
    } */
  .left-most-container {
    height: 873px;
    width: 280px;
    display: flex;
    flex-direction: column;
    background: #ffffff;
  }

  .left-box-1 {
    width: 248px;
    height: 30px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-left: 16px;
    margin-right: 16px;
    margin-top: 24px;

  }

  .logo-box {
    width: 115.42px;
    height: 30px;
  }

  .toggle-buttton {
    border: none;
    background: #ffffff;
  }

  .left-box-2 {
    width: 248px;
    /* height: 128px; */
    height:120px;
    /* margin-top: 70px; */
    margin-top:30px;
    margin-left: 16px;
    margin-right: 16px;
    flex-direction: column;
    color: #84909A;
    font-size: 14px;
    font-weight: 400;
  }
  .left-box-3{
    width: 248px;
    height: 96px;
    /* margin-top: 214px; */
    margin-top:-26px;
    margin-left: 16px;
    margin-right: 16px;
    flex-direction: column;
    color: #84909A;
    font-size: 14px;
    font-weight: 400;
  }

  .logo-box-2 {
    width: 248px;
    height: 32px;
    padding: 4px 8px;
    display: flex;
    gap: 8px;
    flex-direction: row;
  }

  .logo-box-2.2 {
    /* display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: auto; */

  }

  .left-container {
    /* height: 873px;
    width: 280px;
    display: flex;
    flex-direction: column;
    background: #ffffff;
    margin-top: -8px; */
    /* height: 873px; */
    height: 600px;
    width: 301px;
    display: flex;
    flex-direction: column;
    background: #ffffff;
    margin-top: -18px;
    position: relative;
    bottom: 61px;
        margin-left: -13px;
  }

  .logo-container {
    width: 248px;
    height: 30px;
    display: flex;
    justify-content: space-between;
    flex-direction: row;
    margin-top: 24px;
    margin-left: 16px;
  }

  .logo_img {
    width: 115.42px;
    height: 30px;
    transform: rotate(0deg);
    opacity: 1;
    display: flex;
    gap: 5px;
    /* justify-content: center; */
    align-items: center;
  }

  .logo_img img {
    width: 24.99px;
    height: 25.1px;
    transform: rotate(0deg);
    opacity: 1;
    color: #1B5563;
    display: flex;
  }

  .logo_img .nodo_ai {
    width: 80.63px;
    height: 15.15px;
    transform: rotate(0deg);
    opacity: 1;
    display: flex;
    gap: 7.35px;
  }

  .colse-layout {
    width: 20px;
    height: 20px;
    align-items: center;
  }

  .colse-layout .close-layout-img {
    width: 16px;
    height: 16px;
    position: absolute;
    top: 2px;
    left: 2px;
    transform: rotate(0deg);
    opacity: 1;
    border: 1.5px solid;
    border: none;
    align-items: center;
  }

  .template-container {
       width: 248px;
    /* height: 132px; */
    height:120px;
    /* position: absolute; */
    top: 75px;
    left: 16px;
    transform: rotate(0deg);
    opacity: 1;
    align-items: center;
    margin-top: 29px;
    margin-left: 16px;
  }

  .template-container .template_logo {
    width: 20px;
    height: 20px;
    display: flex;
    gap: 8px;
    margin-left: 7px;
  }

  .template_logo img {
    width: 13.81px;
    height: 17px;
    /* position: absolute; */
    top: 1.5px;
    left: 3.09px;
    transform: rotate(0deg);
    opacity: 1;
    border: 1.5px solid;
    align-items: center;
    /* border: 1.5px solid #84909A; */
    border: none;
    display: flex;
  }

  .template-container a {
    color: #84909A;
  }

  .master-container a {
    color: #84909A;
  }

  .template-container .template_logo span {
    width: 204px;
    height: 24px;
    font-family: 'Inter', sans-serif;
    font-weight: 400;
    font-style: normal;
    font-size: 14px;
    color: #84909A;
  }

  .master-container {
       width: 248px;
    height: 96px;
    /* position: absolute; */
    /* top: 214px; */
    top: 155px;
    left: 16px;
    transform: rotate(0deg);
    opacity: 1;
    /* margin-top: 108px; */
        margin-top: -14px;
    margin-left: 16px;
  }

  .master-container .master-management {
    width: 248px;
    height: 32px;
    transform: rotate(0deg);
    opacity: 1;
    display: flex;
    /* Required for gap to work */
    gap: 8px;
    /* gap: 8px; */
    margin-left: 7px;
    border-radius: 6px;
  }

  .master-management img {
    width: 18.81px;
    height: 21px;
    /* position: absolute; */
    top: 1.5px;
    left: 3.09px;
    transform: rotate(0deg);
    opacity: 1;
    border: 1.5px solid;
    align-items: center;
    /* border: 1.5px solid #84909A; */
    border: none;
    display: flex;
  }

  .master-container .master-management span {
    width: 204px;
    height: 24px;
    font-family: 'Inter', sans-serif;
    font-weight: 400;
    font-style: normal;
    font-size: 14px;
    color: #84909A;
  }

  .template_logo,
  .template-menu li,
  .master-menu li {
    display: flex;
    align-items: center;
    color: #84909A;
    font-size: 14px;
    margin-bottom: 10px;
    gap: 8px;
  }

  .template_logo,
  .template-menu img {

    width: 16.0712px;
    height: 16.0709px;
    /* position: absolute; */
    top: 1.96px;
    left: 1.96px;
    opacity: 1;
    border-width: 1.5px;
    border-style: solid;
    /* Needed for border to show */
    text-align: c#1B5563;
    border: none;
  }

  .profile-container {
    width: 248px;
    height: 32px;
    /* position: absolute; */
    /* top: 785px; */
        margin-top: 200px;
    margin-left: 16px;
    transform: rotate(0deg);
    opacity: 1;
  }

  .profile-container .profile-logo {
    width: 248px;
    height: 32px;
    transform: rotate(0deg);
    opacity: 1;
    display: flex;
    /* Required for gap to work */
    gap: 8px;
    /* gap: 8px; */
    margin-left: 7px;
    border-radius: 6px;
  }

  .profile-logo img {
    width: 18.81px;
    height: 21px;
    /* position: absolute; */
    top: 1.5px;
    left: 3.09px;
    transform: rotate(0deg);
    opacity: 1;
    border: 1.5px solid;
    align-items: center;
    /* border: 1.5px solid #84909A; */
    border: none;
    display: flex;
  }

  .profile-container .profile-logo span {
    width: 204px;
    height: 24px;
    font-family: 'Inter', sans-serif;
    font-weight: 400;
    font-style: normal;
    font-size: 14px;
    color: #84909A;
  }

  .logout-container {
    width: 248px;
    height: 32px;
    /* position: absolute; */
    /* top: 817px; */
    margin-top:4px;
    margin-left: 16px;
    transform: rotate(0deg);
    opacity: 1;
  }

  .logout-container .logout-logo {
    width: 248px;
    height: 32px;
    transform: rotate(0deg);
    opacity: 1;
    display: flex;
    /* Required for gap to work */
    gap: 8px;
    /* gap: 8px; */
    margin-left: 7px;
    border-radius: 6px;
  }

  .logout-container .logout-logo img {
    width: 18.81px;
    height: 21px;
    /* position: absolute; */
    top: 1.5px;
    left: 3.09px;
    transform: rotate(0deg);
    opacity: 1;
    border: 1.5px solid;
    align-items: center;
    /* border: 1.5px solid #84909A; */
    border: none;
    display: flex;
  }

  .logout-container .logout-logo span {
    width: 204px;
    height: 24px;
    font-family: 'Inter', sans-serif;
    /* color: #84909A; */
    color: #F76659;
    font-weight: 600;
    font-style: normal;
    font-size: 14px;

  }

  /* for colapus functioanlity on toggle  */
  /* COLLAPSED SIDEBAR STYLE */
  .left-container.collapsed {
    width: 80px;
    transition: width 0.3s ease;
  }

  /* Hide all text and secondary logos when collapsed */
  .left-container.collapsed span,
  .left-container.collapsed li,
  .left-container.collapsed .nodo_ai,
  .left-container.collapsed .template-menu li,
  .left-container.collapsed .master-management span {
    display: none;
  }

  /* Completely hide the logo-container when collapsed */
  /* Position the toggle button */
  #sidebarToggleBtn {
    /* position: absolute; */
    /* top: 24px;
    left: 280px; */
    margin-top:24px;
    margin-left:280px;
    /* aligned with right edge of sidebar */
    z-index: 10;
    background: none;
    border: none;
    cursor: pointer;
    transition: left 0.3s ease;
  }

  /* When sidebar is collapsed, move button to left */
  .left-container.collapsed+#sidebarToggleBtn {
    left: 80px;
    /* aligned with collapsed sidebar width */
  }


  /* Optional: Center only the icon when collapsed */
  .left-container.collapsed .logo_img,
  .left-container.collapsed .template_logo,
  .left-container.collapsed .template-menu img,
  .left-container.collapsed .master-management img {
    justify-content: center;
  }

  /* Adjust logo container alignment in collapsed */
  .left-container.collapsed .logo-container {
    justify-content: center;
  }

  /* Hide the toggle button if needed */
  .left-container.collapsed .close-layout-img {
    margin-left: auto;
  }
</style>
<!-- <div class="div-padding-right div-padding">
    <div class="row row_col_class">
        <div class="col-md-3"> -->
<!-- <div id="g1"></div> -->
<!-- <div class="header-container"> -->

<div class="left-container" id="sidebar">
        <!-- <div id="g1"></div> -->
     
        <!-- template  -->
      <div class="logo-container" id="toggleSidebar">
        <div class="logo_img">
          <img src="img/nodo.svg" alt="Logo Icon" />
          <img src="img/Nodo AI.svg" class="nodo_ai" alt="Nodo AI" />
        </div>
        <button onclick="toggleSidebar()" style="border:none;background:none;">
            <img src="img/colse-layout-left.svg" class="close-layout-img" alt="Collapse" />
        </button>
        
      </div>

      <div class="template-container">
        <div class="template_logo">
          <img src="img/template-Icon.svg" alt="Template Icon" />
          <span>Templates</span>
        </div>
        <ul class="template-menu">
          <li>
            <img src="img/edit-file.svg" alt="">
            <a href="document_template.php" >Create Custom Template</a>
            <!-- Create a Template -->
        </li>
          <!-- <li>
            <img src="img/multiple-file.svg" alt=""> -->
            <!-- List of Templates -->
        <!-- </li> -->
          <!-- <li>
            <img src="img/bag-template.svg" alt="">
            Buy Template</li> -->
        </ul>
      </div>

      <!-- master-mangment -->
       <div class="master-container">
        <div class="master-management">
            <img src="img/Globe.svg" alt="Template Icon" />
          <span>Master Management</span>
        </div>
        <ul class="template-menu">
          <li>
            <img src="img/data-configuration.svg" alt="">
            <!-- Data Configuration -->
             <a href="data_configuration.php">Data Configuration</a>
        </li>
        <li>
        <img src="" alt="">
        <a href="notice_board.php">Notice Board</a>
        </li>
          <li>
            <img src="img/Edit Profile.svg" alt="">
            <!-- Edit Profile -->
             <a href="profile.php">Edit Profile</a>
        </li>
        </ul>
        </div>

        <!-- bottom section  -->
         <!-- Profile  -->
            <div class="profile-container">
                <div class="profile-logo">
                    <img src="img/user-profile-square.svg" alt="">
                    <span>ranjit</span>
                </div>
            </div>
           
             <div class="logout-container">
                <div class="logout-logo">
                    <img src="img/logout-02.svg" alt="">
                    <a href="logout.php"> <span>Log Out</span></a>
                   
                </div>
            </div>

       </div>


<!-- 
</div> -->

<!-- </div> -->
<!-- </div> -->
<!-- </div>
</div> -->


<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
  }
</script>

<!-- <script>
  function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const toggleIcon = document.querySelector('.close-layout-img');
  sidebar.classList.toggle('collapsed');

  // Toggle icon direction
  if (sidebar.classList.contains('collapsed')) {
    toggleIcon.src = 'img/colse-layout-left.svg'; // replace with your "expand" icon
  } else {
    toggleIcon.src = 'img/colse-layout-left.svg'; // original "collapse" icon
  }
}
</script> -->


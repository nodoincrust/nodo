<!---  Left side menu   ------->
<div class="div-padding-right div-padding">
    <div class="row row_col_class">
        <div class="col-md-3">
            <div class="metro" style="border: none;">
                <!--------  Useage meter  ------------->
            <div id="g1"></div>
            </div>
                   <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
                  <ul class="nav nav-pills nav-stacked div-width">
                <li class="nav-border <?php echo $currentPage == 'document_template.php' ? 'active' : ''; ?>">
                    <a href="document_template.php" class="list_of_nav">Create Custom Template</a>
                </li>
                <li class="nav-border <?php echo $currentPage == 'data_configuration.php' ? 'active' : ''; ?>">
                    <a href="data_configuration.php" class="list_of_nav">Data Configuration</a>
                </li>
                <!-- <li class="nav-border <?php echo $currentPage == 'buy_template.php' ? 'active' : ''; ?>">
                    <a href="buy_template.php" class="list_of_nav">Buy standard template</a>
                </li> -->
                <li class="nav-border <?php echo $currentPage == 'report_problem.php' ? 'active' : ''; ?>">
                <!--     <a href="report_problem.php" class="list_of_nav">Report your problems</a>
                </li> -->
                <li class="nav-border <?php echo $currentPage == 'notice_board.php' ? 'active' : ''; ?>">
                    <a href="notice_board.php" class="list_of_nav">Notice Board</a>
                </li>
                <!-- <li class="nav-border <?php echo $currentPage == 'whats_new_on_dmstree.php' ? 'active' : ''; ?>">
                    <a href="whats_new_on_dmstree.php" class="list_of_nav">What's new on DMStree</a>
                </li> -->
            </ul>
        </div>
    </div>
</div>



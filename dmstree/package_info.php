<?php
	ob_start();
	require('../CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
	$g1 = new Get_mongodb();
	date_default_timezone_set('Asia/Calcutta');
	$result = $g1->get_mongodb-> getPackages();
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sign up Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="css/stylesheet.css"/>

        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script> 
        <script type="text/javascript" src="js/dmstree_js/date.js"></script>

    </head>
    <body>
        <div class="row">
            <div class="col-md-12 form_title "><h3 class="text-muted"><b>Individual Package Information</b></h3></div>
	</div>
        
        <div class ="row">
            <div class=" col-md-6 col-sm-6">
                <?php 
                    foreach ($result as $key)
                    {
                        if($key['PackageType'] === 'Individual' && $key['DurationOrSize'] === 'Duration')
                        {
                ?>
                <table class="table table-bordered">
                    <tr>
                        <td>
                            Package Name
                        </td>
                        <td>
                            <?php echo $key['PackageName'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Package Type
                        </td>
                        <td>
                            <?php echo $key['PackageType'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Duration Or Size
                        </td>
                        <td>
                            <?php echo $key['DurationOrSize'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                          Package Duration In Months
                        </td>
                        <td>
                            <?php echo $key['PackageDurationInMonths'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                          Package Base Rate
                        </td>
                        <td>
                            <?php echo $key['PackageBaseRate'];?>
                        </td>
                    </tr>
                     <tr>
                        <td>
                          Package Tax Percentage
                        </td>
                        <td>
                            <?php echo $key['PackageTaxPercentage'];?>
                        </td>
                    </tr>
                </table>
                 <?php
                        }
                    }
                ?>
            </div>
            <div class ="col-md-6 col-sm-6">  
                <?php 
                    foreach ($result as $key)
                    {
                        if($key['PackageType'] == 'Individual' && $key['DurationOrSize'] == 'Size')
                        {
                    ?>
                 <table class="table table-bordered">
                     <tr>
                        <td>
                            Package Name
                        </td>
                        <td>
                            <?php echo $key['PackageName'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Package Type
                        </td>
                        <td>
                            <?php echo $key['PackageType'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Duration Or Size
                        </td>
                        <td>
                            <?php echo $key['DurationOrSize'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                         Package Size In GB
                        </td>
                        <td>
                            <?php echo $key['PackageSizeInGB'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                          Package Base Rate
                        </td>
                        <td>
                            <?php echo $key['PackageBaseRate'];?>
                        </td>
                    </tr>
                     <tr>
                        <td>
                          Package Tax Percentage
                        </td>
                        <td>
                            <?php echo $key['PackageTaxPercentage'];?>
                        </td>
                    </tr>
                </table>
                <?php
                        }
                    }
                    ?>
            </div>
       </div>
       <div class="row">
            <div class="col-md-12 form_title "><h3 class="text-muted"><b>Corporate Package Information</b></h3></div>
	</div>
        
        <div class ="row">
            <div class=" col-md-6 col-sm-6">
                 <?php 
                    foreach ($result as $key)
                    {
                        if($key['PackageType'] === 'Corporate' && $key['DurationOrSize'] === 'Duration')
                        {
                    ?>
                <table class="table table-bordered">
                    <tr>
                        <td>
                            Package Name
                        </td>
                        <td>
                            <?php echo $key['PackageName'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Package Type
                        </td>
                        <td>
                            <?php echo $key['PackageType'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Duration Or Size
                        </td>
                        <td>
                            <?php echo $key['DurationOrSize'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                          Package Duration In Months
                        </td>
                        <td>
                            <?php echo $key['PackageDurationInMonths'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                          Package Base Rate
                        </td>
                        <td>
                            <?php echo $key['PackageBaseRate'];?>
                        </td>
                    </tr>
                     <tr>
                        <td>
                          Package Tax Percentage
                        </td>
                        <td>
                            <?php echo $key['PackageTaxPercentage'];?>
                        </td>
                    </tr>
                </table>
                 <?php
                        }
                    }
                 ?>
            </div>
            <div class ="col-md-6 col-sm-6">  
                 <?php 
                    foreach ($result as $key)
                    {
                        if($key['PackageType'] == 'Corporate' && $key['DurationOrSize'] == 'Size')
                        {
                    ?>
                 <table class="table table-bordered">
                     <tr>
                        <td>
                            Package Name
                        </td>
                        <td>
                            <?php echo $key['PackageName'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Package Type
                        </td>
                        <td>
                            <?php echo $key['PackageType'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                           Duration Or Size
                        </td>
                        <td>
                            <?php echo $key['DurationOrSize'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                         Package Size In GB
                        </td>
                        <td>
                            <?php echo $key['PackageSizeInGB'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                          Package Base Rate
                        </td>
                        <td>
                            <?php echo $key['PackageBaseRate'];?>
                        </td>
                    </tr>
                     <tr>
                        <td>
                          Package Tax Percentage
                        </td>
                        <td>
                            <?php echo $key['PackageTaxPercentage'];?>
                        </td>
                    </tr>
                </table>
                 <?php
                        }
                    }
                 ?>
            </div>
       </div>
    </body>
</html>
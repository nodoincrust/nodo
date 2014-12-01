<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
<!--	<title>Welcome to CodeIgniter</title>-->
        <title><?php echo $title; ?></title>
</head>
<body>

<div id="container">
	<h1>Mongodb</h1>
        <?php
				var_dump($result);
				//print_r($data);
				$i = 1;
                foreach ($result as $val)
                {
					if($i != 1)
					{
					
                    echo $val->name."    ";
                    echo $val->project."   <br/>";
					}
					$i++;
                }
        ?>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>
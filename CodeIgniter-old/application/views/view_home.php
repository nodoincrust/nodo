<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
<!--	<title>Welcome to CodeIgniter</title>-->
        <title><?php echo $title; ?></title>
</head>
<body>

<div id="container">
	<h1>Add and Substract function!</h1>
        <h2>Add</h2>
        <p><?php echo $val1 .' + '.$val2.' = '.$addTotal; ?></p>
        <h2>Substract</h2>
        <p><?php echo $val1 .' - '.$val2.' = '.$subTotal; ?></p>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>
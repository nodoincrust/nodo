<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <title>Document Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
   
    <link rel="stylesheet" href="jqueryui/themes/base/jquery-ui.css" />
       <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/tests/vendor/jquery.min.js"></script>
	<style>
	#testpre
	{
		white-space: pre-wrap;
	}
	</style>
	</head>
	
	<body>
			<pre>
			This is tesing area.
			Welcome in PHP language.
			</pre>
			<br/>
			
			<pre><textarea id="test"></textarea></pre><br/>
			<label id="testpre" ></label>
			<input type="submit" onclick="display_text();" value="check">
			
			
			<script type="text/javascript">
			function display_text()
			{
				var textareaval = $('#test').val();
				//alert(textareaval);
				$('#testpre').text($('#test').val());
			}
			</script>
	</body>
</html>
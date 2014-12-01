<?php $this->load->helper('url');?>
	<h3>Welcome to Home Page</h3>
	<p>This is codeigniter demo example. Testing is going on.</p>
	
		<form name="test_form" action="pages/viewDeparttbl">
		<input type="submit" value="View Department Info" >
		</form>
		
		 <!--<button onclick="<?php echo base_url()?>index.php/controller/function">Sign Up</button>-->
		<?php
			
			//var_dump($result); onclick="<?php echo site_url('pages/viewDeparttbl'); ​"
		?>

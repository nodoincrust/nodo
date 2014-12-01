  <?php 
 
if($_POST['submit']){
    //getting post variable 
    $email=strip_tags($_POST['email']);
    $pass=strip_tags($_POST['password']);
    $confirm_pass=strip_tags($_POST['confirm_password']);
     
    $error = array();
     
        if(empty($email) or !filter_var($email,FILTER_SANITIZE_EMAIL))
        {
          $error[] = "Email id is empty or invalid";
        }
        if(empty($pass)){
          $error[] = "Please enter password";
        }
        if(empty($confirm_pass)){
          $error[] = "Please enter Confirm password";
        }
        if($pass != $confirm_pass){
           $error[] = "Password and Confirm password are not matching";
        }
         
        if(count($error) ==0){
             
            //database configuration
             $host = 'localhost';  
             $database_name = 'mongo_test';
             $database_user_name = '';  
             $database_password = '';  
            
             //if you have database user name & password then connection may be
             //$connection=new Mongo("mongodb://$database_user_name:$database_password@$dbhost");
              
             //Currently we are connecting to mongodb without authentication
             $connection=new Mongo("mongodb://$dbhost");
              
             //checking the mongo database connection
             if($connection){
              
                 //connecting to database
                 $databse=$connection->$database_name;
                  
                 //connect to specific collection
                 $collection=$databse->reg_users;
                  
                 $query=array('email'=>$email);
                 //checking for existing user
                 $count=$collection->findOne($query);
                 
                 if(!count($count)){
                     //Save the New user
                     $user_data=array('email'=>$email,'password'=>md5($password));             
                     $collection->save($user_data);
                     echo "You are successfully registered.";
                 }else{
                     echo "Email is already existed.Please register with another Email id!.";
                 }
              
             }else{
                 
                  die("Database are not connected");
             }
              
        }else{
            //Displaying the error
            foreach($error as $err){
                echo $err.'<br />';
            }
        }
         
         
     
}
 
?>
 
<form action="registration.php" method="POST">
Email:
<input type="text" id="email" name="email"  />
Password:
<input type="password" id="password" name="password" />  
Confirm Password:
<input type="password" id="c_password" name="confirm_password" /> 
<input  name="submit" id="submit" type="submit" value="Register" />
</form>
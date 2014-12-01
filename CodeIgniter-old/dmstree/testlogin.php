<?php

    //ob_start();
    //session_start();
    
   /* function csrf_startup() {
        csrf_conf('rewrite-js', 'csrf-magic-1.0.4/csrf-magic.js');
    }
    
    include_once 'csrf-magic-1.0.4/csrf-magic.php';*/
    
    

        $username = $_POST['username'];
        $password = $_POST['password'];
    
        // connect to mongodb
           $connection = new MongoClient();
           echo "Connection to database successfully";
           echo "<br/>";
           
       // select a database
          $db = $connection->DMSTree;
          
          $username =strip_tags(trim($username));
          
       // select a collection:
         $collection = $db->UserData;
         
         $searchitem = array("LoginInfo.EmailId"=>$username);
         //$searchitem = array("TenantId"=>1);
         $userData = $collection->find($searchitem);
         
         $result =$collection->count($searchitem); //$searchitem
         echo $result;
         
         var_dump($userData);
//         foreach ($userData as $value) {
//                  echo $value['TenantId']."<br/>";  
//                  echo $value['LoginInfo']."<br/>";
//}
         
        if($result == 0)
            {
                header('Location: login.html');
            }
        $userDataPassword = '';
        //$userPassword = $userData['password'];    
         foreach($userData as $userkey)
         {
            //$userDataId = $userkey['_id'];
            $userDataUsername = $userkey['LoginInfo']['EmailId'];
            $userDataPassword = $userkey['LoginInfo']['Password'];
         }
         //echo $userDataPassword;
        if($password != $userDataPassword )
        {
            header('Location: login.html');
        }
       else
        {
//            session_regenerate_id();
//            $_SESSION['sess_user_id'] =  $userDataId;                   //$userData['_id'];
            $_SESSION['sess_username'] =  $userDataUsername;                              //$userData['username'];
//            session_write_close();
            
            //$_SESSION[] = 
            header('Location: dashboard.php');
        }
?>
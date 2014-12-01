<?php
 if ($_FILES["browse_files"]["error"] > 0)
        {
            $msg= "Please Select the Excelsheets..";
             header('Location:document_template.php?err='.$msg);
         }
         
 else 
     {
         if(isset($_POST['upload_file']))
            {
//                 if (($_FILES["browse_files"]["type"] == "application/vnd.ms-excel") || ($_FILES["browse_files"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") ) 
//                 {
//                     
//                 }
            
             echo "Upload: " . $_FILES["browse_files"]["name"] . "<br>";
             echo "Type: " . $_FILES["browse_files"]["type"] . "<br>";
             echo "Size: " . ($_FILES["browse_files"]["size"] / 1024) . " kB<br>";
             echo "Temp file: " . $_FILES["browse_files"]["tmp_name"]."<br>";

                                    if(isset($_POST['upload_file']))
                                        {
                                            move_uploaded_file($_FILES["browse_files"]["tmp_name"],
                                            "upload/form_images/" . $_FILES["browse_files"]["name"]);
                                            echo "Stored in: " . "upload/form_images/" . $_FILES["browse_files"]["name"];
//                                            header('Location:BOM_Generation.php?file='.$_FILES["browse_files"]["name"]);
                                        }
        
            }

     }
?>
<!DOCTYPE html> 
<html>
<head> 
    <title> 
        How to call PHP function 
        on the click of a Button ? 
    </title> 
</head> 
 <body>
    <h1 style="color:green;"> 
        Chanel creator 
    </h1> 
<form method="POST"><input name="createchan" type="submit" value="Create chanel" /></form>
 <?php
 if(isset($_POST['createchan'])){
    echo 'hello!';
}
?>
 </body>
</html>

 


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SignUp page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/styles.css">
</head>
<body>
    <!-- beginning of Authentication code -->
    <?php
        $nameerr = $emailerr = $passerr= "";
        $email=$username=$pass ="";

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            if(empty($_POST['username'])){
            $nameerr = Test_Input("Name is required") ;
            }else{  
                $username = Test_Input($_POST['username']);
            }

            if(empty($_POST['password'])){
                $passerr == "Name is required";  
            } else{  
                    $pass = Test_Input($_POST['password']);
            }

                if(empty($_POST['email'])){
                    $emailerr == "Name is required";
                }  else{  
                        $email = Test_Input($_POST['email']);
                        if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+
                            (\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$_POST['email'])){
                            $emailerr == "Invalid Email";
                        }
                }
                if($passerr== ""){
                    if($emailerr==""){
                        if($nameerr=="" && $username != ""){
                            $exists = false;
                            $password = str_rot13($username).strlen($pass).$pass;
                            $arrUser = array("username"=>$username, "password"=>$password, "email"=>$email);
                            $sw = file_get_contents('data.json');
                            $temp = json_decode($sw,true);
                            if(!empty($temp)){
                                foreach($temp as $key=>$value){
                                    if($value['email'] ==$email) {
                                        $exists = true;
                                       
                                    }
                                }
                            }
                            // call submit if username doesnt exist 
                            if(!$exists){
                                submit($arrUser);  
                            }else{
                                $emailerr = Test_Input("An account is already linked to Email ") ;
                            }
                            
                }}}
        }
        function submit($arr){
            $file = fopen("data.json","a");
            $sw = file_get_contents('data.json');
            $temp = json_decode($sw,true);
            $temp[]= $arr;
            $json = json_encode($temp);
            file_put_contents('data.json',$json);
            fclose($file);
            header("location:index.php");
        }
        function Test_Input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
       
    ?>
    <!-- end of Authentication code -->
    <div class="container">
        <div class="left-section">
            <div class="inner-left">
                <img src="img/Polygon 2.png" alt="rubbish">
                <p class="welcome">
                welcome back!
                </p>
                <p class="other">
                To keep connected with us please<br>
                login with your personal info.
                </p><br>
                <a href="index.php" class="sign-in">
                    sign in
                </a>
            </div>
        </div>
        <div class="right-section">
            <div class="inner-right">
                <p class="welcome"><span>create account</span></p>
                <a href="#"><img src="img/twitter.png" alt="rubbish"></a>
                <a href="#"><img src="img/google+.png" alt="rubbish"></a>
                <a href="#"><img src="img/facebook.png" alt="rubbish"></a>
                <p>or use your email for registration</p>
                <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="col-md-8">
                        <input type="name" name="username" maxlength="26" placeholder="name" value="<?php echo $username; ?>">
                    </div>
                    <div class="col-md-8">
                        <span class="error"><?php echo $nameerr; ?></span>
                    </div> 
                    <div class="col-md-8">  
                         <input type="email" name="email" required placeholder="Email" value="<?php echo $email; ?>">
                    </div>
                    <div class="col-md-8">
                        <span class="error"><?php echo $emailerr; ?></span>
                    </div>   
                    <input type="password" name="password" required  placeholder="Password"><br><br>
                    <button type="submit" name="submit" value= "submit" class="sign-up">sign up</button><br><br>
                    <span>Already Have An account?</span><a href="index.html">Sign in</a>
                </form>
            </div>

        </div>
    </div>
</body>
</html>

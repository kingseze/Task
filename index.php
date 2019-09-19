<?php //Login.php
$pagename = "Login";
$error = $user = "";
session_start();

if (isset($_SESSION[$user])) {
	$user = $_SESSION[$user];
} else {
	$user = "";
}
function sanitizeString($var)
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return $var;
}

function validEmail($mail) {
    $mail = preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$mail);
    
    return $mail;
}

if (isset($_POST['email'])) {

	$email = sanitizeString($_POST['email']);
	$pass = sanitizeString($_POST['password']);
	if ($email == "" || $pass == "") {
		$error = "Not all fields were entered<br />";
	} else {
		
		if (!validEmail($_POST['email'])) {
			$error = "Invalid Email";
		} else {
            $st = "data.json";
            $file = file_get_contents($st);
            $file_data = json_decode($file,TRUE);
			
			foreach ($file_data as $key => $value) {
				# code...
				if ($file_data[$key]['email'] == $email) {
					# code...
					$username = $file_data[$key]['username'];
					$password = str_rot13($username).strlen($pass).$pass;
					if ($file_data[$key]['password'] == $password) {
						# code...
						$user = $file_data[$key]['username'];
						$_SESSION['user'] = $user;
					}
					$error = "Username or password incorrect, check and try again";
				} else {
					$error = "Username or password incorrect, check and try again";
				}
			}
		
		}

	}
}

if (isset($_SESSION['user'])) { /* Page to output if login was successful */
$pagename = "Welcome $user";
echo <<<_END
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">	
  <title>$pagename</title>
  <LINK href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container">
        <div class="success">
        	<h3>Login Successful!!!!</h3>
        	<p>Welcome $user</p>
        	<a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>

_END;
	
} elseif ($error != "") { /* Page to output if an error occur */

echo <<<_END
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">	
  <title>$pagename</title>
  <LINK href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container">

        <div class="left-section">
            <div class="inner-left">
                <img src="img/Polygon 2.png" alt="rubbish">
                <p class="welcome">
                welcome!
                </p>
                <p class="other">
                You don't have an account?<br>
                </p><br>
                <a href="signup.php" class="sign-in">
                    signup
                </a>
            </div>
        </div>

        <div class="right-section">
            <div class="inner-right">
                <p class="welcome"><span>Login</span></p>
                <p>$error</p>
                <a href="#"><img src="img/twitter.png" alt="rubbish"></a>
                <a href="#"><img src="img/google+.png" alt="rubbish"></a>
                <a href="#"><img src="img/facebook.png" alt="rubbish"></a>
                <p>or login with your email</p>
                <form class="form" action="index.php" method="post">
                    <input type="email" required placeholder="Email" name="email"><br>
                    <input type="password" required  placeholder="Password" name="password"><br><br>
                    <button class="sign-up" type="submit">sign in</button><br><br>
                    <span>Don't have an account?</span><a href="#">Sign in</a>
                </form>
            </div>
        </div>

    </div>
</body>
</html>
	
_END;

} else { /* Page to output if the user is not login */

echo <<<_END
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">	
  <title>$pagename</title>
  <LINK href="css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container">

        <div class="left-section">
            <div class="inner-left">
                <img src="img/Polygon 2.png" alt="rubbish">
                <p class="welcome">
                welcome!
                </p>
                <p class="other">
                You don't have an account?<br>
                </p><br>
                <a href="signup.php" class="sign-in">
                    signup
                </a>
            </div>
        </div>

        <div class="right-section">
            <div class="inner-right">
                <p class="welcome"><span>Login</span></p>
                <a href="#"><img src="img/twitter.png" alt="rubbish"></a>
                <a href="#"><img src="img/google+.png" alt="rubbish"></a>
                <a href="#"><img src="img/facebook.png" alt="rubbish"></a>
                <p>or login with your email</p>
                <form class="form" action="index.php" method="post">
                    <input type="email" required placeholder="Email" name="email"><br>
                    <input type="password" required  placeholder="Password" name="password"><br><br>
                    <button class="sign-up" type="submit">sign in</button><br><br>
                    <span>Don't have an account?</span><a href="#">Sign in</a>
                </form>
            </div>
        </div>

    </div>
</body>
</html>
_END;
}

?>
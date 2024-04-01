
<?php
// Function that loads a layout template file from a given path.
function layouts($layoutName = 'header', $data = [])
{
    if (file_exists(_WEB_PATH_TEMPLATES . '/layout/' . $layoutName . '.php')) {
        require_once _WEB_PATH_TEMPLATES . '/layout/' . $layoutName . '.php';
    };
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// `sendMail` function sends email using PHPMailer library with SMTP settings.
function sendMail($to, $subject, $content)
{


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'rheinmir@gmail.com';                     //SMTP username
        $mail->Password   = 'jmpr zlmh jdfn yokl';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('rheinmir@email.com', 'rhein');
        $mail->addAddress($to);     //Add a recipient


        //Content
        $mail -> CharSet = "UTF-8";
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;

        //PHPMailer SSL certificate verify failed
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            )
        );


        $sendMail = $mail->send();
        if ($sendMail) {
            return $sendMail;
        }

        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Track GET
function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

// Track POST
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

// Sanitizes and filters input from GET and POST requests.
function filter()
{
    $filterArr = [];
    // Securely process GET input by sanitizing all values with `filter_input`.
    if (isGet()) {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    }

    // Checks if the HTTP method is POST, sanitizes POST data if present.
    if (isPost()) {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    }

    return $filterArr;
}

//Track email
// Function that validates if a given string is an email.
function isEmail($email)
{
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}
// Validates if a variable is an integer
function isNumberInt($number)
{
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    return $checkNumber;
}
// Checks if a variable is a float
function isNumberFloat($number)
{
    $checkFloat = filter_var($number, FILTER_VALIDATE_FLOAT);
    return $checkFloat;
}


// Validates a phone number: starts with "0" and has 9 digits
function isPhone($phone)
{
    $checkZero = false;

    // Checks if phone number starts with "0", removes it if found.
    if ($phone[0] == "0") {
        $checkZero = true;
        $phone = substr($phone, 1);
    }


    // Checks if a string is a valid integer greater than or equal to 9 characters.
    $checkNumber = false;
    if (isNumberInt($phone) && (strlen($phone) == 9)) {
        $checkNumber = true;
    }

    // Returns true if both $checkZero and $checkNumber are true.
    if ($checkZero && $checkNumber) {
        return true;
    }

    return false;
}

//Error notice
function getMsg($msg, $type = 'success')
{
    echo '<div class= "alert alert-' . $type . '">';
    echo $msg;
    echo '</div>';
}

// Function redirects to a specified path using HTTP header and exits execution.
function redirect($path = 'index.php')
{
    header("Location: $path");
    exit;
}

// Returns a formatted error message for a given field if exists.
function form_error($fileName, $beforeHtml = '', $afterHtml = '', $errors)
{
    return (!empty($errors[$fileName])) ? $beforeHtml . reset($errors[$fileName]) . $afterHtml : null;
}

function old($fileName, $olddata, $default = null)
{
    return (!empty($olddata[$fileName])) ? $olddata[$fileName] : $default;
}

function isLogin(){
    $checkLogin = false;
    if(getSession('loginToken')){
        $tokenLogin = getSession('loginToken');
    
        $queryToken = getOneRaw("SELECT user_id FROM logintoken WHERE token = '$tokenLogin' ");
    
        if (!empty($queryToken)) {
            $checkLogin = true;
        } else {
            removeSession('loginToken');
        }
        
    };
    
    return $checkLogin;
}
?>





<?php
$salt = "this is matrix";
function safeString($string) 
{
    $string = stripslashes($string);
    $string = strip_tags($string);
    $string = mysql_real_escape_string($string);
    return $string;
}
function safeThreadContent($string){
    $string = stripslashes($string);
    $string = mysql_real_escape_string($string);
    return $string;    
}
function encrypt($text, $salt) 
{
    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)))); 
} 
function decrypt($text, $salt) 
{
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))); 
}
function dbConnect()
{
    $conn = mysql_connect("localhost", "root", "root") or die(mysql_error());
    mysql_select_db("soapbox", $conn) or die(mysql_error()); 
}
function time_elapsed_string($datetime, $full = false) {
    date_default_timezone_set("Asia/Kolkata");
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function is_whole($var){
  return (is_numeric($var)&&(intval($var)==floatval($var)));
}
 function wordFilter($cmt,$wordlist=null,$character="*",$returnCount=false)
 {
     if($wordlist==null)
    {
        $wordlist="nigga|nigger|niggers|sandnigger|sandniggers|sandniggas|sandnigga|honky|honkies|chink|chinks|gook|gooks|wetback|wetbacks|spick|spik|spicks|spiks|bitch|bitches|bitchy|bitching|cunt|cunts|twat|twats|fag|fags|faggot|faggots|faggit|faggits|ass|asses|asshole|assholes|shit|shits|shitty|shity|dick|dicks|pussy|pussies|pussys|fuck|fucks|fucker|fucka|fuckers|fuckas|fucking|fuckin|fucked|motherfucker|motherfuckers|motherfucking|motherfuckin|mothafucker|mothafucka|motherfucka";
    }
    $replace = 'preg_replace("/./","' .$character .'","\\1")';
    $comment = preg_replace("/\b($wordlist)\b/ie", $replace,$cmt,-1,$count);

    if($returnCount!=false)
    {
        return $count;
    }
    elseif($returnCount!=true)
    {
        return $comment;
    }
 }
 
 function getuserid($username) {

    $username = safeString($username);
    dbConnect();
    $result = mysql_query("SELECT srno FROM useraccounts WHERE username='$username'") or die(mysql_error());
    if ($result) {
        $row = mysql_fetch_array($result);
        return $row['srno'];
    }
    return false;
}
$key = "This is Matrix";
function encryptStringArray ($stringArray,$key) {
 $s = strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), serialize($stringArray), MCRYPT_MODE_CBC, md5(md5($key)))), '+/=', '-_,');
 return $s;
}

function decryptStringArray ($stringArray,$key) {
 $s = unserialize(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(strtr($stringArray, '-_,', '+/=')), MCRYPT_MODE_CBC, md5(md5($key))), "\0"));
 return $s;
}
?>

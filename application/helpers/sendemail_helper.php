<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

function sendMail($result,$template){

 $CI = get_instance();
 $html=$CI->load->view($template, $result, true);
  //$CI->load->library('sendgrid');
 require_once(APPPATH."/third_party/sendgrid-php/sendgrid-php.php");

$from = new SendGrid\Email(null, "aarai.hr@gmail.com");
$subject = "Cashew India Email Verification";
$to = new SendGrid\Email(null, $result['email']);
$content = new SendGrid\Content("text/html", $html);
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = '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';
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
}



?>
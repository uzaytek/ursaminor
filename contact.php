<?php

include 'init.php';

$form = new UN_QuickForm('contact'); 
  
$form->addElement('text', 'name', _('Name')); 
$form->addRule('name', _('Name required'), 'required', null, 'client');

$form->addElement('text', 'email', _('E-mail')); 
$form->addRule('email', _('E-mail required'), 'required', null, 'client');
$form->addRule('email', _('Please check email, e-mail is not a valid e-mail address'), 'email', null, 'client');

$form->addElement('text', 'subject', _('Subject')); 
$form->addRule('subject', _('Subject required'), 'required', null, 'client');

$form->addElement('textarea', 'message', _('Message')); 
$form->addRule('message', _('Message required'), 'required', null, 'client');

$form->addElement('submit', 'sb', _('Send'));

if ($form->validate()) {
    $values =& UN_Filter($form->exportValues());
    $body = $values['message']."\n\n".$values['name'];
    $headers  = 'Content-type: text/html; charset=utf-8' . "\n";
    $headers .= 'From: Ursaminor <'.filter_var($values['email'], FILTER_VALIDATE_EMAIL).'>' . "\n";
    $bmail = mail(EM_ADMIN, $values['subject'], $body, $headers);
    if ($bmail) {
      $output = fmtSuccess(_('Your contact request has been successfully submitted'));  
    } else {
      $output = fmtError(_('Something wrong, mail function failed.'));
    }
} else {
  $output = $form->toHtml();
}

theme($output);
?>
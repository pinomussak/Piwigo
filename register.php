<?php
// +-----------------------------------------------------------------------+
// | This file is part of Piwigo.                                          |
// |                                                                       |
// | For copyright and license information, please view the COPYING.txt    |
// | file that was distributed with this source code.                      |
// +-----------------------------------------------------------------------+

//----------------------------------------------------------- include
define('PHPWG_ROOT_PATH','./');
include_once( PHPWG_ROOT_PATH.'include/common.inc.php' );

// +-----------------------------------------------------------------------+
// | Validate Captcha                                                      |
// +-----------------------------------------------------------------------+

if (isset($_POST['submit']))
{
  if (isset($_POST['h-captcha-response']))
  {
    $data = array(
      'secret' => "0xB8088B4fD2E52BE1054608045d8B95bd828433C4",
      'response' => $_POST['h-captcha-response']
    );

    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);

    $responseData = json_decode($response);
    if($responseData->success) 
    {
      $captcha_validated = true;
    }
    else
    {
      $captcha_validated = false;
    }
  }
  else
  {
    $captcha_validated = false;
  }
}

// +-----------------------------------------------------------------------+
// | Check Access and exit when user status is not ok                      |
// +-----------------------------------------------------------------------+
check_status(ACCESS_FREE);

//----------------------------------------------------------- user registration

if (!$conf['allow_user_registration'])
{
  page_forbidden('User registration closed');
}
if (isset($_POST['submit']))
{
  if (isset($captcha_validated) && $captcha_validated)
  {
    trigger_notify('loc_begin_register');
    if (!verify_ephemeral_key(@$_POST['key']))
    {
		  set_status_header(403);
      $page['errors'][] = l10n('Invalid/expired form key');
    }

    if(empty($_POST['password']))
    {
      $page['errors'][] = l10n('Password is missing. Please enter the password.');
    }
    else if(empty($_POST['password_conf']))
    {
      $page['errors'][] = l10n('Password confirmation is missing. Please confirm the chosen password.');
    }
    else if ($_POST['password'] != $_POST['password_conf'])
    {
      $page['errors'][] = l10n('The passwords do not match');
    }

    register_user(
      $_POST['login'],
      $_POST['password'],
      $_POST['mail_address'],
      true,
      $page['errors'],
      isset($_POST['send_password_by_mail'])
      );

    if (count($page['errors']) == 0)
    {
      // email notification
  // CUSTOM BEGIN
      if (isset($_POST['send_password_by_mail']) and email_check_format($_POST['mail_address']))
      {
        $_SESSION['page_infos'][] = l10n('Du hast dich erfolgreich registriert. Du erhältst in Kürze eine E-Mail mit deinen Anmeldedaten. Sobald dich einer der Administratoren händisch freigeschalten hat, kannst du Fotos ansehen und Eigene hochladen.');
      }
      else if (email_check_format($_POST['mail_address']))
      {
        $_SESSION['page_infos'][] = l10n('Du hast dich erfolgreich registriert. Du erhältst in Kürze eine E-Mail mit deinem Benutzernamen. Sobald dich einer der Administratoren händisch freigeschalten hat, kannst du Fotos ansehen und Eigene hochladen.');
      }
  // CUSTOM END
      // log user and redirect
      $user_id = get_userid($_POST['login']);
      log_user($user_id, false);
      redirect(make_index_url());
    }
	  $registration_post_key = get_ephemeral_key(2);
	  
	  $login = !empty($_POST['login'])?htmlspecialchars(stripslashes($_POST['login'])):'';
    $email = !empty($_POST['mail_address'])?htmlspecialchars(stripslashes($_POST['mail_address'])):'';
  }
  else
  {
    $registration_post_key = get_ephemeral_key(2);
    $login = '';
    $email = '';
    $page['errors'][] = "Bitte verifiziere, dass du ein Mensch bist.";
  }
}
else
{
  $registration_post_key = get_ephemeral_key(6);
  $login = '';
  $email = '';
}
//----------------------------------------------------- template initialization
//
// Start output of page
//
$title= l10n('Registration');
$page['body_id'] = 'theRegisterPage';

$template->set_filenames( array('register'=>'register.tpl') );
$template->assign(array(
  'U_HOME' => make_index_url(),
	'F_KEY' => $registration_post_key,
  'F_ACTION' => 'register.php',
  'F_LOGIN' => $login,
  'F_EMAIL' => $email,
  'obligatory_user_mail_address' => $conf['obligatory_user_mail_address'],
  ));

// include menubar
$themeconf = $template->get_template_vars('themeconf');
if (!isset($themeconf['hide_menu_on']) OR !in_array('theRegisterPage', $themeconf['hide_menu_on']))
{
  include( PHPWG_ROOT_PATH.'include/menubar.inc.php');
}

include(PHPWG_ROOT_PATH.'include/page_header.php');
trigger_notify('loc_end_register');
flush_page_messages();
$template->parse('register');
include(PHPWG_ROOT_PATH.'include/page_tail.php');
?>

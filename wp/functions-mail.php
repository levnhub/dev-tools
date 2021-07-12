<?php

// PHPMailer

add_action( 'phpmailer_init', 'send_smtp_email' );
function send_smtp_email( $phpmailer ) {
    if ( ! is_object( $phpmailer ) ) {
        $phpmailer = (object) $phpmailer;
    }

    $phpmailer->Mailer     = 'smtp';
    $phpmailer->Host       = SMTP_HOST;
    $phpmailer->SMTPAuth   = SMTP_AUTH;
    $phpmailer->Port       = SMTP_PORT;
    $phpmailer->Username   = SMTP_USER;
    $phpmailer->Password   = SMTP_PASS;
    $phpmailer->SMTPSecure = SMTP_SECURE;
    $phpmailer->From       = SMTP_FROM;
    $phpmailer->FromName   = SMTP_NAME;
}

function set_html_content_type()
{
    return "text/html";
}

/// Mail all socials notification
// Mail send method
function br_social_oauth_reg_mail($user_id, $user_email, $user_name, $user_pass);
{
    $message = br_social_oauth_reg_mail_register($user_name, $user_email, $user_pass);
    add_filter('wp_mail_content_type', 'set_html_content_type');
    wp_mail($user_email, 'Регистрация аккаунта.', $message);
    remove_filter('wp_mail_content_type', 'set_html_content_type');
}

// Mail template
function br_social_oauth_reg_mail_register($user_name, $user_email, $user_pass)
{
    global $site_region;

    $site_uri = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

    $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <link href="https://fonts.googleapis.com/css?family=Exo+2:400,700,900" rel="stylesheet">
</head>
<body style="padding: 20px 0;width: 100%;height: 100%;background-color: #F7F7F7;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;">
<table class="body-wrap" style="padding: 20px 0;width: 100%;height: 100%;background-color: #F7F7F7;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;">
    <tr>
        <td class="container" style="max-width: 600px;margin: 0 auto;display: block;">
            <!-- Message start -->
            <table style="border-collapse: collapse;font-family: \'Exo 2\', sans-serif;">
                <tr>
                    <td align="left" class="masthead" style="background-color: #FFFFFF;padding: 60px 40px;">
                        <a href="' . $site_uri . '" target="_blank"><img style="max-width: 270px;" src="https://bookmakers24.ru/mail/logo_' . $site_region . '.png" alt="' . $_SERVER['HTTP_HOST'] . '"/></a>
                    </td>
                </tr>
                <tr>
                    <td class="content" style="background-color: #FFFFFF;padding: 0px 40px 40px;font-size: 16px;line-height: 24px;color: #373737;">
                        <h2 style="margin-top: 0;font-size: 24px;font-weight: 900;color: #1C1B31;font-family: \'Exo 2\', sans-serif;">Здравствуйте, ' . $user_name . '</h2>
                        <p>
                            Благодарим Вас за регистрацию на сайте ' . $_SERVER['HTTP_HOST'] . '.<br>
                            Логин от вашего аккаунта:<br>
                            <strong>' . $user_email . '</strong><br>
                            Пароль от вашего аккаунта:<br>
                            <strong>' . $user_pass . '</strong>
                        </p>
                        <p><b>С уважением, команда Bookmakers24</b></p>
                    </td>
                </tr>
                <tr>
                    <td class="banner">
                        <a href="https://www.leon.ru/?wm=3026907&utm_source=bookmakers23&utm_medium=paid_spot&utm_campaign=rating"
                           target="_blank"><img style="max-width: 100%; display: block;" src="' . $site_uri . '/material/20k/600x250_01.jpg" alt="leon акция"/></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="container" style="max-width: 600px;margin: 0 auto;display: block;">
            <!-- Message start -->
            <table style="border-collapse: collapse;font-family: \'Exo 2\', sans-serif;">
                <tr>
                    <td class="content footer" align="center" style="padding: 20px 40px 40px;font-size: 12px;color: #959595;line-height: 16px;">
                        <p>
                            Это письмо сформировано автоматически. Пожалуйста, не отвечайте на него.
                            Вы получили это письмо, потому что являетесь зарегистрированным
                            пользователем сайта <a style="color: #959595;" href="' . $site_uri . '" target="_blank">' . $_SERVER['HTTP_HOST'] . '</a> .
                            Независимый рейтинг букмекеров.
                        </p>';

if ($site_region == 'ru') {
    $message .= '<p style="margin-top: 30px">
                        <a style="display: inline-block; margin: 0 10px;" href="https://vk.com/bookmakers24" class="social vk" target="_blank"><img width="36" height="36" src="https://bookmakers24.ru/mail/vk-color.png" alt="vk"/></a>
                        <a style="display: inline-block; margin: 0 10px;" href="https://twitter.com/bookmakers24" class="social twitter" target="_blank"><img width="36" height="36" src="https://bookmakers24.ru/mail/twitter-color.png" alt="twitter"/></a>
                    </p>';
}

$message .= '</td></tr></table></td></tr></table></body></html>';

    return $message;
}

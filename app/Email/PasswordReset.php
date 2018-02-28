<?php
/**
 * Copyright (C) 2014 - 2017 Threenity CMS - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary  and confidential
 * Written by : nicelife90 <yanicklafontaine@gmail.com>
 * Last edit : 2018
 *
 *
 */

/**
 * Created by PhpStorm.
 * User: ylafontaine
 * Date: 2017-10-18
 * Time: 17:21
 */

require $_SERVER['DOCUMENT_ROOT'] . '/Loader.php';

use ThreenityCMS\Helpers\Request;
use ThreenityCMS\Helpers\Utils;
use ThreenityCMS\Models\Threenity\AccountModel;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Data
 */
$account_id = Request::get('user_id');
$email = AccountModel::getEmail($account_id);
$reset_key = AccountModel::getResetPasswordKey($account_id);
$first_name = AccountModel::getFirstName($account_id);
$last_name = AccountModel::getLastName($account_id);


/**
 * Prepare template parsing using Smarty
 */
$smarty = new Smarty();
$smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'] . '/app/Email/Templates/');


/**
 * Template Data
 */
$smarty->assign('fname', $first_name);
$smarty->assign('rkey', $reset_key);
$smarty->assign('rootpath', Utils::rootPath());


/**
 * Parse this template
 */
$html = $smarty->fetch('password_reset.tpl');


/**
 * Send Mail
 */
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = getenv("SMTP_HOST");
$mail->Port = getenv("SMTP_PORT");
$mail->CharSet = 'UTF-8';
$mail->setFrom('no-reply@' . getenv("EMAIL_DOMAIN"), getenv("EMAIL_NAME"));
$mail->addAddress($email, $first_name . " " . $last_name);
$mail->Subject = 'Réinitialiser le mot de passe / Password Reset';
$mail->msgHTML($html);


if (!$mail->send()) {

    $data = [
        "status" => 400,
        "msg" => $mail->ErrorInfo,
    ];

} else {

    $data = [
        "status" => 200,
        "msg" => "OK",
    ];
}

/**
 * Display result
 */
header('Content-type: application/json');
echo json_encode($data);
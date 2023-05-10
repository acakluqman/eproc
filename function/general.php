<?php

function base_url($path = null)
{
    return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $path;
}

function tanggal($tanggal)
{
    $bulan = array(
        1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    );

    return date('d', strtotime($tanggal)) . ' ' . $bulan[(int)date('m', strtotime($tanggal))] . ' ' . date('Y', strtotime($tanggal));
}

function rupiah($angka)
{
    return "Rp. " . number_format($angka, 2, ',', '.');
}

function token($length = 25)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function escape($html)
{
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function templateEmails($data)
{
    $html = '';

    foreach ($data['message'] as $message) {
        $html .= $message;
    }

    return $html;
}

function templateEmail($data)
{
    $html = '';
    // header
    $html .= '<!doctype html><html><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>' . $data['title'] . '</title>';
    $html .= '<style>.btn-primary a:hover,.btn-primary table td:hover{background-color:#34495e!important}table.body a,table.body ol,table.body p,table.body span,table.body td,table.body ul{font-size:16px!important}table.body .article,table.body .wrapper{padding:10px!important}table.body .content{padding:0!important}table.body .container{padding:0!important;width:100%!important}table.body .main{border-left-width:0!important;border-radius:0!important;border-right-width:0!important}table.body .btn a,table.body .btn table{width:100%!important}table.body .img-responsive{height:auto!important;max-width:100%!important;width:auto!important}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}.apple-link a{color:inherit!important;font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;text-decoration:none!important}#MessageViewBody a{color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit}.btn-primary a:hover{border-color:#34495e!important}</style>';
    $html .= '</head><body style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">';
    $html .= '<span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>';

    $html .= '<div style="padding: 20px;"><center><img src="' . base_url('dist/img/uwks.png') . '" alt="logo" height="70px"></center><div>';

    $html .= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="padding-top: 20px; border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" width="100%" bgcolor="#f6f6f6"> <tr> <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td><td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;" width="580" valign="top"> <div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">';
    $html .= '<table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;" width="100%"> <tr> <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top"> <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%"> <tr> <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">';

    // nama user
    $html .= '<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hai ' . $data['nama'] ?: '' . '...</p>';

    // message
    foreach ($data['message'] as $message) {
        $html .= '<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">' . $message . '</p>';
    }

    // button
    if (isset($data['btn_text']) && isset($data['btn_link'])) {
        $html .= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; width: 100%;" width="100%"> <tbody> <tr> <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;" valign="top"> <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;"> <tbody> <tr>';
        $html .= '<td style="font-family: sans-serif; font-size: 14px; vertical-align: top; border-radius: 5px; text-align: center; background-color: #3498db;" valign="top" align="center" bgcolor="#3498db"> <a href="' . $data['btn_link'] . '" target="_blank" style="border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; background-color: #3498db; border-color: #3498db; color: #ffffff;">' . $data['btn_text'] . '</a> </td>';
        $html .= '</tr></tbody> </table> </td></tr></tbody> </table>';
    }

    // footer
    $html .= '<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Email ini dikirim otomatis, mohon untuk tidak membalas email ini.</p>';
    $html .= '<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Terima kasih</p>';
    $html .= '</td></tr></table>';
    $html .= '</td></tr></table> <div class="footer" style="clear: both; margin-top: 10px; text-align: center; width: 100%;"> <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%"> <tr> <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;" valign="top" align="center"> <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">Universitas Wijaya Kusuma Surabaya</span> <br>Jl. Dukuh Kupang XXV No.54, Dukuh Kupang, Kec. Dukuhpakis, Kota SBY, Jawa Timur 60225 </td></tr>';
    $html .= '<tr><td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;" valign="top" align="center">';
    $html .= '<a href="' . base_url() . '" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">eProcurement Online System</a>. </td></tr></table> </div></div></td><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td></tr></table> </body> </html>';

    return $html;
}

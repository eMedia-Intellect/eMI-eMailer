<?php
/*
Copyright © 2016, 2018 eMedia Intellect.

This file is part of eMI eMailer.

eMI eMailer is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

eMI eMailer is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with eMI eMailer. If not, see <http://www.gnu.org/licenses/>.
*/

require_once '../Library/inclusion.php';
require_once 'Configuration.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formSubmission']))
{
	$Configuration['Subject'] = 'Content-ID';

	// multipart/related

	$testingMimeMultipartBodyPart = new Emi\EMailer\MimeMultipartBodyPart();

	$testingMimeMultipartBodyPart->SetContentType('multipart/related');
	$testingMimeMultipartBodyPart->SetContentDisposition('inline');

	// multipart/related | image/png

	$testingMimeBodyPart1 = new Emi\EMailer\MimeBodyPart();

	$testingMimeBodyPart1->SetContent(file_get_contents('Images/Logo.png'));
	$testingMimeBodyPart1->SetContentType('image/png');
	$testingMimeBodyPart1->SetContentId();

	// multipart/related | text/html

	$testingMimeBodyPart2 = new Emi\EMailer\MimeBodyPart();

	$testingMimeBodyPart2->SetContent('<!DOCTYPE html><html dir="ltr" lang="en-GB"><head><meta charset="UTF-8"/><title>Content-ID</title></head><body><p>There should be an image below this line.</p><img alt="Logo" src="cid:' . $testingMimeBodyPart1->GetContentId() . '"/></body><html>');
	$testingMimeBodyPart2->SetContentType('text/html');

	// Body part nesting

	$testingMimeMultipartBodyPart->AddBodyPart($testingMimeBodyPart1);
	$testingMimeMultipartBodyPart->AddBodyPart($testingMimeBodyPart2);

	// Message

	$testingMimeMessage = new Emi\EMailer\MimeMessage($testingMimeMultipartBodyPart);

	$testingMimeMessage->AddTo($Configuration['ToEmailAddress'], $Configuration['ToName']);
	$testingMimeMessage->SetFrom($Configuration['FromEmailAddress'], $Configuration['FromName']);
	$testingMimeMessage->SetSubject($Configuration['Subject']);

	// SMTP client

	$testingSmtpClient = new Emi\EMailer\SmtpClient();
	
	$testingSmtpClient->SetClientDomain($Configuration['ClientDomain']);
	$testingSmtpClient->SetServerDomain($Configuration['ServerDomain']);

	$testingSmtpClient->Transfer($testingMimeMessage);
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-GB">
	<head>
		<link href="favicon.ico" media="all" rel="icon" type="image/x-icon"/>
		<link href="CSS/common.css" media="all" rel="stylesheet" type="text/css"/>
		<meta charset="UTF-8"/>
		<title>Content-ID</title>
	</head>
	<body>
		<h1>Content-ID</h1>
		<p>This script sends an e-mail containing the following:</p>
		<ul>
			<li>multipart/related
				<ul>
					<li>image/png</li>
					<li>text/html</li>
				</ul>
			</li>
		</ul>
		<form method="post">
			<input name="formSubmission" type="submit" value="Transfer"/>
		</form>
	</body>
</html>
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
	$Configuration['Subject'] = 'MultipartMixed';

	// multipart/mixed

	$testingMimeMultipartBodyPart1 = new Emi\EMailer\MimeMultipartBodyPart();

	$testingMimeMultipartBodyPart1->SetContentType('multipart/mixed');

	// multipart/mixed | multipart/alternative

	$testingMimeMultipartBodyPart2 = new Emi\EMailer\MimeMultipartBodyPart();

	$testingMimeMultipartBodyPart2->SetContentType('multipart/alternative');

	// multipart/mixed | multipart/alternative | text/plain

	$testingMimeBodyPart1 = new Emi\EMailer\MimeBodyPart();

	$testingMimeBodyPart1->SetContent('This is an alternative for the HTML. It is plain text and thus does not contain an image.');
	$testingMimeBodyPart1->SetContentType('text/plain', 'utf-8');

	// multipart/mixed | multipart/alternative | multipart/related

	$testingMimeMultipartBodyPart3 = new Emi\EMailer\MimeMultipartBodyPart();

	$testingMimeMultipartBodyPart3->SetContentType('multipart/related');

	// multipart/mixed | multipart/alternative | multipart/related | image/png

	$testingMimeBodyPart2 = new Emi\EMailer\MimeBodyPart();

	$testingMimeBodyPart2->SetContent(file_get_contents('Images/Logo.png'));
	$testingMimeBodyPart2->SetContentType('image/png');
	$testingMimeBodyPart2->SetContentId();

	// multipart/mixed | multipart/alternative | multipart/related | text/html

	$testingMimeBodyPart3 = new Emi\EMailer\MimeBodyPart();

	$testingMimeBodyPart3->SetContent('<!DOCTYPE html><html dir="ltr" lang="en-GB"><head><meta charset="UTF-8"/><title>Content-ID</title></head><body><p>There should be an image below this line.</p><img alt="Logo" src="cid:' . $testingMimeBodyPart2->GetContentId() . '"/></body><html>');
	$testingMimeBodyPart3->SetContentType('text/html');

	// multipart/mixed | image/x-icon (attachment)

	$testingMimeBodyPart4 = new Emi\EMailer\MimeBodyPart();

	$testingMimeBodyPart4->SetContent(file_get_contents('Images/Logo.ico'));
	$testingMimeBodyPart4->SetContentType('image/x-icon');
	$testingMimeBodyPart4->SetContentDisposition('attachment', 'Logo.ico');

	// Body part nesting

	$testingMimeMultipartBodyPart3->AddBodyPart($testingMimeBodyPart2);
	$testingMimeMultipartBodyPart3->AddBodyPart($testingMimeBodyPart3);

	$testingMimeMultipartBodyPart2->AddBodyPart($testingMimeBodyPart1);
	$testingMimeMultipartBodyPart2->AddBodyPart($testingMimeMultipartBodyPart3);

	$testingMimeMultipartBodyPart1->AddBodyPart($testingMimeMultipartBodyPart2);
	$testingMimeMultipartBodyPart1->AddBodyPart($testingMimeBodyPart4);

	// Message

	$testingMimeMessage = new Emi\EMailer\MimeMessage($testingMimeMultipartBodyPart1);

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
		<title>MultipartMixed</title>
	</head>
	<body>
		<h1>MultipartMixed</h1>
		<p>This script sends an e-mail containing the following:</p>
		<ul>
			<li>multipart/mixed
				<ul>
					<li>multipart/alternative
						<ul>
							<li>text/plain</li>
							<li>multipart/related
								<ul>
									<li>image/png</li>
									<li>text/html</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>image/x-icon (<b>attachment</b>)</li>
				</ul>
			</li>
		</ul>
		<form method="post">
			<input name="formSubmission" type="submit" value="Transfer"/>
		</form>
	</body>
</html>
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

if (basename($_SERVER['SCRIPT_FILENAME']) === 'MimeMessage.php')
{
	exit('This file can not be directly executed but only included.');
}

$TestingMimeMessage = null;

if (count($MimeBodyPartCollection) === 1)
{
	$TestingMimeMessage = new Emi\EMailer\MimeMessage($MimeBodyPartCollection[0]);
}
elseif (count($MimeBodyPartCollection) > 1)
{
	$TestingMimeMessage = new Emi\EMailer\MimeMessage($TestingMimeMultipartBodyPart);
}
else
{
	throw new Exception('No text nor file uploaded.');
}

if (!empty($_POST['formFromEmailAddress']))
{
	if (!empty($_POST['formFromName']))
	{
		$TestingMimeMessage->SetFrom($_POST['formFromEmailAddress'], $_POST['formFromName']);
	}
	else
	{
		$TestingMimeMessage->SetFrom($_POST['formFromEmailAddress']);
	}
}

if (!empty($_POST['formSenderEmailAddress']))
{
	if (!empty($_POST['formSenderName']))
	{
		$TestingMimeMessage->SetSender($_POST['formSenderEmailAddress'], $_POST['formSenderName']);
	}
	else
	{
		$TestingMimeMessage->SetSender($_POST['formSenderEmailAddress']);
	}
}

if (!empty($_POST['formReplyToEmailAddress']))
{
	if (!empty($_POST['formReplyToName']))
	{
		$TestingMimeMessage->SetReplyTo($_POST['formReplyToEmailAddress'], $_POST['formReplyToName']);
	}
	else
	{
		$TestingMimeMessage->SetReplyTo($_POST['formReplyToEmailAddress']);
	}
}

if (!empty($_POST['formToEmailAddress']))
{
	$to = null;

	if (!empty($_POST['formToName']))
	{
		$to = $_POST['formToName'];
	}

	$TestingMimeMessage->AddTo($_POST['formToEmailAddress'], $to);
}

if (!empty($_POST['formCcEmailAddress']))
{
	$cc = null;

	if (!empty($_POST['formCcName']))
	{
		$cc = $_POST['formCcName'];
	}

	$TestingMimeMessage->AddCarbonCopy($_POST['formCcEmailAddress'], $cc);
}

if (!empty($_POST['formBccEmailAddress']))
{
	$bcc = null;

	if (!empty($_POST['formBccName']))
	{
		$bcc = $_POST['formBccName'];
	}

	$TestingMimeMessage->AddBlindCarbonCopy($_POST['formBccEmailAddress'], $bcc);
}

if (!empty($_POST['formMessageID']))
{
	$TestingMimeMessage->SetMessageId($_POST['formMessageID']);
}

if (!empty($_POST['formInReplyTo']))
{
	$TestingMimeMessage->SetInReplyTo($_POST['formInReplyTo']);
}

if (!empty($_POST['formReferences']))
{
	$TestingMimeMessage->SetReferences($_POST['formReferences']);
}

if (!empty($_POST['formSubject']))
{
	$TestingMimeMessage->SetSubject($_POST['formSubject']);
}

if (!empty($_POST['formComments']))
{
	$TestingMimeMessage->SetComments($_POST['formComments']);
}

if (!empty($_POST['formKeywords']))
{
	$TestingMimeMessage->SetKeywords($_POST['formKeywords']);
}

if (!empty($_POST['formReturnPathEmailAddress']))
{
	if (!empty($_POST['formReturnPathName']))
	{
		$TestingMimeMessage->SetReturnPath($_POST['formReturnPathEmailAddress'], $_POST['formReturnPathName']);
	}
	else
	{
		$TestingMimeMessage->SetReturnPath($_POST['formReturnPathEmailAddress']);
	}
}
?>
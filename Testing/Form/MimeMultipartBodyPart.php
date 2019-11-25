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

if (basename($_SERVER['SCRIPT_FILENAME']) === 'MimeMultipartBodyPart.php')
{
	exit('This file can not be directly executed but only included.');
}

$TestingMimeMultipartBodyPart = new Emi\EMailer\MimeMultipartBodyPart();

if (!empty($_POST['formMultipartMimeType']))
{
	if (!empty($_POST['formBoundary']))
	{
		$TestingMimeMultipartBodyPart->SetContentType($_POST['formMultipartMimeType'], null, null, $_POST['formBoundary']);
	}
	else
	{
		$TestingMimeMultipartBodyPart->SetContentType($_POST['formMultipartMimeType']);
	}
}

if (count($MimeBodyPartCollection) > 1)
{
	foreach ($MimeBodyPartCollection as $mimeBodyPart)
	{
		$TestingMimeMultipartBodyPart->AddBodyPart($mimeBodyPart);
	}
}
?>
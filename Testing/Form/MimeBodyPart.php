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

if (basename($_SERVER['SCRIPT_FILENAME']) === 'MimeBodyPart.php')
{
	exit('This file can not be directly executed but only included.');
}

$MimeBodyPartCollection = array();

for ($i = 1; $i <= 5; ++$i)
{
	if (!empty($_POST['formText' . $i]))
	{
		$testingMimeBodyPart = new Emi\EMailer\MimeBodyPart();

		$testingMimeBodyPart->SetContent($_POST['formText' . $i]);

		$mimeType = 'text/plain';

		if (!empty($_POST['formMimeType' . $i]))
		{
			$mimeType = $_POST['formMimeType' . $i];
		}

		$characterEncoding = 'us-ascii';

		if (!empty($_POST['formCharacterEncoding' . $i]))
		{
			$characterEncoding = $_POST['formCharacterEncoding' . $i];
		}

		$testingMimeBodyPart->SetContentType($mimeType, $characterEncoding);

		if (!empty($_POST['formDescription' . $i]))
		{
			$testingMimeBodyPart->SetContentDescription($_POST['formDescription' . $i]);
		}

		if (!empty($_POST['formId' . $i]))
		{
			$testingMimeBodyPart->SetContentId();
		}

		if (!empty($_POST['formDisposition' . $i]))
		{
			if (!empty($_POST['formDisposition' . $i]))
			{
				$testingMimeBodyPart->SetContentDisposition($_POST['formDisposition' . $i]);
			}
		}

		$MimeBodyPartCollection[] = $testingMimeBodyPart;
	}
	elseif ($_FILES['formFile' . $i]['error'] !== 4)
	{
		$testingMimeBodyPart = new Emi\EMailer\MimeBodyPart();

		$testingMimeBodyPart->SetContent(file_get_contents($_FILES['formFile' . $i]['tmp_name']));

		$mimeType = 'text/plain';

		if (!empty($_POST['formMimeType' . $i]))
		{
			$mimeType = $_POST['formMimeType' . $i];
		}

		$characterEncoding = 'us-ascii';

		if (!empty($_POST['formCharacterEncoding' . $i]))
		{
			$characterEncoding = $_POST['formCharacterEncoding' . $i];
		}

		$testingMimeBodyPart->SetContenttype($mimeType, $characterEncoding);

		if (!empty($_POST['formDescription' . $i]))
		{
			$testingMimeBodyPart->SetContentDescription($_POST['formDescription' . $i]);
		}

		if (!empty($_POST['formId' . $i]))
		{
			$testingMimeBodyPart->SetContentId();
		}

		if (!empty($_POST['formDisposition' . $i]))
		{
			if (!empty($_POST['formDisposition' . $i]))
			{
				$fileName = null;

				if (!empty($_POST['formFileName' . $i]))
				{
					$fileName = $_FILES['formFile' . $i]['name'];
				}

				$contentSize = null;

				if (!empty($_POST['formFileName' . $i]))
				{
					$contentSize = filesize($_FILES['formFile' . $i]['tmp_name']);
				}

				$creationDate = null;

				if (!empty($_POST['formCreationDate' . $i]))
				{
					$creationDate = filectime($_FILES['formFile' . $i]['tmp_name']);
				}

				$modificationDate = null;

				if (!empty($_POST['formModificationDate' . $i]))
				{
					$modificationDate = filemtime($_FILES['formFile' . $i]['tmp_name']);
				}

				$readDate = null;

				if (!empty($_POST['formReadDate' . $i]))
				{
					$readDate = fileatime($_FILES['formFile' . $i]['tmp_name']);
				}

				$testingMimeBodyPart->SetContentDisposition($_POST['formDisposition' . $i], $fileName, $contentSize, $creationDate, $modificationDate, $readDate);
			}
		}

		$MimeBodyPartCollection[] = $testingMimeBodyPart;
	}
}
?>
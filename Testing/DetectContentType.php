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

$Output = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formSubmission']))
{
	$testingMimeBodyPart = new Emi\EMailer\MimeBodyPart();

	$testingMimeBodyPart->SetContent(file_get_contents($_FILES['formAttachment']['tmp_name']));

	$testingMimeBodyPart->DetectContentType();

	$Output = $testingMimeBodyPart->GetContentType();
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-GB">
	<head>
		<link href="favicon.ico" media="all" rel="icon" type="image/x-icon"/>
		<link href="CSS/common.css" media="all" rel="stylesheet" type="text/css"/>
		<meta charset="UTF-8"/>
		<title>DetectContentType</title>
	</head>
	<body>
		<h1>DetectContentType</h1>
		<p>This script detects the content type of the selected file:</p>
		<form enctype="multipart/form-data" method="post">
			<input name="formAttachment" type="file"/>
			<br/>
			<br/>
			<input name="formSubmission" type="submit" value="Detect"/>
<?php
if ($Output !== null)
{
echo "\t\t\t<p>Content-Type:</p>\n";

echo "\t\t\t<pre>";

print_r($Output);

echo "\t\t\t</pre>\n";
}
?>
		</form>
	</body>
</html>
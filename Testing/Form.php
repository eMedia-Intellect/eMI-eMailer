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

$Configuration['Subject'] = 'Form';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formSubmission']))
{
	require_once 'Form/MimeBodyPart.php';
	require_once 'Form/MimeMultipartBodyPart.php';
	require_once 'Form/MimeMessage.php';
	require_once 'Form/SmtpClient.php';
}

require_once 'Form/HTML.php';
?>
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

require_once 'Exceptions/CommunicationException.php';
require_once 'Exceptions/ExtensionException.php';
require_once 'Exceptions/MailFromException.php';
require_once 'Exceptions/SocketException.php';
require_once 'MimeBodyPart.php';
require_once 'MimeMultipartBodyPart.php';
require_once 'MimeMessage.php';
require_once 'SmtpClient.php';
?>
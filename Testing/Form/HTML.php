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

if (basename($_SERVER['SCRIPT_FILENAME']) === 'HTML.php')
{
	exit('This file can not be directly executed but only included.');
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-GB">
	<head>
		<link href="favicon.ico" media="all" rel="icon" type="image/x-icon"/>
		<link href="CSS/common.css" media="all" rel="stylesheet" type="text/css"/>
		<meta charset="UTF-8"/>
		<script async="async" charset="UTF-8" src="ECMAScript/common.es" type="application/ecmascript"></script>
		<title>Form</title>
	</head>
	<body>
		<h1>Form</h1>
		<p>This testing form will generate an e-mail message consisting of 1 body part or 1 multipart body part containing up to 5 body parts.</p>
		<form accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" method="post">
			<section>
				<h2>SmtpClient</h2>
				<p>The SmtpClient instance can be left unconfigured if the library is on the same host as the SMTP server.</p>
				<fieldset>
					<legend>Client</legend>
					<div class="group">
						<label for="FormClientDomain">Domain:</label>
						<input id="FormClientDomain" name="formClientDomain" type="text" value="<?php echo $Configuration['ClientDomain']; ?>"/>
					</div>
				</fieldset>
				<fieldset>
					<legend>Server</legend>
					<div class="group groupMargin">
						<label for="FormServerDomain">Domain:</label>
						<input id="FormServerDomain" name="formServerDomain" type="text" value="<?php echo $Configuration['ServerDomain']; ?>"/>
					</div>
					<div class="group">
						<label for="FormServerPort">Port:</label>
						<input id="FormServerPort" name="formServerPort" placeholder="25" type="text"/>
					</div>
				</fieldset>
				<fieldset>
					<legend>Connection timeout</legend>
					<div class="group groupMargin">
						<label for="FormTimeoutSeconds">Seconds:</label>
						<input id="FormTimeoutSeconds" name="formTimeoutSeconds" placeholder="300" type="text"/>
					</div>
					<div class="group">
						<label for="FormTimeoutMicroseconds">Microseconds:</label>
						<input id="FormTimeoutMicroseconds" name="formTimeoutMicroseconds" placeholder="0" type="text"/>
					</div>
				</fieldset>
				<fieldset>
					<legend>Action</legend>
					<div class="group">
						<input name="formSubmission" type="submit" value="Transfer"/>
					</div>
				</fieldset>
			</section>
			<section>
				<h2>MimeMessage</h2>
				<p>The MimeMessage instance takes 1 body part or 1 multipart body part containing up to 5 body parts. Although a MimeMessage can be sent to multiple <i>to</i>, CC and BCC recipients it is not made possible by this form for the sake of simplicity.</p>
				<fieldset>
					<legend>From</legend>
					<div class="group groupMargin">
						<label for="FormFromName">Name:</label>
						<input id="FormFromName" name="formFromName" type="text" value="<?php echo $Configuration['FromName']; ?>"/>
					</div>
					<div class="group">
						<label for="FormFromEmailAddress">E-mail address:</label>
						<input id="FormFromEmailAddress" name="formFromEmailAddress" type="email" value="<?php echo $Configuration['FromEmailAddress']; ?>"/>
					</div>
				</fieldset>
				<fieldset>
					<legend>Sender</legend>
					<div class="group groupMargin">
						<label for="FormSenderName">Name:</label>
						<input id="FormSenderName" name="formSenderName" type="text"/>
					</div>
					<div class="group">
						<label for="FormSenderEmailAddress">E-mail address:</label>
						<input id="FormSenderEmailAddress" name="formSenderEmailAddress" type="email"/>
					</div>
				</fieldset>
				<fieldset>
					<legend>Reply-to</legend>
					<div class="group groupMargin">
						<label for="FormReplyToName">Name:</label>
						<input id="FormReplyToName" name="formReplyToName" type="text"/>
					</div>
					<div class="group">
						<label for="FormReplyToEmailAddress">E-mail address:</label>
						<input id="FormReplyToEmailAddress" name="formReplyToEmailAddress" type="email"/>
					</div>
				</fieldset>
				<fieldset>
					<legend>Recipients</legend>
					<div class="group groupMargin">
						<label for="FormToName">To name:</label>
						<input id="FormToName" name="formToName" type="text" value="<?php echo $Configuration['ToName']; ?>"/>
					</div>
					<div class="group groupMargin">
						<label for="FormToEmailAddress">To e-mail address:</label>
						<input id="FormToEmailAddress" name="formToEmailAddress" type="email" value="<?php echo $Configuration['ToEmailAddress']; ?>"/>
					</div>
					<div class="group groupMargin">
						<label for="FormCcName">CC name:</label>
						<input id="FormCcName" name="formCcName" type="text"/>
					</div>
					<div class="group groupMargin">
						<label for="FormCcEmailAddress">CC e-mail address:</label>
						<input id="FormCcEmailAddress" name="formCcEmailAddress" type="email"/>
					</div>
					<div class="group groupMargin">
						<label for="FormBccName">BCC name:</label>
						<input id="FormBccName" name="formBccName" type="text"/>
					</div>
					<div class="group">
						<label for="FormBccEmailAddress">BCC e-mail address:</label>
						<input id="FormBccEmailAddress" name="formBccEmailAddress" type="email"/>
					</div>
				</fieldset>
				<fieldset>
					<legend>Identifiers</legend>
					<div class="group groupMargin">
						<label for="FormMessageID">Message ID:</label>
						<input id="FormMessageID" name="formMessageID" type="text"/>
					</div>
					<div class="group groupMargin">
						<label for="FormInReplyTo">In reply to:</label>
						<input id="FormInReplyTo" name="formInReplyTo" type="text"/>
					</div>
					<div class="group">
						<label for="FormReferences">References:</label>
						<input id="FormReferences" name="formReferences" type="text"/>
					</div>
				</fieldset>
				<fieldset>
					<legend>Information</legend>
					<div class="group groupMargin">
						<label for="FormSubject">Subject:</label>
						<input id="FormSubject" name="formSubject" type="text" value="<?php echo $Configuration['Subject']; ?>"/>
					</div>
					<div class="group groupMargin">
						<label for="FormComments">Comments:</label>
						<input id="FormComments" name="formComments" type="text"/>
					</div>
					<div class="group">
						<label for="FormKeywords">Keywords:</label>
						<input id="FormKeywords" name="formKeywords" type="text"/>
					</div>
				</fieldset>
				<fieldset>
					<legend>Return path</legend>
					<div class="group groupMargin">
						<label for="FormReturnPathName">Name:</label>
						<input id="FormReturnPathName" name="formReturnPathName" type="text"/>
					</div>
					<div class="group">
						<label for="FormReturnPathEmailAddress">E-mail address:</label>
						<input id="FormReturnPathEmailAddress" name="formReturnPathEmailAddress" type="email"/>
					</div>
				</fieldset>
			</section>
			<section>
				<h2>MimeMultipartBodyPart</h2>
				<p>The multipart body part is only relevant if the e-mail message contains more than 1 body part. Although a multipart body part can directly contain content just like a body part it is not made possible by this form for the sake of simplicity.</p>
				<fieldset>
					<legend>Content-Type</legend>
					<div class="group groupMargin">
						<label for="FormBoundary">Boundary:</label>
						<input id="FormBoundary" name="formBoundary" placeholder="generated" type="text"/>
					</div>
					<div class="group">
						<label for="FormMultipartMimeType">MIME type:</label>
						<select id="FormMultipartMimeType" name="formMultipartMimeType">
							<option value="multipart/alternative">multipart/alternative</option>
							<option selected="selected" value="multipart/mixed">multipart/mixed</option>
							<option value="multipart/mixed">multipart/related</option>
						</select>
					</div>
				</fieldset>
			</section>
			<section>
				<h2>MimeBodyPart</h2>
				<p>A body part can receive its content from either a textarea or a file. Not all headers are meaningful in all cases.</p>
				<section>
					<h3>#1</h3>
					<fieldset class="textWidth">
						<legend>Content</legend>
						<textarea class="textHeight textWidth" id="FormText1" name="formText1" spellcheck="false"></textarea>
						<input id="FormFile1" name="formFile1" type="file"/>
					</fieldset>
					<fieldset>
						<legend>Content-Type</legend>
						<div class="group groupMargin">
							<label for="FormCharacterEncoding1">Character encoding:</label>
							<input id="FormCharacterEncoding1" name="formCharacterEncoding1" placeholder="us-ascii" type="text"/>
						</div>
						<div class="group">
							<label for="FormMimeType1">MIME type:</label>
							<input id="FormMimeType1" name="formMimeType1" placeholder="text/plain" type="text"/>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-Description</legend>
						<div class="group">
							<label for="FormDescription1">Description:</label>
							<input id="FormDescription1" name="formDescription1" type="text"/>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-ID</legend>
						<div class="group">
							<input id="FormId1" name="formId1" type="checkbox">
							<label for="FormId1">Generate</label>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-Disposition</legend>
						<div class="group groupMargin">
							<label for="FormDisposition1">Disposition:</label>
							<select id="FormDisposition1" name="formDisposition1">
								<option value="" selected="selected">(unspecified)</option>
								<option value="attachment">attachment</option>
								<option value="inline">inline</option>
							</select>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormFileName1" name="formFileName1" type="checkbox">
							<label for="FormFileName1">File name</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormContentSize1" name="formContentSize1" type="checkbox">
							<label for="FormContentSize1">Content size</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormCreationDate1" name="formCreationDate1" type="checkbox">
							<label for="FormCreationDate1">Creation date</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormModificationDate1" name="formModificationDate1" type="checkbox">
							<label for="FormModificationDate1">Modification date</label>
						</div>
						<div class="group">
							<input disabled="disabled" id="FormReadDate1" name="formReadDate1" type="checkbox">
							<label for="FormReadDate1">Read date</label>
						</div>
					</fieldset>
				</section>
				<section>
					<h3>#2</h3>
					<fieldset class="textWidth">
						<legend>Content</legend>
						<textarea class="textHeight textWidth" id="FormText2" name="formText2" spellcheck="false"></textarea>
						<input id="FormFile2" name="formFile2" type="file"/>
					</fieldset>
					<fieldset>
						<legend>Content-Type</legend>
						<div class="group groupMargin">
							<label for="FormCharacterEncoding2">Character encoding:</label>
							<input id="FormCharacterEncoding2" name="formCharacterEncoding2" placeholder="us-ascii" type="text"/>
						</div>
						<div class="group">
							<label for="FormMimeType2">MIME type:</label>
							<input id="FormMimeType2" name="formMimeType2" placeholder="text/plain" type="text"/>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-Description</legend>
						<div class="group">
							<label for="FormDescription2">Description:</label>
							<input id="FormDescription2" name="formDescription2" type="text"/>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-ID</legend>
						<div class="group">
							<input id="FormId2" name="formId2" type="checkbox">
							<label for="FormId2">Generate</label>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-Disposition</legend>
						<div class="group groupMargin">
							<label for="FormDisposition2">Disposition:</label>
							<select id="FormDisposition2" name="formDisposition2">
								<option value="" selected="selected">(unspecified)</option>
								<option value="attachment">attachment</option>
								<option value="inline">inline</option>
							</select>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormFileName2" name="formFileName2" type="checkbox">
							<label for="FormFileName2">File name</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormContentSize2" name="formContentSize2" type="checkbox">
							<label for="FormContentSize2">Content size</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormCreationDate2" name="formCreationDate2" type="checkbox">
							<label for="FormCreationDate2">Creation date</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormModificationDate2" name="formModificationDate2" type="checkbox">
							<label for="FormModificationDate2">Modification date</label>
						</div>
						<div class="group">
							<input disabled="disabled" id="FormReadDate2" name="formReadDate2" type="checkbox">
							<label for="FormReadDate2">Read date</label>
						</div>
					</fieldset>
				</section>
				<section>
					<h3>#3</h3>
					<fieldset class="textWidth">
						<legend>Content</legend>
						<textarea class="textHeight textWidth" id="FormText3" name="formText3" spellcheck="false"></textarea>
						<input id="FormFile3" name="formFile3" type="file"/>
					</fieldset>
					<fieldset>
						<legend>Content-Type</legend>
						<div class="group groupMargin">
							<label for="FormCharacterEncoding3">Character encoding:</label>
							<input id="FormCharacterEncoding3" name="formCharacterEncoding3" placeholder="us-ascii" type="text"/>
						</div>
						<div class="group">
							<label for="FormMimeType3">MIME type:</label>
							<input id="FormMimeType3" name="formMimeType3" placeholder="text/plain" type="text"/>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-Description</legend>
						<div class="group">
							<label for="FormDescription3">Description:</label>
							<input id="FormDescription3" name="formDescription3" type="text"/>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-ID</legend>
						<div class="group">
							<input id="FormId3" name="formId3" type="checkbox">
							<label for="FormId3">Generate</label>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-Disposition</legend>
						<div class="group groupMargin">
							<label for="FormDisposition3">Disposition:</label>
							<select id="FormDisposition3" name="formDisposition3">
								<option value="" selected="selected">(unspecified)</option>
								<option value="attachment">attachment</option>
								<option value="inline">inline</option>
							</select>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormFileName3" name="formFileName3" type="checkbox">
							<label for="FormFileName3">File name</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormContentSize3" name="formContentSize3" type="checkbox">
							<label for="FormContentSize3">Content size</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormCreationDate3" name="formCreationDate3" type="checkbox">
							<label for="FormCreationDate3">Creation date</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormModificationDate3" name="formModificationDate3" type="checkbox">
							<label for="FormModificationDate3">Modification date</label>
						</div>
						<div class="group">
							<input disabled="disabled" id="FormReadDate3" name="formReadDate3" type="checkbox">
							<label for="FormReadDate3">Read date</label>
						</div>
					</fieldset>
				</section>
				<section>
					<h3>#4</h3>
					<fieldset class="textWidth">
						<legend>Content</legend>
						<textarea class="textHeight textWidth" id="FormText4" name="formText4" spellcheck="false"></textarea>
						<input id="FormFile4" name="formFile4" type="file"/>
					</fieldset>
					<fieldset>
						<legend>Content-Type</legend>
						<div class="group groupMargin">
							<label for="FormCharacterEncoding4">Character encoding:</label>
							<input id="FormCharacterEncoding4" name="formCharacterEncoding4" placeholder="us-ascii" type="text"/>
						</div>
						<div class="group">
							<label for="FormMimeType4">MIME type:</label>
							<input id="FormMimeType4" name="formMimeType4" placeholder="text/plain" type="text"/>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-Description</legend>
						<div class="group">
							<label for="FormDescription4">Description:</label>
							<input id="FormDescription4" name="formDescription4" type="text"/>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-ID</legend>
						<div class="group">
							<input id="FormId4" name="formId4" type="checkbox">
							<label for="FormId4">Generate</label>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-Disposition</legend>
						<div class="group groupMargin">
							<label for="FormDisposition4">Disposition:</label>
							<select id="FormDisposition4" name="formDisposition4">
								<option value="" selected="selected">(unspecified)</option>
								<option value="attachment">attachment</option>
								<option value="inline">inline</option>
							</select>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormFileName4" name="formFileName4" type="checkbox">
							<label for="FormFileName4">File name</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormContentSize4" name="formContentSize4" type="checkbox">
							<label for="FormContentSize4">Content size</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormCreationDate4" name="formCreationDate4" type="checkbox">
							<label for="FormCreationDate4">Creation date</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormModificationDate4" name="formModificationDate4" type="checkbox">
							<label for="FormModificationDate4">Modification date</label>
						</div>
						<div class="group">
							<input disabled="disabled" id="FormReadDate4" name="formReadDate4" type="checkbox">
							<label for="FormReadDate4">Read date</label>
						</div>
					</fieldset>
				</section>
				<section>
					<h3>#5</h3>
					<fieldset class="textWidth">
						<legend>Content</legend>
						<textarea class="textHeight textWidth" id="FormText5" name="formText5" spellcheck="false"></textarea>
						<input id="FormFile5" name="formFile5" type="file"/>
					</fieldset>
					<fieldset>
						<legend>Content-Type</legend>
						<div class="group groupMargin">
							<label for="FormCharacterEncoding5">Character encoding:</label>
							<input id="FormCharacterEncoding5" name="formCharacterEncoding5" placeholder="us-ascii" type="text"/>
						</div>
						<div class="group">
							<label for="FormMimeType5">MIME type:</label>
							<input id="FormMimeType5" name="formMimeType5" placeholder="text/plain" type="text"/>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-Description</legend>
						<div class="group">
							<label for="FormDescription5">Description:</label>
							<input id="FormDescription5" name="formDescription5" type="text"/>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-ID</legend>
						<div class="group">
							<input id="FormId5" name="formId5" type="checkbox">
							<label for="FormId5">Generate</label>
						</div>
					</fieldset>
					<fieldset>
						<legend>Content-Disposition</legend>
						<div class="group groupMargin">
							<label for="FormDisposition5">Disposition:</label>
							<select id="FormDisposition5" name="formDisposition5">
								<option value="" selected="selected">(unspecified)</option>
								<option value="attachment">attachment</option>
								<option value="inline">inline</option>
							</select>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormFileName5" name="formFileName5" type="checkbox">
							<label for="FormFileName5">File name</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormContentSize5" name="formContentSize5" type="checkbox">
							<label for="FormContentSize5">Content size</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormCreationDate5" name="formCreationDate5" type="checkbox">
							<label for="FormCreationDate5">Creation date</label>
						</div>
						<div class="group groupMargin">
							<input disabled="disabled" id="FormModificationDate5" name="formModificationDate5" type="checkbox">
							<label for="FormModificationDate5">Modification date</label>
						</div>
						<div class="group">
							<input disabled="disabled" id="FormReadDate5" name="formReadDate5" type="checkbox">
							<label for="FormReadDate5">Read date</label>
						</div>
					</fieldset>
				</section>
			</section>
		</form>
	</body>
</html>
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

namespace Emi\EMailer;

class MimeMultipartBodyPart extends MimeBodyPart
{
	/*
	 * Standard headers
	 */

	protected $contentType = array('boundary' => null, 'characterEncoding' => null, 'mimeType' => 'multipart/mixed');

	/*
	 * Other members
	 */

	private $bodyPartCollection = array();

	public function __construct()
	{
		$this->contentType['boundary'] = $this->GenerateIdentifier();
	}

	public function AddBodyPart(MimeBodyPart $bodyPart) : void
	{
		$this->bodyPartCollection[] = $bodyPart;
	}

	public function GetOutput() : string
	{
		$output = 'Mime-Version: 1.0' . "\r\n";

		if ($this->contentDescription !== null)
		{
			$output .= 'Content-Description: ' . $this->contentDescription . "\r\n";
		}

		if ($this->contentDisposition['disposition'] !== null)
		{
			$output .= 'Content-Disposition: ' . $this->contentDisposition['disposition'] . ';';

			if ($this->contentDisposition['creation-date'] !== null)
			{
				$output .= "\r\n\t" . 'creation-date="' . $this->contentDisposition['creation-date'] . '";';
			}

			if ($this->contentDisposition['filename'] !== null)
			{
				$output .= "\r\n\t" . 'filename="' . $this->contentDisposition['filename'] . '";';
			}

			if ($this->contentDisposition['modification-date'] !== null)
			{
				$output .= "\r\n\t" . 'modification-date="' . $this->contentDisposition['modification-date'] . '";';
			}

			if ($this->contentDisposition['read-date'] !== null)
			{
				$output .= "\r\n\t" . 'read-date="' . $this->contentDisposition['read-date'] . '";';
			}

			if ($this->contentDisposition['size'] !== null)
			{
				$output .= "\r\n\t" . 'size="' . $this->contentDisposition['size'] . '";';
			}

			$output .= "\r\n";
		}

		if ($this->contentId !== null)
		{
			$output .= 'Content-ID: ' . $this->contentId . "\r\n";
		}

		if ($this->contentTransferEncoding !== null)
		{
			$output .= 'Content-Transfer-Encoding: ' . $this->contentTransferEncoding . "\r\n";
		}

		if ($this->contentType['mimeType'] !== null)
		{
			$output .= 'Content-Type: ' . $this->contentType['mimeType'] . ';';

			$output .= "\r\n\t" . 'boundary="' . $this->contentType['boundary'] . '";';

			if ($this->contentType['characterEncoding'] !== null)
			{
				$output .= "\r\n\t" . 'charset="' . $this->contentType['characterEncoding'] . '";';
			}

			$output .= "\r\n";
		}

		foreach ($this->headers as $value)
		{
			$output .= $value[0] . ': ' . $value[1] . "\r\n";
		}

		if ($this->content !== null)
		{
			$output .= "\r\n" . chunk_split(base64_encode($this->content));
		}

		$output .= $this->GetChildren() . "\r\n" . '--' . $this->contentType['boundary'] . '--';

		return $output;
	}

	private function GetChildren() : string
	{
		$output = '';

		foreach ($this->bodyPartCollection as $bodyPart)
		{
			$output .= "\r\n" . '--' . $this->contentType['boundary'] . "\r\n";

			$output .= $bodyPart->GetOutput();
		}

		return $output;
	}
}
?>
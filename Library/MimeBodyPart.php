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

class MimeBodyPart
{
	/*
	 * Standard headers
	 */

	protected $contentDescription = null;
	protected $contentDisposition = array('creationDate' => null, 'disposition' => null, 'fileName' => null, 'modificationDate' => null, 'readDate' => null, 'contentSize' => null);
	protected $contentId = null;
	protected $contentTransferEncoding = 'base64';
	protected $contentType = array('characterEncoding' => null, 'mimeType' => 'text/plain');

	/*
	 * Other members
	 */

	protected $content = null;
	protected $headers = array();

	public function AddHeader(string $name, string $value) : void
	{
		$this->headers[] = array($name, $value);
	}

	public function DetectContentType() : void
	{
		if ($this->content !== null && $this->content !== '')
		{
			$temporaryFile = tempnam(sys_get_temp_dir(), 'mime');

			if ($temporaryFile !== false)
			{
				$temporaryFileHandle = fopen($temporaryFile, 'w');

				if ($temporaryFileHandle !== false)
				{
					$hasWritten = fwrite($temporaryFileHandle, $this->content);

					if ($hasWritten !== false)
					{
						$fileInformation = finfo_open(FILEINFO_MIME_TYPE);

						if ($fileInformation !== false)
						{
							$fileEncoding = mb_detect_encoding(file_get_contents($temporaryFile), mb_detect_order(), true);

							$fileCharacterSet = null;

							if ($fileEncoding !== false)
							{
								$fileCharacterSet = mb_strtolower($fileEncoding);
							}

							$this->SetContentType(finfo_file($fileInformation, $temporaryFile), $fileCharacterSet);

							finfo_close($fileInformation);
						}
					}

					fclose($temporaryFileHandle);
				}
			}
		}
	}

	public function GetContent() : string
	{
		return $this->content;
	}

	public function GetContentDescription() : string
	{
		return $this->contentDescription;
	}

	public function GetContentDisposition() : array
	{
		return $this->contentDisposition;
	}

	public function GetContentId() : string
	{
		return $this->contentId;
	}

	public function GetContentTransferEncoding() : string
	{
		return $this->contentTransferEncoding;
	}

	public function GetContentType() : array
	{
		return $this->contentType;
	}

	public function GetHeaders() : array
	{
		return $this->headers;
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

			if ($this->contentDisposition['creationDate'] !== null)
			{
				$output .= "\r\n\t" . 'creation-date="' . $this->contentDisposition['creationDate'] . '";';
			}

			if ($this->contentDisposition['fileName'] !== null)
			{
				$output .= "\r\n\t" . 'filename="' . $this->contentDisposition['fileName'] . '";';
			}

			if ($this->contentDisposition['modificationDate'] !== null)
			{
				$output .= "\r\n\t" . 'modification-date="' . $this->contentDisposition['modificationDate'] . '";';
			}

			if ($this->contentDisposition['readDate'] !== null)
			{
				$output .= "\r\n\t" . 'read-date="' . $this->contentDisposition['readDate'] . '";';
			}

			if ($this->contentDisposition['contentSize'] !== null)
			{
				$output .= "\r\n\t" . 'size="' . $this->contentDisposition['contentSize'] . '";';
			}

			$output .= "\r\n";
		}

		if ($this->contentId !== null)
		{
			$output .= 'Content-ID: ' . '<' . $this->contentId . '>' . "\r\n";
		}

		if ($this->contentTransferEncoding !== null)
		{
			$output .= 'Content-Transfer-Encoding: ' . $this->contentTransferEncoding . "\r\n";
		}

		if ($this->contentType['mimeType'] !== null)
		{
			$output .= 'Content-Type: ' . $this->contentType['mimeType'] . ';';

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
			$output .= "\r\n" . substr(chunk_split(base64_encode($this->content)), 0, -2);
		}

		return $output;
	}

	public function SetContent(string $content) : void
	{
		$this->content = $content;
	}

	public function SetContentDescription(string $description) : void
	{
		$this->contentDescription = $description;
	}

	public function SetContentDisposition(string $disposition, string $fileName = null, int $contentSize = null, int $creationDate = null, int $modificationDate = null, int $readDate = null) : void
	{
		if ($fileName !== null)
		{
			$fileName = basename($fileName);
		}

		if ($creationDate !== null)
		{
			$creationDate = date('D, j M Y H:i:s O', $creationDate);
		}

		if ($modificationDate !== null)
		{
			$modificationDate = date('D, j M Y H:i:s O', $modificationDate);
		}

		if ($readDate !== null)
		{
			$readDate = date('D, j M Y H:i:s O', $readDate);
		}

		$this->contentDisposition['disposition'] = $disposition;
		$this->contentDisposition['fileName'] = $fileName;
		$this->contentDisposition['contentSize'] = $contentSize;
		$this->contentDisposition['creationDate'] = $creationDate;
		$this->contentDisposition['modificationDate'] = $modificationDate;
		$this->contentDisposition['readDate'] = $readDate;
	}

	public function SetContentId() : void
	{
		$this->contentId = $this->GenerateIdentifier();
	}

	public function SetContentType(string $mimeType, string $characterEncoding = null) : void
	{
		$this->contentType['mimeType'] = $mimeType;
		$this->contentType['characterEncoding'] = $characterEncoding;
	}

	protected function GenerateIdentifier() : string
	{
		return date('Ymd') . 'T' . date('His') . '.' . uniqid();
	}
}
?>
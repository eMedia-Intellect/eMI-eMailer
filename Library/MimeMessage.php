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

class MimeMessage
{
	/*
	 * Standard headers
	 */

	private $blindCarbonCopies = array();
	private $carbonCopies = array();
	private $comments = null;
	private $dateAndTime = null;
	private $from = null;
	private $inReplyTo = null;
	private $keywords = null;
	private $messageId = null;
	private $references = null;
	private $replyTo = null;
	private $returnPath = null;
	private $sender = null;
	private $subject = null;
	private $to = array();

	/*
	 * Other members
	 */

	private $bodyPart = null;
	private $headers = array
	(
		array('X-Mailer', 'eMI eMailer'),
		array('X-Mailer-Version', '1.1'),
		array('X-Mailer-URI', 'https://emi.is/')
	);

	public function __construct(MimeBodyPart $bodyPart)
	{
		$this->bodyPart = $bodyPart;
	}

	public function AddBlindCarbonCopy(string $address, string $name = null) : void
	{
		$this->blindCarbonCopies[$address] = $name;
	}

	public function AddCarbonCopy(string $address, string $name = null) : void
	{
		$this->carbonCopies[$address] = $name;
	}

	public function AddHeader(string $name, string $value) : void
	{
		$this->headers[] = array($name, $value);
	}

	public function AddTo(string $address, string $name = null) : void
	{
		$this->to[$address] = $name;
	}

	public function GetBlindCarbonCopies() : array
	{
		return $this->blindCarbonCopies;
	}

	public function GetCarbonCopies() : array
	{
		return $this->carbonCopies;
	}

	public function GetComments() : string
	{
		return $this->comments;
	}

	public function GetContent() : string
	{
		$content = '';

		foreach ($this->headers as $value)
		{
			$content .= $value[0] . ': ' . $value[1] . "\r\n";
		}

		$content .= 'Date: ' . $this->GetDateAndTime() . "\r\n";

		if ($this->from !== null)
		{
			if ($this->from[1] !== null)
			{
				$content .= 'From: ' . $this->from[1] . ' <' . $this->from[0] . '>' . "\r\n";
			}
			else
			{
				$content .= 'From: ' . $this->from[0] . "\r\n";
			}
		}

		if ($this->sender !== null)
		{
			if ($this->sender[1] !== null)
			{
				$content .= 'Sender: ' . $this->sender[1] . ' <' . $this->sender[0] . '>' . "\r\n";
			}
			else
			{
				$content .= 'Sender: ' . $this->sender[0] . "\r\n";
			}
		}

		if ($this->replyTo !== null)
		{
			if ($this->replyTo[1] !== null)
			{
				$content .= 'Reply-To: ' . $this->replyTo[1] . ' <' . $this->replyTo[0] . '>' . "\r\n";
			}
			else
			{
				$content .= 'Reply-To: ' . $this->replyTo[0] . "\r\n";
			}
		}

		$content .= 'To: ';

		foreach ($this->to as $key => $value)
		{
			if ($value !== null)
			{
				$content .= $value . ' <' . $key . '>';
			}
			else
			{
				$content .= $key;
			}

			if ($value !== end($this->to))
			{
				$content .= ', ';
			}
		}

		$content .= "\r\n";

		if (!empty($this->carbonCopies))
		{
			$content .= 'CC: ';
		}

		foreach ($this->carbonCopies as $key => $value)
		{
			if ($value !== null)
			{
				$content .= $value . ' <' . $key . '>';
			}
			else
			{
				$content .= $key;
			}

			if ($value !== end($this->carbonCopies))
			{
				$content .= ', ';
			}
		}

		if (!empty($this->carbonCopies))
		{
			$content .= "\r\n";
		}

		if ($this->GetMessageId() !== null)
		{
			$content .= 'Message-ID: ' . $this->GetMessageId() . "\r\n";
		}

		if ($this->inReplyTo !== null)
		{
			$content .= 'In-Reply-To: ' . $this->inReplyTo . "\r\n";
		}

		if ($this->references !== null)
		{
			$content .= 'References: ' . $this->references . "\r\n";
		}

		if ($this->subject !== null)
		{
			$content .= 'Subject: ' . $this->subject . "\r\n";
		}

		if ($this->comments !== null)
		{
			$content .= 'Comments: ' . $this->comments . "\r\n";
		}

		if ($this->keywords !== null)
		{
			$content .= 'Keywords: ' . $this->keywords . "\r\n";
		}

		if ($this->returnPath !== null)
		{
			if ($this->returnPath[1] !== null)
			{
				$content .= 'Return-Path: ' . $this->returnPath[1] . ' <' . $this->returnPath[0] . '>' . "\r\n";
			}
			else
			{
				$content .= 'Return-Path: ' . $this->returnPath[0] . "\r\n";
			}
		}

		$content .= $this->bodyPart->GetOutput();

		return $content;
	}

	public function GetDateAndTime() : string
	{
		if ($this->dateAndTime === null)
		{
			return date('D, j M Y H:i:s O');
		}
		else
		{
			return $this->dateAndTime;
		}
	}

	public function GetFrom() : array
	{
		return $this->from;
	}

	public function GetHeaders() : array
	{
		return $this->headers;
	}

	public function GetKeywords() : string
	{
		return $this->keywords;
	}

	public function GetInReplyTo() : string
	{
		return $this->inReplyTo;
	}

	public function GetMessageId() : string
	{
		if ($this->messageId === null)
		{
			return '<' . date('Ymd') . 'T' . date('His') . '.' . uniqid() . '@' . gethostname() . '>';
		}
		else
		{
			return $this->messageId;
		}
	}

	public function GetReferences() : string
	{
		return $this->references;
	}

	public function GetReplyTo() : array
	{
		return $this->replyTo;
	}

	public function GetReturnPath() : array
	{
		return $this->returnPath;
	}

	public function GetSender() : array
	{
		return $this->sender;
	}

	public function GetSubject() : string
	{
		return $this->subject;
	}

	public function GetTo() : array
	{
		return $this->to;
	}

	public function SetComments(string $comments) : void
	{
		$this->comments = $comments;
	}

	public function SetDateAndTime(string $dateAndTime) : void
	{
		$this->dateAndTime = $dateAndTime;
	}

	public function SetFrom(string $address, string $name = null) : void
	{
		$this->from = array($address, $name);
	}

	public function SetKeywords(string $keywords) : void
	{
		$this->keywords = $keywords;
	}

	public function SetInReplyTo(string $inReplyTo) : void
	{
		$this->inReplyTo = $inReplyTo;
	}

	public function SetMessageId(string $messageId) : void
	{
		$this->messageId = $messageId;
	}

	public function SetReferences(string $references) : void
	{
		$this->references = $references;
	}

	public function SetReplyTo(string $address, string $name = null) : void
	{
		$this->replyTo = array($address, $name);
	}

	public function SetReturnPath(string $address, string $name = null) : void
	{
		$this->returnPath = array($address, $name);
	}

	public function SetSender(string $address, string $name = null) : void
	{
		$this->sender = array($address, $name);
	}

	public function SetSubject(string $subject) : void
	{
		$this->subject = $subject;
	}
}
?>
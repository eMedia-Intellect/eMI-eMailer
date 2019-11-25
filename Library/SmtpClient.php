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

class SmtpClient
{
	/*
	 * Socket
	 */

	private $connectionTimeout = array('seconds' => 300, 'microseconds' => 0);
	private $serverDomain = null;
	private $serverPort = 25;
	private $socket = null;

	/*
	 * EHLO/HELO greeting
	 */

	private $clientDomain = null;
	private $extensions = array('8BITMIME' => false);

	/*
	 * Rejected addresses
	 */

	private $rejectedBlindCarbonCopies = array();
	private $rejectedToAndCarbonCopies = array();

	public function __construct()
	{
		$this->clientDomain = gethostname();
		$this->serverDomain = gethostname();
	}
	
	public function GetRejectedBlindCarbonCopies() : array
	{
		return $this->rejectedBlindCarbonCopies;
	}

	public function GetRejectedToAndCarbonCopies() : array
	{
		return $this->rejectedToAndCarbonCopies;
	}

	public function SetClientDomain(string $clientDomain) : void
	{
		$this->clientDomain = $clientDomain;
	}

	public function SetConnectionTimeout(int $seconds, int $microseconds = 0) : void
	{
		$this->connectionTimeout['seconds'] = $seconds;
		$this->connectionTimeout['microseconds'] = $microseconds;
	}

	public function SetServerDomain(string $domain) : void
	{
		$this->serverDomain = $domain;
	}

	public function SetServerPort(int $port) : void
	{
		$this->serverPort = $port;
	}

	public function Transfer(MimeMessage $mimeMessage) : void
	{
		$this->rejectedBlindCarbonCopies = array();
		$this->rejectedToAndCarbonCopies = array();

		if (!$this->socket = stream_socket_client('tcp://' . $this->serverDomain . ':' . $this->serverPort, $errorNumber, $errorString))
		{
			throw new SocketException('Socket creation failed.' . " $errorNumber: $errorString");
		}

		stream_set_timeout($this->socket, $this->connectionTimeout['seconds'], $this->connectionTimeout['microseconds']);

		if (!$this->Receive($response, 220))
		{
			throw new CommunicationException('No response from server.');
		}

		$this->PerformGreeting();
		$this->PerformTransferToAndCarbonCopy($mimeMessage);
		$this->PerformTransferBlindCarbonCopy($mimeMessage);

		$this->Send('QUIT' . "\r\n");

		if (!$this->Receive($response, 221))
		{
			throw new CommunicationException('Server did not accept termination.');
		}

		fclose($this->socket);
	}

	private function PerformGreeting() : void
	{
		$this->Send("EHLO $this->clientDomain" . "\r\n");

		if ($this->Receive($response, 250))
		{
			$this->ProcessEhlo($response);
		}
		else
		{
			throw new CommunicationException('Server did not greet client.');
		}

		if (!$this->extensions['8BITMIME'])
		{
			throw new ExtensionException('Server does not support 8BITMIME.');
		}
	}

	private function PerformTransferBlindCarbonCopy(MimeMessage $mimeMessage) : void
	{
		if (count($mimeMessage->GetBlindCarbonCopies()) !== 0)
		{
			$this->Send("MAIL FROM: <{$mimeMessage->GetFrom()[0]}>" . "\r\n");

			if (!$this->Receive($response, 250))
			{
				throw new MailFromException('Mail from address rejected.');
			}

			foreach ($mimeMessage->GetBlindCarbonCopies() as $address => $name)
			{
				$this->Send("RCPT TO: <$address>" . "\r\n");

				if (!$this->Receive($response, 250))
				{
					$this->rejectedBlindCarbonCopies[$address] = $name;
				}
			}

			if (count($mimeMessage->GetBlindCarbonCopies()) !== count($this->rejectedBlindCarbonCopies))
			{
				$this->Send('DATA' . "\r\n");

				if (!$this->Receive($response, 354))
				{
					throw new CommunicationException('Server could not receive data.');
				}

				$this->Send($mimeMessage->GetContent());

				$this->Send("\r\n" . '.' . "\r\n");

				if (!$this->Receive($response, 250))
				{
					throw new CommunicationException('Server rejected data.');
				}
			}
		}
	}

	private function PerformTransferToAndCarbonCopy(MimeMessage $mimeMessage) : void
	{
		if (count($mimeMessage->GetTo()) + count($mimeMessage->GetCarbonCopies()) !== 0)
		{
			$this->Send("MAIL FROM: <{$mimeMessage->GetFrom()[0]}>" . "\r\n");

			if (!$this->Receive($response, 250))
			{
				throw new MailFromException('Mail from address rejected.');
			}

			foreach ($mimeMessage->GetTo() as $address => $name)
			{
				$this->Send("RCPT TO: <$address>" . "\r\n");

				if (!$this->Receive($response, 250))
				{
					$this->rejectedToAndCarbonCopies[$address] = $name;
				}
			}

			foreach ($mimeMessage->GetCarbonCopies() as $address => $name)
			{
				$this->Send("RCPT TO: <$address>" . "\r\n");

				if (!$this->Receive($response, 250))
				{
					$this->rejectedToAndCarbonCopies[$address] = $name;
				}
			}

			if (count($mimeMessage->GetTo()) + count($mimeMessage->GetCarbonCopies()) !== count($this->rejectedToAndCarbonCopies))
			{
				$this->Send('DATA' . "\r\n");

				if (!$this->Receive($response, 354))
				{
					throw new CommunicationException('Server could not receive data.');
				}

				$this->Send($mimeMessage->GetContent());

				$this->Send("\r\n" . '.' . "\r\n");

				if (!$this->Receive($response, 250))
				{
					throw new CommunicationException('Server rejected data.');
				}
			}
		}
	}

	private function ProcessEhlo(string $response) : void
	{
		foreach ($this->extensions as $key => $value)
		{
			if (strpos($response, $key) !== false)
			{
				$this->extensions[$key] = true;
			}
		}
	}

	private function Receive(string &$response = null, int $code) : bool
	{
		$response = '';

		while (!feof($this->socket))
		{
			$line = fgets($this->socket, 512);

			$response .= $line;

			if ((isset($line[3])))
			{
				if ($line[3] === ' ')
				{
					break;
				}
			}

			if (stream_get_meta_data($this->socket)['timed_out'])
			{
				break;
			}
		}

		if (in_array(substr($line, 0, 3), (array)$code))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	private function Send(string $command) : void
	{
		$bytesWritten = fwrite($this->socket, $command);

		if (!$bytesWritten)
		{
			throw new SocketException('Could not write to socket.');
		}
	}
}
?>
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

"use strict";

window.onload = function()
{
	for (let i = 1; i <= 5; ++i)
	{
		let formText = window.document.getElementById("FormText" + i);

		formText.onkeyup = function()
		{
			window.document.getElementById("FormFile" + i).value = "";
		};

		let formFile = window.document.getElementById("FormFile" + i);

		formFile.onchange = function()
		{
			if (formFile.value.length > 0)
			{
				window.document.getElementById("FormText" + i).value = "";
			}
		};

		let formDisposition = window.document.getElementById("FormDisposition" + i);

		formDisposition.onchange = function()
		{
			if (formDisposition.selectedIndex === 0)
			{
				window.document.getElementById("FormFileName" + i).checked = false;
				window.document.getElementById("FormContentSize" + i).checked = false;
				window.document.getElementById("FormCreationDate" + i).checked = false;
				window.document.getElementById("FormModificationDate" + i).checked = false;
				window.document.getElementById("FormReadDate" + i).checked = false;

				window.document.getElementById("FormFileName" + i).disabled = true;
				window.document.getElementById("FormContentSize" + i).disabled = true;
				window.document.getElementById("FormCreationDate" + i).disabled = true;
				window.document.getElementById("FormModificationDate" + i).disabled = true;
				window.document.getElementById("FormReadDate" + i).disabled = true;
			}
			else
			{
				window.document.getElementById("FormFileName" + i).checked = true;
				window.document.getElementById("FormContentSize" + i).checked = true;
				window.document.getElementById("FormCreationDate" + i).checked = true;
				window.document.getElementById("FormModificationDate" + i).checked = true;
				window.document.getElementById("FormReadDate" + i).checked = true;

				window.document.getElementById("FormFileName" + i).disabled = false;
				window.document.getElementById("FormContentSize" + i).disabled = false;
				window.document.getElementById("FormCreationDate" + i).disabled = false;
				window.document.getElementById("FormModificationDate" + i).disabled = false;
				window.document.getElementById("FormReadDate" + i).disabled = false;
			}
		};
	}
}
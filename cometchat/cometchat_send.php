<?php

/*

Comet Chat
Copyright (c) 2009 Inscripts

Version: 1.1

Comet Chat ('the Software') is a copyrighted work of authorship. Inscripts 
retains ownership of the Software and any copies of it, regardless of the 
form in which the copies may exist. This license is not a sale of the 
original Software or any copies.

By installing and using Comet Chat on your server, you agree to the following
terms and conditions. Such agreement is either on your own behalf or on behalf
of any corporate entity which employs you or which you represent
('Corporate Licensee'). In this Agreement, 'you' includes both the reader
and any Corporate Licensee and 'Inscripts' means Inscripts (I) Private Limited:

Comet Chat license grants you the right to run one instance (a single installation)
of the Software on one web server and one web site for each license purchased.
Each license may power one instance of the Software on one domain. For each 
installed instance of the Software, a separate license is required. 
The Software is licensed only to you. You may not rent, lease, sublicense, sell,
assign, pledge, transfer or otherwise dispose of the Software in any form, on
a temporary or permanent basis, without the prior written consent of Inscripts. 

The license is effective until terminated. You may terminate it
at any time by uninstalling the Software and destroying any copies in any form. 

The Software source code may be altered (at your risk) 

All Software copyright notices within the scripts must remain unchanged (and visible). 

The Software may not be used for anything that would represent or is associated
with an Intellectual Property violation, including, but not limited to, 
engaging in any activity that infringes or misappropriates the intellectual property
rights of others, including copyrights, trademarks, service marks, trade secrets, 
software piracy, and patents held by individuals, corporations, or other entities. 

If any of the terms of this Agreement are violated, Inscripts reserves the right 
to revoke the Software license at any time. 

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

include_once "cometchat_init.php";

if (!empty($_POST['status'])) {
	$message = $_POST['status'];
	$sql = ("insert into cometchat_status (userid,status) values ($userid,'" . mysqli_real_escape_string($dbh, sanitize($message)) . "') on duplicate key update status = '" . mysqli_real_escape_string($dbh, sanitize($message)) . "'");
	$query = mysqli_query($GLOBALS['link'], $sql);

	if ($message == 'offline') {
		$_SESSION['cometchat_sessionvars']['buddylist'] = 0;
	}

	echo "1";
	exit(0);
}

if (!empty($_POST['statusmessage'])) {
	$message = $_POST['statusmessage'];
	$sql = ("insert into cometchat_status (userid,message) values ($userid,'" . mysqli_real_escape_string($dbh, encode(sanitize($message))) . "') on duplicate key update message = '" . mysqli_real_escape_string($dbh, encode(sanitize($message))) . "'");
	$query = mysqli_query($GLOBALS['link'], $sql);

	echo "1";
	exit(0);
}

if (!empty($_POST['to']) && !empty($_POST['message'])) {
	$to = $_POST['to'];
	$message = $_POST['message'];

	if ($userid != '') {
		$sql = ("insert into cometchat (cometchat.from,cometchat.to,cometchat.message,cometchat.sent,cometchat.read) values ('" . mysqli_real_escape_string($dbh, $userid) . "', '" . mysqli_real_escape_string($dbh, $to) . "','" . mysqli_real_escape_string($dbh, encode(sanitize($message))) . "',UNIX_TIMESTAMP(NOW()),0)");
		$query = mysqli_query($GLOBALS['link'], $sql);

		if (empty($_SESSION['cometchat_user_' . $to])) {
			$_SESSION['cometchat_user_' . $to] = array();
		}

		$_SESSION['cometchat_user_' . $to][] = array("id" => mysqli_insert_id($dbh), "from" => $to, "message" => sanitize($message), "self" => 1, "old" => 1);

		echo mysqli_insert_id($dbh);
		exit(0);
	}
}

function encode($text)
{
	$text = iconv('utf-8', CHARSET, $text);
	return $text;
}


function sanitize($text)
{
	global $smileys;
	global $bannedWords;
	$text = htmlspecialchars($text, ENT_NOQUOTES);
	$text = str_replace("\n\r", "\n", $text);
	$text = str_replace("\r\n", "\n", $text);
	$text = str_replace("\n", " <br> ", $text);

	for ($i = 0; $i < count($bannedWords); $i++) {
		$text = str_ireplace($bannedWords[$i], $bannedWords[$i][0] . str_repeat("*", strlen($bannedWords[$i]) - 1), $text);
	}

	$search  = "/([\S]+\.(MUSEUM|TRAVEL|AERO|ARPA|ASIA|COOP|INFO|NAME|BIZ|CAT|COM|INT|JOBS|NET|ORG|PRO|TEL|AC|AD|AE|AF|AG|AI|AL|AM|AN|AO|AQ|AR|AS|AT|AU|au|AW|AX|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BR|BS|BT|BV|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|CR|CU|CV|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EDU|EE|EG|EH|ER|ES|ET|EU|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GF|GG|GH|GI|GL|GM|GN|GOV|GP|GQ|GR|GS|GT|GU|GW|GY|HK|HM|HN|HR|HT|HU|ID|IE|IL|IM|IN|IO|IQ|IR|IS|IT|JE|JM|JO|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MF|MG|MH|MIL|MK|ML|MM|MN|MO|MOBI|MP|MQ|MR|MS|MT|MU|MV|MW|MX|MY|MZ|NA|NC|NE|NF|NG|NI|NL|NO|NP|NR|NU|NZ|OM|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PS|PT|PW|PY|QA|RE|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SJ|SK|SL|SM|SN|SO|SR|ST|SU|SV|SY|SZ|TC|TD|TF|TG|TH|TJ|TK|TL|TM|TN|TO|R|H|TP|TR|TT|TV|TW|TZ|UA|UG|UK|UM|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|YE|YT|YU|ZA|ZM|ZW)([\S]*))/i";

	if (DISABLE_LINKING != 1) {
		$text = preg_replace_callback($search, "autolink", $text);
	}

	if (DISABLE_SMILEYS != 1) {
		foreach ($smileys as $pattern => $result) {
			$text = str_ireplace($pattern, '<img class="cometchat_smiley" src="' . BASE_URL . 'images/smileys/' . $result . '.png" alt="' . $pattern . '">', $text);
		}
	}

	return $text;
}

function autolink($matches)
{
	$GLOBALS['link'] = $matches[0];

	if (preg_match("/\@/", $matches[0])) {
		$text = "<a href=\"mailto: {$GLOBALS['link']}\">{$matches[0]}</a>";
	} else {
		if (!preg_match("/http:\/\//", $matches[0])) {
			$GLOBALS['link'] = "http://" . $matches[0];
		}
		$text = "<a href=\"{$GLOBALS['link']}\" target=\"_blank\">{$matches[0]}</a>";
	}


	return $text;
}

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

$response = array();
$messages = array();

if ($userid != 0) {
	if (!empty($_POST['chatbox'])) {
		if (!empty($_SESSION['cometchat_user_' . $_POST['chatbox']])) {
			$messages = $_SESSION['cometchat_user_' . $_POST['chatbox']];
		}
	} else {
		if (!empty($_POST['buddylist']) && $_POST['buddylist'] == 1) {
			getBuddyList();
		}
		if (!empty($_POST['initialize']) && $_POST['initialize'] == 1) {
			getStatus();
			if (!empty($_SESSION['cometchat_sessionvars'])) {
				$response['initialize'] = $_SESSION['cometchat_sessionvars'];

				if (!empty($_SESSION['cometchat_sessionvars']['openChatboxId']) && !empty($_SESSION['cometchat_user_' . $_SESSION['cometchat_sessionvars']['openChatboxId']])) {
					$messages = array_merge($messages, $_SESSION['cometchat_user_' . $_SESSION['cometchat_sessionvars']['openChatboxId']]);
				}
			}
		} else {

			if (empty($_SESSION['cometchat_sessionvars'])) {
				$_SESSION['cometchat_sessionvars'] = array();
			}

			if (!empty($_POST['sessionvars'])) {
				ksort($_POST['sessionvars']);
			} else {
				$_POST['sessionvars'] = '';
			}

			if (!empty($_POST['updatesession']) && $_POST['updatesession'] == 1) {
				$_SESSION['cometchat_sessionvars'] = $_POST['sessionvars'];
			}

			if ($_SESSION['cometchat_sessionvars'] != $_POST['sessionvars']) {
				$response['updatesession'] = $_SESSION['cometchat_sessionvars'];
			}
		}

		getLastTimestamp();
		fetchMessages();
	}

	// Please update this line as per your database. We assume that a table "user" contains a field "lastactivity" which records the unix timestamp of the user
	// This is used later to find out if the user is online or offlineupdate _tusu set lastactivity =UNIX_TIMESTAMP(NOW()) where IDusu =1

	$sql = ("update " . TABLE_PREFIX . "_tusu set lastactivity =UNIX_TIMESTAMP(NOW()) where IDusu = " . mysqli_real_escape_string($dbh, $userid));
	$query = mysqli_query($dbh, $sql);
} else {
	$response['loggedout'] = '1';
	session_destroy();
}

function getStatus()
{
	global $response;
	global $userid, $dbh;

	$sql = ("select cometchat_status.message, cometchat_status.status from cometchat_status where userid = " . mysqli_real_escape_string($dbh, $userid));

	$query = mysqli_query($dbh, $sql);

	$chat = mysqli_fetch_array($query);

	if (empty($chat['status'])) {
		$chat['status'] = 'available';
	} else {
		if ($chat['status'] == 'offline') {
			$_SESSION['cometchat_sessionvars']['buddylist'] = 0;
		}
	}

	if (empty($chat['message'])) {
		$chat['message'] = "I'm " . ucfirst($chat['status']);
	}

	$chat['message'] = iconv(CHARSET, 'utf-8', $chat['message']);

	$status = array('message' => $chat['message'], 'status' => $chat['status']);
	$response['userstatus'] = $status;
}

function getLastTimestamp()
{
	global $dbh;
	if (empty($_POST['timestamp'])) {
		$_POST['timestamp'] = 0;
	}

	if ($_POST['timestamp'] == 0) {
		foreach ($_SESSION as $key => $value) {
			if (substr($key, 0, 15) == "cometchat_user_") {
				$temp = end($_SESSION[$key]);
				if ($_POST['timestamp'] < $temp['id']) {
					$_POST['timestamp'] = $temp['id'];
				}
			}
		}

		if ($_POST['timestamp'] == 0) {
			$sql = ("select id from cometchat order by id desc limit 1");
			$query = mysqli_query($dbh, $sql);
			$chat = mysqli_fetch_array($query);

			$_POST['timestamp'] = $chat['id'] ?? 0;
		}
	}
}


function getBuddyList()
{
	global $response;
	global $userid;
	global $dbh;

	$time = time();
	$buddyList = array();

	if ((empty($_SESSION['cometchat_buddytime'])) || ($_POST['initialize'] == 1) || (!empty($_SESSION['cometchat_buddytime']) && ($time - $_SESSION['cometchat_buddytime'] > REFRESH_BUDDYLIST))) {

		// Please update the logic below to interact with your buddy list and return the friends of the logged in user along with status information (which is handled by CometChat)
		// We assume here that you have a table called "user" with fields "userid", "username", "lastactivity"
		// And a table called "userlist" with field "userid", "relationid", "friend"
		// For example
		//
		// User table
		// -------------------------------------
		// userid	username	lastactivity
		// -------------------------------------
		// 1		abc			1244912985
		// 2		def			1244912983
		//
		// Userlist table
		// -------------------------------------
		// userid	relationid	friend
		// -------------------------------------
		// 1		2			yes
		// 2		1			yes
		//

		$sql = ("select " . TABLE_PREFIX . "_tusu.IDusu, " . TABLE_PREFIX . "_tusu.Nombre, " . TABLE_PREFIX . "_tusu.lastactivity, cometchat_status.message, cometchat_status.status from " . TABLE_PREFIX . "userlist join " . TABLE_PREFIX . "_tusu on  " . TABLE_PREFIX . "userlist.relationid = " . TABLE_PREFIX . "_tusu.IDusu left join cometchat_status on " . TABLE_PREFIX . "_tusu.IDusu = cometchat_status.userid where " . TABLE_PREFIX . "userlist.friend = 'yes' and " . TABLE_PREFIX . "userlist.userid = '" . mysqli_real_escape_string($dbh, $userid) . "' order by Nombre asc");

		$query = mysqli_query($dbh, $sql);


		while ($chat = mysqli_fetch_array($query)) {

			if ((($time - $chat['lastactivity']) < 30) && $chat['status'] != 'invisible' && $chat['status'] != 'offline') {
				if ($chat['status'] != 'busy') {
					$chat['status'] = 'available';
				}
			} else {
				$chat['status'] = 'offline';
			}

			if ($chat['message'] == null) {
				$chat['message'] = "I'm " . ucfirst($chat['status']);
			}

			$chat['Nombre'] = iconv(CHARSET, 'utf-8', $chat['Nombre']);
			$chat['message'] = iconv(CHARSET, 'utf-8', $chat['message']);

			$buddyList[] = array('id' => $chat['IDusu'], 'name' => $chat['Nombre'], 'status' => $chat['status'], 'message' => $chat['message'], 'time' => $chat['lastactivity']);
		}

		$_SESSION['cometchat_buddytime'] = $time;

		$response['buddylist'] = $buddyList;
	}
}

function fetchMessages()
{
	global $response;
	global $userid;
	global $dbh;
	global $messages;
	$timestamp = 0;

	$sql = ("select cometchat.id, cometchat.from, cometchat.to, cometchat.message, cometchat.sent, cometchat.read from cometchat where (cometchat.to = '" . mysqli_real_escape_string($dbh, $userid) . "' or cometchat.from = '" . mysqli_real_escape_string($dbh, $userid) . "' ) and (cometchat.id > '" . mysqli_real_escape_string($dbh, $_POST['timestamp']) . "' or (cometchat.to = '" . mysqli_real_escape_string($dbh, $userid) . "' and cometchat.read != 1)) order by cometchat.id");
	$query = mysqli_query($dbh, $sql);

	while ($chat = mysqli_fetch_array($query)) {
		$self = 0;
		$old = 0;
		if ($chat['from'] == $userid) {
			$chat['from'] = $chat['to'];
			$self = 1;
			$old = 1;
		}

		$chat['message'] = iconv(CHARSET, 'utf-8', $chat['message']);

		$messages[] = array('id' => $chat['id'], 'from' => $chat['from'], 'message' => $chat['message'], 'self' => $self, 'old' => $old);

		if ($self == 0 && $old == 0 && $chat['read'] != 1) {
			$_SESSION['cometchat_user_' . $chat['from']][] = array('id' => $chat['id'], 'from' => $chat['from'], 'message' => $chat['message'], 'self' => 0, 'old' => 1);
		}


		$timestamp = $chat['id'];
	}

	if (!empty($messages)) {
		$sql = ("update cometchat set cometchat.read = '1' where cometchat.to = '" . mysqli_real_escape_string($dbh, $userid) . "' and cometchat.id <= '" . mysqli_real_escape_string($dbh, $timestamp) . "'");
		$query = mysqli_query($dbh, $sql);
	}
}

if (!empty($messages)) {
	$response['messages'] = $messages;
}

header('Content-type: application/json; charset=utf-8');
$result = mysqli_query($dbh, " Select * From _tbmensaje");
$row = mysqli_fetch_array($result);
$response['mensaje'] = $row['mensaje'];
echo json_encode($response);
exit;

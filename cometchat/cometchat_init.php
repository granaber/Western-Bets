<?php
require_once '../set_stateenv.php';
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Path to CometChat (default: cometchat/) [must have trailing /]
define('BASE_URL', 'cometchat/');

// Set your character set (default: ISO-8859-1)
define('CHARSET', 'ISO-8859-1');

// Set the time in seconds after which the users buddylist is refreshed (default: 60)
define('REFRESH_BUDDYLIST', '60');

// Set the time in seconds after which a user is considered offline if no response is received (default: 120)
define('ONLINE_TIMEOUT', '30');

// Smileys
$smileys = array(

	':)'	=>	'smiley',
	':-)'	=>	'smiley',
	':('	=>	'smiley-sad',
	':-('	=>	'smiley-sad',
	':D'	=>	'smiley-lol',
	';-)'	=>	'smiley-wink',
	';)'	=>	'smiley-wink',
	':o'	=>	'smiley-surprise',
	':-o'	=>	'smiley-surprise',
	'8-)'	=>	'smiley-cool',
	'8)'	=>	'smiley-cool',
	':|'	=>	'smiley-neutral',
	':-|'	=>	'smiley-neutral',
	":'("	=>	'smiley-cry',
	":'-("	=>	'smiley-cry',
	":p"	=>	'smiley-razz',
	":-p"	=>	'smiley-razz',
	":s"	=>	'smiley-confuse',
	":-s"	=>	'smiley-confuse',
	":x"	=>	'smiley-mad',
	":-x"	=>	'smiley-mad',

);

// Set to 1 if you want to disable smileys (default: 0)
define('DISABLE_SMILEYS', '0');

// Set to 1 if you want to disable auto linking (default: 0)
define('DISABLE_LINKING', '0');

// Set banned words here
$bannedWords = array("nastyword", "nastyword1", "nastyword2", "nastyword3", "nastyword4");

// Mysql configuration


$SERVERNAME = ($mode == $PRODUCCION) ? '10.136.242.179' : '127.0.0.1'; //; //;  //'159.89.93.31'
$SERVERPORT = '3306';
$USERNAME =  ($mode == $PRODUCCION) ? "betgambler_root" : 'root'; //"root";
$PASSWORD =  ($mode == $PRODUCCION) ? '8I#q}*7sGWC]' : 'H4W29ZoGSxKU'; //intra//
$DBNAME =  ($mode == $PRODUCCION) ? "parlay_betgambler" : "parlay_betgambler"; //

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// include_once "JSON.php";

error_reporting(E_ALL);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');

session_start();

function stripSlashesDeep($value)
{
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

// if (get_magic_quotes_gpc()) {
$_GET    = stripSlashesDeep($_GET);
$_POST   = stripSlashesDeep($_POST);
$_COOKIE = stripSlashesDeep($_COOKIE);
// }



$dbh = mysqli_connect($SERVERNAME . ':' . $SERVERPORT, $USERNAME, $PASSWORD);
mysqli_select_db($dbh, $DBNAME);
mysqli_set_charset($dbh, 'latin5');

define('TABLE_PREFIX', '');

$userid = 0;

// Please update the following logic below to return the userid of the logged in user
// We assume you will be using some sort of session/cookie to fetch those details
// For example we use a cookie called sessionhash and store it in table called session
//
// Session table
// ---------------------------------
// userid	sessionhash
// ---------------------------------
// 1		afgbdsfbsdfklbnlern34
//
// Or you can use something as simple as $userid = $_SESSION['userid'];

$sql = ("select IDusu from " . TABLE_PREFIX . "_tusu where IDusu = '" . mysqli_real_escape_string($dbh, $_COOKIE['sessionhash']) . "'");
$query = mysqli_query($dbh, $sql);
$session = mysqli_fetch_array($query);
$userid = $session['IDusu'];
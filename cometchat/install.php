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

include("cometchat_init.php");

$body = '';

if (empty($_GET)) {
	$body = <<<EOD
<form method="post" action="?step=2">
<strong>Thank you for purchasing CometChat!</strong><br/><br/>Please enter your CometChat members area username and password to continue:
<br/><br/>
<table width=398><tr>
<td width=30>Username:</td><td><input type="textbox" name="username" class="textbox"></td></tr>
<tr><td>Password:</td><td><input type="password" name="password" class="textbox"></td></tr>
</table>
<br/><br/>
<input type="image" src="images/nextstep.gif">
</form>
EOD;
} else {

	if ($_GET['step'] == "2") {



		if ($fp = fopen("http://www.cometchat.com/validate.php?username={$_POST['username']}&password={$_POST['password']}&path={$_SERVER['SERVER_NAME']}/{$_SERVER['SERVER_ADDR']}/{$_SERVER['SCRIPT_NAME']}", 'r')) {
			$content = '';

			while ($line = fread($fp, 1024)) {
				$content .= $line;
			}

			if (substr($content, 0, 1) == "0") {
				$body = "Oops! " . substr($content, 1);
			} else {

				$rollback = 0;
				$errors = '';

				$q = preg_split('/;[\r\n]+/', $content);

				if ($rollback == 0) {
					$query = "START TRANSACTION;";
					$result = mysqli_query($GLOBALS['link'], $query);
				}

				foreach ($q as $query) {
					if (strlen($query) > 4) {
						$result = mysqli_query($GLOBALS['link'], $query);
						if (!$result) {
							$rollback = 1;
							$errors .= mysqli_error($GLOBALS['minutosh']) . "<br/>\n";
						}
					}
				}

				if ($rollback == 0) {
					$query = "COMMIT;";
					$result = mysqli_query($GLOBALS['link'], $query);
				}

				if ($rollback == 1) {
					$body = "The following error(s) were encountered: <br><br><small>$errors</small><br/>Please make sure that the path to config.php is correct. If the problem persists, contact us at support@inscripts.com";
				} else {


					$scriptname = $_SERVER['SCRIPT_NAME'];
					$path = preg_split("/\/install.php/i", $scriptname);
					$body = <<<EOD
			
		Database was successfully configured!<br/><br/>Now add the following to your site header:<br/><br/>
		<small>	<small>	
		&lt;link type="text/css" rel="stylesheet" media="all" href="$path[0]/css/cometchat.css" /&gt; 
		</small></small>
		<br/><br/>Add the following to your site footer:<br/><br/>
<small><small>
&lt;script type="text/javascript" src="$path[0]/js/jquery.js"&gt;&lt;/script&gt;<br/>
&lt;script type="text/javascript" src="$path[0]/js/cometchat.js"&gt;&lt;/script&gt;
</small></small>
<br/><br/>
Please make sure the above paths are correct.
<br/><br/>
Congratulations! CometChat has been successfully integrated with your site. <br/><br/>Feel free to email us at support@inscripts.com if you have any queries.
EOD;
				}
			}
		} else {
			$body = "Oops! An error occurred with the server. Please try again. If the problem persists, contact us at support@inscripts.com";
		}
	}
}

?>
<html>

<head>
	<title>CometChat Setup</title>
	<style>
		body {
			padding: 0;
			margin: 0;
			font-family: "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif;
			font-size: 14px;
			color: #333333;

		}

		.setup {
			width: 398px;
			padding: 10px;
		}

		td {
			font-family: "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif;
			font-size: 14px;
			color: #333333;

		}


		.textbox {
			width: 200px;
			font-family: "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif;
			font-size: 14px;
			color: #333333;
			border: 1px dotted black;
		}
	</style>
</head>

<body>
	<img src="images/setup.gif"><br clear="all" />
	<div class="setup"><?php echo $body; ?>
	</div>
</body>

</html>
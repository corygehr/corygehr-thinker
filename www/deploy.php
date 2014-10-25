<?php
	/**
	 * GIT DEPLOYMENT SCRIPT
	 *
	 * Used for automatically deploying websites via github or bitbucket, more deets here:
	 *
	 *		https://gist.github.com/1809044
	 */

// See if we should proceed
if((isset($_GET['proceed']) && $_GET['proceed']))
{
	$targetDir = '';

	// The commands
	$commands = array(
		$targetDir,
		$targetDir . 'echo $PWD',
		$targetDir . 'whoami',
		$targetDir . 'git pull',
		$targetDir . 'git status',
		$targetDir . 'git submodule sync',
		$targetDir . 'git submodule update',
		$targetDir . 'git submodule status',
	);
	 
		// Run the commands for output
		$output = '';
		foreach($commands AS $command) {
			// Run it
			$tmp = shell_exec($command);
			// Output
			$output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
			$output .= htmlentities(trim($tmp)) . "\n";
		}
 
	// Make it pretty for manual user access (and why not?)
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
 .  ____  .    ____________________________
 |/      \|   |                            |
[| <span style="color: #FF0000;">&hearts;    &hearts;</span> |]  | Git Deployment Script v0.1 |
 |___==___|  /  &copy; oodavid 2012, Modified by Cory Gehr (2014) |
              |____________________________|
 
<?php echo $output; ?>
</pre>
</body>
</html>
<?php
	// Kill script
	exit();
}

// Output a 404 if all else fails
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL /deploy.php was not found on this server.</p>
<hr>
<address><?php echo $_SERVER['SERVER_SIGNATURE']; ?></address>
</body></html>
<?php
	exit();
?>
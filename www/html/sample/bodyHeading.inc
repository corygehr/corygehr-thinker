<?php
	/**
	 * bodyHeading.inc
	 * Contains the heading for each THINKer page
	 *
	 * @author Cory Gehr
	 */
?>
	<div id='head-wrapper'>
		<div id='head-container'>
			<a href='<?php echo BASE_URL; ?>'><img src='html/sample/images/logo.png' alt='THINKer'></a>
			<p class='user-info'>
				Welcome!
			</p>
			<div id='head-usernav'>
				<ul>
					<li><a href='#'>Sample Link</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id='main-wrapper'>
		<div id='content-container'>
<?php
	// Output notifications
	if(!empty($_MESSAGES))
	{
		foreach($_MESSAGES as $msg)
		{
			list($text, $level) = $msg;

			$output = "<div class='notification ";

			switch($level)
			{
				case 'error':
					$output .= "error'><p><span class='ui-icon ui-icon-circle-close' style='float: left; margin-right: .3em;'></span><strong>Error:</strong> $text</p></div>";
				break;

				case 'success':
					$output .= "success'><p><span class='ui-icon ui-icon-check' style='float: left; margin-right: .3em;'></span><strong>Success:</strong> $text</p></div>";
				break;

				case 'warning':
					$output .= "warning'><p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><strong>Warning:</strong> $text</p></div>";
				break;

				default:
					$output .= "info'><p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span><strong>Info:</strong> $text</p></div>";
				break;
			}

			echo $output;
		}
	}
?>
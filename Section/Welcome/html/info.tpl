<?php
    /**
     * Welcome/html/info.tpl
     * Contains the HTML template for the info subsection
     *
     * @author Cory Gehr
     */
?>
<h1>THINKer Framework Sample Page</h1>
<p>
	<?php echo $this->get('message1'); ?>
</p>
<p>
	<?php echo $this->get('message2'); ?>
</p>
<p>
	<?php echo $this->get('message3', 'inline', 'There should not be any more messages.'); ?>
</p>
<?php
	if($this->authPageSection('testSection', 'inline'))
	{
?>
<p>
	Authorized!
</p>
<?php
	}
?>
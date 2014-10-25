<?php
    /**
     * Error/html/info.tpl
     * Contains the HTML template for the info subsection
     *
     * @author Cory Gehr
     */
?>
<h1><?php echo $this->get('number'); ?>: <?php echo $this->get('description'); ?></h1>
<p>
	<?php echo $this->get('message'); ?>
</p>
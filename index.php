<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php find_selected_section(); ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo public_navigation($sel_header, $sel_section); ?>
		</td>
		<td id="page">
			<?php if ($sel_section) { ?>
				<h2><?php echo htmlentities($sel_section['section_name']); ?></h2>
				<div class="page-content">
					<?php echo strip_tags(nl2br($sel_section['section_subheading']), "<b><br><p><a>"); ?>
				</div>
			<?php } else { ?>
				<h2>Welcome to Review Website</h2>
			<?php } ?>
		</td>
	</tr>
</table>
<?php include("includes/footer.php"); ?>
	</div><!-- #content -->
<footer id="footer">
<?php
	//Modale formulaire de contact
	get_template_part ('template_parts/popup-contact');
	//Contenu Footer
	wp_nav_menu(array(
		'theme_location' => 'footer',
		'menu_id' => 'footer-menu',
		'container' => 'nav',
	));
?>
</footer>
</body>
</html>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.js"></script>

<script type="text/javascript">
	jQuery('.rpm-menu-close').click(function() {
		var parent = jQuery(this).parent();
		parent.css('display', 'none');
	});
	jQuery('.rpm-menu-open').click(function() {
		console.log('hola');
		var menu = jQuery(this).parents('.rpm-menu').find('.rpm-menu-toggle');
		menu.css('display', 'block');
	});
	jQuery('.rpm-researches-list').masonry({itemSelector: '.rpm-research-item'});
</script>
</body>
</html>
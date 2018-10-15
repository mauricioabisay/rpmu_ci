</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

<script type="text/javascript">
	function slugify(string) {
		const a = 'àáäâãåèéëêìíïîòóöôùúüûñçßÿœæŕśńṕẃǵǹḿǘẍźḧ·/_,:;';
		const b = 'aaaaaaeeeeiiiioooouuuuncsyoarsnpwgnmuxzh------';
		const p = new RegExp(a.split('').join('|'), 'g');
		return string.toString().toLowerCase()
		.replace(/\s+/g, '-') // Replace spaces with
	    .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
	    .replace(/&/g, '-and-') // Replace & with ‘and’
	    .replace(/[^\w\-]+/g, '') // Remove all non-word characters
	    .replace(/\-\-+/g, '-') // Replace multiple — with single -
	    .replace(/^-+/, '') // Trim — from start of text .replace(/-+$/, '') // Trim — from end of text
	}
</script>
<script type="text/javascript" src="<?php echo base_url('resources/admin.js');?>"></script>

<script type="text/javascript">
	var googleUser = {};

	var startApp = function() {
		gapi.load('auth2', function() {
			// Retrieve the singleton for the GoogleAuth library and set up the client.
			auth2 = gapi.auth2.init({
				client_id: '<?php echo $this->config->item('google_oauth')?>',
				cookiepolicy: 'single_host_origin',
		        // Request scopes in addition to 'profile' and 'email'
		        //scope: 'additional_scope'
		    });
		    if ( document.getElementById('g-custom-btn') ) {
		    	attachSignin(document.getElementById('g-custom-btn'));
		    }
		    jQuery('#g-logout-btn').click(function() {
		    	var auth2 = gapi.auth2.getAuthInstance();
		    	auth2.signOut().then(function () {
		    		jQuery('#logout').submit();
		    	});
		    });
		});
	};

	function attachSignin(element) {
		auth2.attachClickHandler(
			element, 
			{},
			function(googleUser) {
				document.getElementById('token').value = googleUser.getAuthResponse().id_token;
				document.getElementById('login').submit();
	        }, 
	        function(error) {
	        	alert(JSON.stringify(error, undefined, 2));
	        }
		);
	}
	window.onload = function() {
		startApp();
	};
</script>
</body>
</html>
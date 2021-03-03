(function() {
	LazyImage();

	function LazyImage() {
		var _watcher = setInterval(check, (1000 / 120));

		function check() {
			var $els = document.querySelectorAll('lazyimage, lazy-image');

			$els.forEach($el => {
				var i= 0,
					attrs = '';

				for(i=0;i<$el.attributes.length;i++) {
					var attr = $el.attributes[i];

					attrs += ' '+attr.name+'="'+attr.value+'"';
				}

				$el.outerHTML = '<img '+attrs+' class="img-fluid img-responsive" loading="lazy">'
			});
		}
	}
})();

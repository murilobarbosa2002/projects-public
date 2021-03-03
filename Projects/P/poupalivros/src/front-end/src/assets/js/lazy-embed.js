var LazyEmbed = (function() {
	const items = $(".lazy-embed");

	if(window.IntersectionObserver) {
		const observer = new IntersectionObserver((entries) => {
		    $(entries).each(function (index, entry) {
		        if (entry.isIntersecting === true) {
		        	let iframe = $(entry.target).find('template').html();

		        	$(entry.target).html(iframe);

		        	$(entry.target).find('iframe').on('load', function() {
		        		$(entry.target).addClass('loaded');
		        		entry.target.setAttribute('loaded','');
		        	});

		        	observer.unobserve(entry.target)
		        }
		    });
		}, {
			rootMargin: "0px 0px 200px 0px"
		});

		items.each(function (index, item) {
		    observer.observe(item, index);
		});

	}else {

		items.each(function (index, item) {
			var iframe = $(this).find('template').html();

			$(this).html(iframe);
		});

	}

})();

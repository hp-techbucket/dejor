	

	$(document).ready(function(){
		
			

			// Javascript to enable link to tab
			var url = document.location.toString();
			if (url.match('#')) {
				
				$('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
				//$('a[href="' + url.split('#')[1] + '"]').click()
			} //*/

			var prefix = "tab_";
			
			// Change hash for page-reload
			$('.fa-ul a').on('click', function (e) {
				var url = $(this).attr('href');
				var hash = url.split('#')[1];
				window.location.href.split('#')[0]
				//var hash = url.split("#")[1];
				//alert(hash);
				//$('.nav-tabs a[href="#' + hash + '"]').tab('show');
				if (hash) {
					
					$('.nav-tabs a[href="#' + hash + '"]').tab('show');
					//$('.nav-tabs a[href="#'+hash.replace(prefix,"")+'"]').tab('show');
					/*$('html, body').animate({
						scrollTop: $('.services-container').offset().top
					}, 2000);*/
				} 
				
			});		
			
			// Change hash for page-reload
			/*$('.nav-tabs a').on('shown.bs.tab', function (e) {
				//window.location.hash = e.target.hash;
				if(history.pushState) {
					history.pushState(null, null, e.target.hash); 
				} else {
					window.location.hash = e.target.hash; //Polyfill for old browsers
				}
				$('html, body').animate({
					scrollTop: $('.services-container').offset().top
				}, 2000);
			});	*/
			// Change hash for page-reload
			$('.nav-tabs a').on('shown', function (e) {
				window.location.hash = e.target.hash;
				//window.location.hash = e.target.hash.replace("#", "#" + prefix);
				$('html, body').animate({
					scrollTop: $('.services-container').offset().top
				}, 2000);
			});//*/
			handleTabLinks();//*/
			
				
			/*$('#services').on("load", function () {
				
			});*/
			$('ul.tabs-left li a').click(function(event) {
				//event.preventDefault();
				
				//window.location.hash = this.hash;
				var url = $(this).attr('href');
				var hash = url.split('#')[1];
				window.location.href.split('#')[0]
				//var hash = url.split("#")[1];
				//alert(hash);
				//$('.nav-tabs a[href="#' + hash + '"]').tab('show');
				if (hash) {
					
					$('.nav-tabs a[href="#' + hash + '"]').tab('show');
					//$('.nav-tabs a[href="#'+hash.replace(prefix,"")+'"]').tab('show');
					/*$('html, body').animate({
						scrollTop: $('.services-container').offset().top
					}, 2000);*/
				} 
			});
			
			
			
			 	
	});	

	
	$(function(){
		// Remove the # from the hash, as different browsers may or may not include it
		var hash = location.hash.replace('#','');

		if(hash != ''){
			// Show the hash if it's set
			//alert(hash);

			// Clear the hash in the URL
			location.hash = '';
		}
	});
		
	function handleTabLinks() {
	  var hash = window.location.href.split("#")[1];
	  if (hash !== undefined) {
		var hpieces = hash.split("/");
		for (var i=0;i<hpieces.length;i++) {
		  var domelid = hpieces[i];
		  var domitem = $('a[href=#' + domelid + '][data-toggle=tab]');
		  if (domitem.length > 0) {
			if (i+1 == hpieces.length) {
			  // last piece
			  setTimeout(function() {
				// Highly unclear why this code needs to be inside a timeout call.
				// Possibly due to the fact that the first ?.tag('show') call needs
				// to have it's animation finishing before the next call is being
				// made.
				domitem.tab('show');
			  },
			  // This magic timeout is based on trial and error. I bumped it
			  // partially to catch the visitor's attention.
			  1000);
			} else {
			  domitem.tab('show');
			}
		  }
		}
	  }
	}

			
	//open tab on click
	function showTab(tab){
		$("html, body").animate({
			scrollTop: $(".nav-pills").offset().top - 150
		}, 600);
		$('.nav-pills a[href="#' + tab + '"]').tab('show');
			
	}
			
	//scroll to tab on click
	function scrollToTab(obj){
		
		var tab = $(obj).attr('href');
		//alert(tab);
		$('.nav-pills a[href="' + tab + '"]').click();
		
		$("html, body").animate({
			scrollTop: $(".nav-pills").offset().top - 150
		}, 600);
		//REMOVE ALL ACTIVE CLASSES
		//FROM NAV
		/*$('.nav-pills li').removeClass('active');
		//AND PANE
		$('.tab-pane').removeClass('active');
		$('.tab-pane').removeClass('in');
		
		//ADD CLASS TO CLICKED PILL
		//GET TAB
		var tab = $(obj).attr('href');
		//$(obj).parent().addClass('active');
		$('.nav-pills a[href="#' + tab + '"]').parent().addClass('active');
		
		
		//ADD ACTIVE CLASSES
		$(tab).addClass('active');
		$(tab).addClass('in');
		
		$("html, body").animate({
			scrollTop: $(".nav-pills").offset().top - 150
		}, 600);
		*/
	}	

	
	
	
		
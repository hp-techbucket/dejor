//gallery-images.js
	
	$(document).ready(function(){
					
		$("a.grouped_elements").fancybox();
			
		$("a#single_image").fancybox();
			
		$("a.group").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	false
		});
		
	
	});	
		
	//function to display clicked image
	//as main image
	function changeImage(a) {
		document.getElementById("main-img").src=a;
		$('#single_image').attr('href',a);
		$('.main-img').attr('src',a);
		//$("#main-img").parent().attr("href", a);
		//$(".main-img").parent().attr("href", a);
	}
		
		
								
		//function to remove or add more images
		function viewImages(id, url) {
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
						
			$( "#load" ).show();
			
			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
						
						$("#image-gallery").html(data.image_gallery);
						$("#column").html(data.image_column);
						$("#mySlides").html(data.image_slides);
						
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}	


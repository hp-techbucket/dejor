		
		//function for multiple file upload display
		$(document).ready(function() {
			
			$(".progress").hide();
			
			$('.fileinput').fileinput();
			
			//image preview file upload
			$('[type=file]').change(function() {
				$('.fileinput-preview').show();
				
			});
			
			
			var max_fields      = 5; //maximum input boxes allowed
			var wrapper         = $(".input_file_wrap"); //Fields wrapper
			var add_button      = $(".upload_more_button"); //Add button ID
			var more_button      = $(".upload_more_btn"); //Add button ID
			
			var x = 1; //initial upload file box count
			
			//MESSAGE ATTACHMENT
			$(add_button).click(function(e){ //on add input button click
				e.preventDefault();
				if(x < max_fields){ //max input box allowed
					x++; //text box increment
					$(wrapper).append('<div class="form-group"><div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-default btn-file btn-xs"><span class="fileinput-new">Attach file <i class="fa fa-paperclip" aria-hidden="true"></i></span><span class="fileinput-exists">Change</span><input type="file" name="documents[]"></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a></div></div>'); //add input box
				}
			});
			
			//VEHICLES
			$(more_button).click(function(e){ //on add input button click
				e.preventDefault();
				if(x < max_fields){ //max input box allowed
					x++; //text box increment
					
					$(wrapper).append('<div class="form-group"><img class="img-preview" src="#" alt="" /> <div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-default btn-file btn-xs"><span class="fileinput-new">Select image file <i class="fa fa-file-image-o" aria-hidden="true"></i></span><span class="fileinput-exists">Change</span><input type="file" name="vehicle_images[]" onchange="readURL(this);"></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a></div></div>'); //add input box

					/*
					$(wrapper).append('<div class="form-group"><div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 65px; height: 50px; display:none;"></div><div><span class="btn btn-default btn-file btn-xs"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="vehicle_images[]"></span><a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a></div></div></div>');
					*/
				}
			});
			
			
				
				//
			/*	$('.upload_more_button').click(function() {	
					alert('More');
					$(".input_file_wrap").append('<div class="form-group"><div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="documents[]"></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a></div></div>'); //add input box					
				});
			*/
			//function to remove file input box
			$(wrapper).on("click",".close.fileinput-exists", function(e){ //user click on remove text
				e.preventDefault(); 
				//$(this).parent().prev().remove();
				var img_preview = $(this).parent().prev();
				img_preview.attr('src', '');
			});
			
			//function to remove file input box
			$(document).on("click",".remove_field", function(e){ //user click on remove text
				e.preventDefault(); $(this).parent('div').remove(); x--;
			});
			
			$('[name="documents[]"]').change(function () { 
				var ext = $(this).val().match(/\.(.+)$/)[1];
				switch(ext)
				{
					case 'jpg':
					case 'jpeg':
					case 'doc':
					case 'docx':
					case 'png':
					case 'pdf':
						alert('allowed');
						break;
					default:
						alert('not allowed');
						return false;
				}
			});

		});	
		
		//function for filename display for multiple file upload
		function getFilename(obj){
			var filename = $(obj).val().replace(/C:\\fakepath\\/i, '');
			$(obj).parent().parent().find('.image_name').html(filename);
		}
		
		//function filename display for multiple file upload
		function displayFilename(obj){
			var filename = $(obj).val().replace(/C:\\fakepath\\/i, '');
			$(obj).parent().parent().find('.image_name').html(filename);
		}
		
		function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
					//var img_preview = $(input).closest('.form-group').find('.img-preview');
					var img_preview = $(input).parent().parent().prev();
					
                    img_preview
                        .attr('src', e.target.result)
                        .width(50)
                        .height(50);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
		
		function progressBarMove() {
			$("#myProgress").show();
			  var elem = document.getElementById("myBar");   
			  var width = 1;
			  var id = setInterval(frame, 10);
			  function frame() {
				if (width >= 100) {
				  clearInterval(id);
				} else {
				  width++; 
				  elem.style.width = width + '%'; 
				}
			  }
		}
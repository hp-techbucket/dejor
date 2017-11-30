//custom-filters.js
	
	$(document).ready(function(){
		
		//*****************FUNCTIONS FOR FILTER BOX*********************/// 
		//TOGGLE ALL DISPLAY OF FILTER BOX
		$(".minimize-all").click(function (e) {
				$("i",this).toggleClass("fa-plus-square fa-minus-square");
				$('.filter-section').slideToggle(200);
				
				if ($("i",this).hasClass("fa-minus-square")) {
					$(".minimize-box i").addClass("fa-minus-square");
					$(".minimize-box i").removeClass("fa-plus-square");
				}else{
					$(".minimize-box i").removeClass("fa-minus-square");
					$(".minimize-box i").addClass("fa-plus-square");
				} 
				
				//alert('TEST');
				//$(this).siblings('filter-section').slideToggle(200);
				//$('.filter-section').slideToggle(200);
		});
			
			//CLEAR ALL FILTER BOX CHECKBOX
		$(".clear-all").click(function (e) {
				e.preventDefault();
				
				$('input').prop('checked', false); 
				
		});
		
		//TOGGLE DISPLAY OF FILTER BOX
		$(".minimize-box").click(function (e) {
				$("i",this).toggleClass("fa-plus-square fa-minus-square");
				$(this).parent().parent().find('.filter-section').slideToggle(200);
				
				if ($("i",this).hasClass("fa-minus-square")) {
					$(".minimize-all i").addClass("fa-minus-square");
					$(".minimize-all i").removeClass("fa-plus-square");
				}else{
					$(".minimize-all i").removeClass("fa-minus-square");
					$(".minimize-all i").addClass("fa-plus-square");
				} 
				
				//alert('TEST');
				//$(this).siblings('filter-section').slideToggle(200);
				//$('.filter-section').slideToggle(200);
		});
			
		
		//CLEAR FILTER BOX CHECKBOX
		$(".clear-box").click(function (e) {
				e.preventDefault();
				
				$(this).parent().parent().parent().find('input').prop('checked', false); 
				
		});
			
		//$('#vehicles-listings-table').DataTable();
			
			$(".btn_gp").on("click", function(){
                $(".modal_grap").bsModal("show");
            });
			//$(".toggle-sidebar").html('Filter <i class="fa fa-times"></i>');
			
		$(".toggle-sidebar").click(function () {
				$("#sidebar").toggleClass("collapsed");
				$("#content").toggleClass("col-md-12 col-md-10");
				//$("i",this).toggleClass("fa-bars fa-times");
				if($("#sidebar").hasClass("collapsed")){
					$(this).html('Filter <i class="fa fa-bars"></i>');
				}else{
					$(this).html('Filter <i class="fa fa-times"></i>');
				}
				return false;
		});
		
		//HIDE SIDEBAR WHEN MOBILE
		adjustSideBar();
		
			/*$("#nav-expander").click(function(e) {
				e.preventDefault();
				
				$("#sidebar-section").toggleClass("offcanvas");
				var page = $(this).parent().parent();
				
				if($("#sidebar-section").hasClass("offcanvas")){
					$("#nav-expander").html('FILTER &nbsp;<i class="fa fa-bars fa-lg white"></i>');
					page.css("width","100%");
				}else{
					page.css("width","84%");
					$("#nav-expander").html('CLOSE &nbsp;<i class="fa fa-times fa-lg white"></i>');
				}
				//REDUCE MAIN CONTENT
				
				//if(page.hasClass("col-md-12")){
					//page.css("width","84%");
					//page.css("margin-right","-250px");
					//page.removeClass("col-md-12");
					//page.addClass("col-md-9");
				//}else{
					//page.css("width","100%");
					//page.css("margin-right","250px");
					//page.addClass("col-md-12");
					//page.removeClass("col-md-9");
				//}
				//
			});*/
			
						

	
	});	
	
	//HIDE SIDEBAR WHEN MOBILE
	function adjustSideBar(){
		if($(window).width() <= 992) {
			$("#sidebar").addClass("collapsed");
			$(".toggle-sidebar").html('Filter <i class="fa fa-bars"></i>');
		}else{
			$("#sidebar").removeClass("collapsed");
			$(".toggle-sidebar").html('Filter <i class="fa fa-times"></i>');
		}
	}
	
	//HIDE SIDEBAR WHEN WINDOW RESIZE
	$( window ).resize(function() {
	  adjustSideBar();
	});
	
	//FUNCTION TO SEARCH FILTER LISTS
	function searchList(obj) {
		
		// Declare variables
		var input, filter, ul, li, a, i;
		
		var id = $(obj).attr('id');
		var list = $(obj).next().attr('id');
		input = document.getElementById(id);
		
		filter = input.value.toUpperCase();
		ul = document.getElementById(list);
		li = ul.getElementsByTagName('li');

		// Loop through all list items, and hide those who don't match the search query
		for (i = 0; i < li.length; i++) {
			//a = li[i].getElementsByTagName("div label")[0];
			//var name = li[i].getElementsByTagName("label");
			var name = li[i].getElementsByClassName('checkbox_label')[0].innerHTML;
			if (name.toUpperCase().indexOf(filter) > -1) {
				li[i].style.display = "";
			} else {
				li[i].style.display = "none";
			}
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
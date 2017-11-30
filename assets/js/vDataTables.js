			
		
		/*
		**	DATATABLE FUNCTION
		**  DISPLAY VEHICLES
		**  WITH SEARCH AND PAGINATION
		*/ 
		
		$(document).ready(function() {
			
			
			//vehicles-listings-table
			var table = $('#vehicles-listings-table2').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"vehiclefinder/vehicles_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
					//"className": 'mdl-data-table__cell--non-numeric', //Material Design
				},
				],
				//"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				
				responsive: true,
				
				
			});
			
			//otable = $('#vehicles-listings-table').dataTable();
			//DataTable
			//$('#vehicles-listings-table').DataTable();
			
			//vehicles-listings-table
			var table = $('#vehicles-listings-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
					//"className": 'mdl-data-table__cell--non-numeric', //Material Design
				},
				],
				//"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				//"dom": 'rtp',
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				//scrollY: 300,
				//paging: false,
				//"pagingType": "simple",
				"bInfo" : false,
				responsive: true,
				
				
			});
			
			
			$(".checkbox input").change(function () {
				
				var search = [];
				$.each($('.checkbox input'), function () {
					 if ($(this).is(":checked")) {
						 search.push($(this).val());
						 alert($(this).val());
					 }
				});
				
				/*$(".checkbox input:checkbox:checked").each(function () {
					
					var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );
					search.push(val);
				});*/
				
				search = search.join('|');
				
				var i = $(this).parents('ul').attr('data-column');
				//.column( i )
				
				$('#vehicles-listings-table').DataTable().column(i).search(
					search, true, false
					//"^(?=.*?(" + search + ")).*?",
					//search ? '^'+search+'$' : '', true, false 
					//search.replace(/;/g), true, false
					
				).draw();
				//*/
				/*var checkedVals = $('input:checkbox:checked',this).map(function() {
					return this.value;
				}).get();if($(this).is(':checked')){
					filterGlobal($(this).parents('ul').attr('data-column'), $(this).attr('data-column'));
				}*/
			});
		
			
			
			$(".search input").change(function () {
				
				var search = $(this).val();
				
				$('#vehicles-listings-table').DataTable().search(
					search, true, false
					//"^(?=.*?(" + search + ")).*?",
					//search ? '^'+search+'$' : '', true, false 
					//search.replace(/;/g), true, false
					
				).draw();
				
			});
		
			
	});
	
			
	
	function filterMe(obj, i) {
	  //build a regex filter string with an or(|) condition
	  var types = $('input:checkbox:checked').map(function() {
		return obj.value;
		
	  }).get().join('|');
	  alert(obj.value);
	  //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
	  otable.fnFilter(types, i, true, false);
	}
	
	function columnFilter() {
		  //build a regex filter string with an or(|) condition
		  var types = $('.checkbox input:checked').map(function() {
			return '^' + this.value + '\$';
		  }).get().join('|');
		  //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
		  $('#vehicles-listings-table').dataTable().fnFilter(types, 0, true, false, false, false);

	}	
	function filterGlobal ( i, k ) {
    	$('#vehicles-listings-table').DataTable().search(
        	//"^(?=.?(" + $('#col_'+i+'_filter_'+k).val() + ")).?",
			//$('#col_'+i+'_filter_'+k).val(),
			$('#col_'+i+'_filter_'+k).prop('checked'),
        	true
    	).draw();
	}
	function filterColumn ( i, k ) {
		//alert('Search: '+$('#col_'+i+'_filter_'+k).val());
		$('#vehicles-listings-table').DataTable().column( i ).search(
			$('#col_'+i+'_filter_'+k).val(),
			$('#col_'+i+'_filter_'+k).prop('checked'),
			//,
			//$('#col_'+i+'_filter_'+k).prop('checked')
		).draw();
	}
  
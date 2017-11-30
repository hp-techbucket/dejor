		
		
		
		/*
		**	DATATABLE FUNCTIONS	
		**  DISPLAY ALL TABLES
		**  WITH SEARCH AND PAGINATION
		*/ 
		$(document).ready(function() {
		 
			
			
			//INBOX-MESSAGES TABLE
			var table = $('#inbox-messages-table').DataTable({ 
			
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
					"url": baseurl+"message/inbox_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});	
						
			
			//archive-messages-table
			var table = $('#archive-messages-table').DataTable({ 
			
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
					"url": baseurl+"message/archive_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});	

			//SENT-MESSAGES TABLE
			var table = $('#sent-messages-table').DataTable({ 
			
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
					"url": baseurl+"message/sent_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});																			
								
						
			// REVIEWS-TABLE
			var table = $('#reviews-table').DataTable({ 
			
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
					"url": baseurl+"account/review_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});					
					
						
			// SALE ENQUIRIES TABLE
			var table = $('#sale-enquiries-table').DataTable({ 
			
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
					"url": baseurl+"account/sale_enquiry_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});					
					
			
			//MARK MESSAGE AS READ
			$('#sale-enquiries-table').on( 'click', 'tr', function () {
				//alert($('#cb',this).val());
				//var id = $('#cb',this).val();
				
				$("span",this).addClass('msgRead');
				
			});
			
						
			//ORDERS TABLE
			var table = $('#orders-table').DataTable({ 
		 
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
					"url": baseurl+"account/orders_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				responsive: true
			});
																		

			// SHIPPING TABLE
			var table = $('#shipping-table').DataTable({ 
			
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
					"url": baseurl+"account/shipping_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});					
																		
						
						
			// TRANSACTIONS TABLE
			var table = $('#transactions-table').DataTable({ 
			
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
					"url": baseurl+"account/transaction_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});					
							
							
			// PAYMENTS TABLE
			var table = $('#payments-table').DataTable({ 
			
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
					"url": baseurl+"account/payments_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});	

			
			//VEHICLES TABLE
			var table = $('#vehicles-listings-table').DataTable({ 
			
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
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});	
			
			
			//vehicles table
			var table = $('#vehicles-table').DataTable({ 
			
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
					"url": baseurl+"account/vehicles_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});	

			
			//new $.fn.dataTable.FixedHeader( table );
			//$("div.toolbar").html('<button>Delete</button>');

			/*
			**	END DATATABLE FUNCTIONS	
			*/ 
					
		});	
		
		
		
		
	
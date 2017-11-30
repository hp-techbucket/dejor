		
		
		
		/*
		**	DATATABLE FUNCTIONS	
		**  DISPLAY ALL TABLES
		**  WITH SEARCH AND PAGINATION
		*/ 
		$(document).ready(function() {
		 
			//admin users table
			var table = $('#admin-users-table').DataTable({ 
		 
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
					"url": baseurl+"admin/admin_users_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				//"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				
				responsive: true
				
			});
  
 		 	
			//users table
			var table = $('#active-users-table').DataTable({ 
		 
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
					"url": baseurl+"admin/active_users_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				//"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				
				responsive: true
				
			});
  
 		 	
			//temp users table
			var table = $('#temp-users-table').DataTable({ 
		 
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
					"url": baseurl+"admin/temp_users_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				//"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				
				responsive: true
				
			});
  
 		 	 		 	
			//suspended users table
			var table = $('#suspended-users-table').DataTable({ 
		 
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
					"url": baseurl+"admin/suspended_users_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				//"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				
				responsive: true
				
			});
  			
						
			//REVIEWS TABLE
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
					"url": baseurl+"admin/review_datatable",
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
			
			
						
			//orders table
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
					"url": baseurl+"admin/orders_datatable",
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
																		

			// shipping table
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
					"url": baseurl+"admin/shipping_datatable",
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
																		
			
			// shipping-methods table
			var table = $('#shipping-methods-table').DataTable({ 
			
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
					"url": baseurl+"admin/shipping_methods_datatable",
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
			
			// shipping-status table
			var table = $('#shipping-status-table').DataTable({ 
			
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
					"url": baseurl+"admin/shipping_status_datatable",
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
						
			// transactions table
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
					"url": baseurl+"admin/transaction_datatable",
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
							
							
			// payments table
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
					"url": baseurl+"admin/payments_datatable",
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

							
			// payment methods table
			var table = $('#payment-methods-table').DataTable({ 
			
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
					"url": baseurl+"admin/payment_methods_datatable",
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
				
				
			//contact us table
			var table = $('#contact-us-table').DataTable({ 
		 
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
					"url": baseurl+"admin/contact_us_datatable",
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
			$('#c-us-table tbody').on( 'click', 'tr', function () {
				if ( $(this).hasClass('selected') ) {
					$(this).removeClass('selected');
				}
				else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			} );
			
			//mark message as read
			$('#contact-us-table').on( 'click', 'tr', function () {
				//alert($('#cb',this).val());
				//var id = $('#cb',this).val();
				
				$("span",this).addClass('msgRead');
				
			});
			
			//SALE ENQUIRIES TABLE
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
					"url": baseurl+"admin/sale_enquiry_datatable",
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
			
			
			//mark message as read
			/*$('#sale-enquiries-table').on( 'click', 'tr', function () {
				//alert($('#cb',this).val());
				//var id = $('#cb',this).val();
				
				$("span",this).addClass('msgRead');
				
			});
			*/
			
			//logins table
			var table = $('#logins-table').DataTable({ 
		 
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
					"url": baseurl+"admin/logins_datatable",
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
	
			
			//failed logins table
			var table = $('#failed-logins-table').DataTable({ 
		 
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
					"url": baseurl+"admin/failed_logins_datatable",
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
	
					
			//password resets table
			var table = $('#password-resets-table').DataTable({ 
		 
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
					"url": baseurl+"admin/password_resets_datatable",
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
			
						
			
			//failed resets table
			var table = $('#failed-resets-table').DataTable({ 
		 
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
					"url": baseurl+"admin/failed_resets_datatable",
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
			
			
			
						
					
			//keywords-table table
			var table = $('#keywords-table').DataTable({ 
			
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
					"url": baseurl+"admin/keywords_datatable",
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
																							
					
			
			
			//subscription list table
			var table = $('#subscription-list-table').DataTable({ 
		 
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
					"url": baseurl+"admin/subscription_list_datatable",
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


			
			//inbox-messages table
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
			
			//sent-messages table
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
			
				
			//all-messages table
			var table = $('#all-messages-table').DataTable({ 
			
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
					"url": baseurl+"message/all_messages_datatable",
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
			
			//site activities table
			var table = $('#site-activities-table').DataTable({ 
			
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
					"url": baseurl+"admin/site_activities_datatable",
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
					"url": baseurl+"admin/vehicles_datatable",
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

			
			//vehicle makes table
			var table = $('#vehicle-makes-table').DataTable({ 
			
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
					"url": baseurl+"admin/vehicle_make_datatable",
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
			
			//vehicle models table
			var table = $('#vehicle-models-table').DataTable({ 
			
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
					"url": baseurl+"admin/vehicle_model_datatable",
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
			
			//vehicle types table
			var table = $('#vehicle-types-table').DataTable({ 
			
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
					"url": baseurl+"admin/vehicle_type_datatable",
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
															
			
			//page metadata table
			var table = $('#page-metadata-table').DataTable({ 
			
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
					"url": baseurl+"admin/page_metadata_datatable",
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
			
																				
			//colours table
			var table = $('#colours-table').DataTable({ 
			
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
					"url": baseurl+"admin/colours_datatable",
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
			
																				
			//security questions table
			var table = $('#security-questions-table').DataTable({ 
			
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
					"url": baseurl+"admin/security_questions_datatable",
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
		
		
		
		
	
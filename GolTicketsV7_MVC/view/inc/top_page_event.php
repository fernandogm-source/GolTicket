<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Creación de eventos</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" />
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>	
    	<script type="text/javascript">
        	$(function() {
							// Timepicker
						$("#event_hour").timepicker({
							timeFormat: "HH:mm",
							stepMinute: 15,
							//hourMin: 9,
							//hourMax: 18,
							controlType: "select"
						});
						  // Datepicker
						$("#event_date").datepicker({
							dateFormat: "dd/mm/yy",
							minDate: 1
						});
        	});
	    </script>
	    <link href="view/css/style.css" rel="stylesheet" type="text/css" />
	    <script src="module/event/model/validate_event.js"></script>

		<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    </head>
    <body>
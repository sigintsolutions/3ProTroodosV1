<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Argus Panoptes - Administration</title>
    <?php /*?><link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" /><?php */?>
	<link rel="shortcut icon" href="{{ asset('content/image/favicon.png') }}" type="image/png" sizes="36x36">
    <link type="text/css" href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
	<link type="text/css" href="{{ asset('css/Euz_style.css') }}" rel="stylesheet" />
	<link type="text/css" href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet" />
    <script src="{{ url('js/jquery.min.js') }}"></script>    
    <script src="{{ url('js/bootstrap.min.js') }}"></script>
    
</head>
<style>
	body 
	{
		background-image: url({{ url('/image/loginbg.jpg') }});
		padding-top: 0px !important;
		background-repeat:no-repeat;
		background-size:cover;
	}
</style>

<body>
    
            @yield("content")
			
			<script src='https://www.google.com/recaptcha/api.js'></script>
			<script>
grecaptcha.ready(function() {
    grecaptcha.execute('6LeppMQUAAAAAObC7r7WAhU7I7W9OeBY6gjFP5kV', {action: '/login'}).then(function(token) {
       if(token)
	   {
	   document.getElementById('recaptcha').value=token;
	   }
    });
});
</script>

       
        
</body>

</html>
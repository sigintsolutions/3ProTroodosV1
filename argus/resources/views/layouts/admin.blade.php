<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Argus Panoptes - Administration</title>
    <link rel="shortcut icon" href="{{ asset('content/image/favicon.png') }}" type="image/png" sizes="36x36">
    <link type="text/css" href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
	<link type="text/css" href="{{ asset('css/Euz_style.css') }}" rel="stylesheet" />
	<link type="text/css" href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet" />
	<link type="text/css" href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet" />
	<link type="text/css" href="{{ asset('css/bootstrap-multiselect.css') }}" rel="stylesheet" />
	
       
	<script src="{{ url('js/bootstrap.min.js') }}"></script>
    <!-- <script src="{{ url('js/exporting.js') }}"></script>
    <script src="{{ url('js/export-data.js') }}"></script> -->
	<script src="{{ url('js/jquery1_1.min.js') }}"></script>
	<script src="{{ url('js/bootstrap-datepicker.min.js') }}"></script> 
	<script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ url('js/bootstrap-multiselect.js') }}"></script>
	<script src="https://unpkg.com/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="{{ url('js/highcharts.js') }}"></script>
<?php /*?>	<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
		<script type="text/javascript" src="https://www.amcharts.com/lib/3/gauge.js"></script>
<?php */?>	<?php /*?><script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css"><?php */?>
    @yield('styles')
</head>
<body>
<?php header('Content-Type: image/gif'); ?>
	<div class="container-fluid euz_minheight">
		<!---- euz_header ----->
		@include('partials.header')
		<!---- euz_menu ----->
		@include('partials.menu')
		<!---- euz_bar ----->
		@yield('content')
    </div>

    <!--Menu page--->
	<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
    </form>
    <!---- euz_footer ----->
	@include('partials.footer')
	<script>
    $(function () 
        {
			@if(request()->is('admin/users') || request()->is('admin/adduser') || request()->is('admin/editUser*'))
            $(".euz_a").css({ "color": "#16313c" });
			$("#Admin").css({ "color": "#3990b3"});
			@elseif(request()->is('admin/emails'))
            $(".euz_a").css({ "color": "#16313c" });
			$("#emailsetting").css({ "color": "#3990b3"});
			@elseif(request()->is('admin/weather') || request()->is('admin/loc'))
            $(".euz_a").css({ "color": "#16313c" });
			$("#wea").css({ "color": "#3990b3"});
			@elseif(request()->is('admin/agents') || request()->is('admin/addagent') || request()->is('admin/editAgent*') || request()->is('admin/gatewaygroups') || request()->is('admin/addgatewaygroup') || request()->is('admin/editGatewaygroup*') || request()->is('admin/sensorhubs') || request()->is('admin/addsensorhub') || request()->is('admin/editSensorhub*') || request()->is('admin/addsensor*') || request()->is('admin/editSensor*') || request()->is('admin/showsensor*') || request()->is('admin/groups*') || request()->is('admin/sensorhubs*') || request()->is('admin/sensors*'))
            $(".euz_a").css({ "color": "#16313c" });
			$("#agent").css({ "color": "#3990b3"});
			@elseif(request()->is('admin/userlog'))
            $(".euz_a").css({ "color": "#16313c" });
			$("#sensor").css({ "color": "#3990b3"});
			@elseif(request()->is('admin/settings'))
            $(".euz_a").css({ "color": "#16313c" });
			$("#setting").css({ "color": "#3990b3"});
			@elseif(request()->is('admin/algorithms') || request()->is('admin/addalgorithm') || request()->is('admin/editAlgorithm*'))
			$(".euz_a").css({ "color": "#16313c" });
			$("#algorithm").css({ "color": "#3990b3"});
			@elseif(request()->is('admin'))
			$(".euz_a").css({ "color": "#16313c" });
			$("#dashboards").css({ "color": "#3990b3"});
			@elseif(request()->is('agent'))
			$(".euz_a").css({ "color": "#16313c" });
			$("#dashboards2").css({ "color": "#3990b3"});
			@elseif(request()->is('agent/profile'))
			$(".euz_a").css({ "color": "#16313c" });
			$("#profile").css({ "color": "#3990b3"});
			@elseif(request()->is('agent/gateway*') || request()->is('agent/sensorhubs*') || request()->is('agent/sensors*'))
			$(".euz_a").css({ "color": "#16313c" });
			$("#gateway").css({ "color": "#3990b3"});
			@elseif(request()->is('agent/userlog'))
            $(".euz_a").css({ "color": "#16313c" });
			$("#sensor").css({ "color": "#3990b3"});
			//@elseif(request()->is('agent/editAlgorithm*'))
			@elseif(request()->is('agent/algorithm') || request()->is('agent/editAlgorithm*'))
			$(".euz_a").css({ "color": "#16313c" });
			$("#algorithm2").css({ "color": "#3990b3"});
			@endif
        });
		$(document).ready(function(){

    $("#txt_date2").datepicker({
        todayBtn:  1,
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#txt_date3').datepicker('setStartDate', minDate);
		var newDate = new Date(selected.date);
		newDate.setDate(newDate.getDate() + 29);
		$('#txt_date3').datepicker('setEndDate', newDate);
    });

    $("#txt_date3").datepicker()
        .on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#txt_date2').datepicker('setEndDate', maxDate);
        });

});
    </script>
	

    
    @yield('scripts')
	<script type="text/javascript">

	$('#antlevel, #Grouplevel').selectpicker();
	$('#agrouplevel').selectpicker();
	$('#senlevel').selectpicker();
	
	</script>
</body>
</html>

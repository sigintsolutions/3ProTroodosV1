<?php //print_r($sensors); ?>
<div class="row">
@if($sensors)
@foreach($sensors as $item)
												<div class="col-md-4 mt-3">
													<div class="shadow-sm p-2 euz_border">
														<p class="euz_b">{{$item->sensor_type}}</p>
														<div id="sens{{$item->sid}}" style="min-width: 100%; height: 300px;margin: 0 auto"></div>
														
													</div>
												</div>
<script type="text/javascript">

// Themes begin
am4core.useTheme(am4themes_kelly);
am4core.useTheme(am4themes_animated);
// Themes end

// create chart
var chart = am4core.create("sens{{$item->sid}}", am4charts.GaugeChart);
chart.innerRadius = am4core.percent(82);

/**
 * Normal axis
 */

var axis = chart.xAxes.push(new am4charts.ValueAxis());
axis.min = 0;
axis.max = 100;
axis.strictMinMax = true;
axis.renderer.radius = am4core.percent(80);
axis.renderer.inside = true;
axis.renderer.line.strokeOpacity = 1;
axis.renderer.ticks.template.disabled = false
axis.renderer.ticks.template.strokeOpacity = 1;
axis.renderer.ticks.template.length = 10;
axis.renderer.grid.template.disabled = true;
axis.renderer.labels.template.radius = 40;
axis.renderer.labels.template.adapter.add("text", function(text) {
  return text + "{{$item->unit}}";
})

/**
 * Axis for ranges
 */

var colorSet = new am4core.ColorSet();

var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
axis2.min = 0;
axis2.max = 100;
axis2.renderer.innerRadius = 10
axis2.strictMinMax = true;
axis2.renderer.labels.template.disabled = true;
axis2.renderer.ticks.template.disabled = true;
axis2.renderer.grid.template.disabled = true;

var range0 = axis2.axisRanges.create();
range0.value = 0;
range0.endValue = 100;
range0.axisFill.fillOpacity = 1;
range0.axisFill.fill = '#d8bf48';

var range1 = axis2.axisRanges.create();
range1.value = <?php echo $item->value ?>;
range1.endValue = 100;
range1.axisFill.fillOpacity = 1;
range1.axisFill.fill = '#00a12a';

/**
 * Label
 */

var label = chart.radarContainer.createChild(am4core.Label);
label.isMeasured = false;
label.fontSize = 25;
label.x = am4core.percent(20);
label.y = am4core.percent(100);
label.horizontalCenter = "middle";
label.verticalCenter = "bottom";
label.text = "<?php echo $item->value ?> {{$item->unit}}";


/**
 * Hand
 */

var hand = chart.hands.push(new am4charts.ClockHand());
hand.axis = axis2;
hand.innerRadius = am4core.percent(20);
hand.startWidth = 10;
hand.pin.disabled = true;
hand.value = {{$item->value}};

hand.events.on("propertychanged", function(ev) {
  range0.endValue = ev.target.value;
  range1.value = ev.target.value;
  axis2.invalidate();
});


</script>
												
												
												@endforeach
												@else
<div class="col-md-12 mt-3">
No Data Found
</div>
												@endif
											</div>

												

	 
	 
	 
	 
	 
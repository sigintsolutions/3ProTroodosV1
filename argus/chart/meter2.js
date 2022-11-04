

// Themes begin
am4core.useTheme(am4themes_kelly);
am4core.useTheme(am4themes_animated);
// Themes end

// create chart
var chart = am4core.create("euz_meter2", am4charts.GaugeChart);
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
  return text + "%";
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

var range4 = axis2.axisRanges.create();
range4.value = 0;
range4.endValue = 50;
range4.axisFill.fillOpacity = 1;
range4.axisFill.fill = '#d84848';

var range5 = axis2.axisRanges.create();
range5.value = 50;
range5.endValue = 100;
range5.axisFill.fillOpacity = 1;
range5.axisFill.fill = '#d87e49';

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
label.text = "11%";


/**
 * Hand
 */

var hand = chart.hands.push(new am4charts.ClockHand());
hand.axis = axis2;
hand.innerRadius = am4core.percent(20);
hand.startWidth = 10;
hand.pin.disabled = true;
hand.value = 11;

hand.events.on("propertychanged", function(ev) {
  range4.endValue = ev.target.value;
  range5.value = ev.target.value;
  axis2.invalidate();
});


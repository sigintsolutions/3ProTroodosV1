

// Themes begin
am4core.useTheme(am4themes_kelly);
am4core.useTheme(am4themes_animated);
// Themes end

// create chart
var chart = am4core.create("euz_meter3", am4charts.GaugeChart);
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

var range6 = axis2.axisRanges.create();
range6.value = 0;
range6.endValue = 50;
range6.axisFill.fillOpacity = 1;
range6.axisFill.fill = '#1fac3b';

var range7 = axis2.axisRanges.create();
range7.value = 50;
range7.endValue = 100;
range7.axisFill.fillOpacity = 1;
range7.axisFill.fill = '#a249c1';

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
label.text = "85%";


/**
 * Hand
 */

var hand = chart.hands.push(new am4charts.ClockHand());
hand.axis = axis2;
hand.innerRadius = am4core.percent(20);
hand.startWidth = 10;
hand.pin.disabled = true;
hand.value = 85;

hand.events.on("propertychanged", function(ev) {
  range6.endValue = ev.target.value;
  range7.value = ev.target.value;
  axis2.invalidate();
});


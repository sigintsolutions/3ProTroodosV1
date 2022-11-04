
// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("euz_activelog", am4charts.PieChart);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
chart.data = [
  {
    user: "Active Login",
    value: loginagents
  },
  {
    user: "Total Agents",
    value: logoutagents
  }
];
chart.radius = am4core.percent(60);
chart.innerRadius = am4core.percent(40);
chart.startAngle = 180;
chart.endAngle = 360;  

var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "value";
series.dataFields.category = "user";

series.slices.template.cornerRadius = 10;
series.slices.template.innerCornerRadius = 7;
series.alignLabels = false;

series.hiddenState.properties.startAngle = 90;
series.hiddenState.properties.endAngle = 90;

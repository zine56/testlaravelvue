<template>
    <div id="chartdiv" style="width: 100%; height: 500px;"></div>
  </template>
  
  <script>
  import * as am5 from "@amcharts/amcharts5";
  import * as am5xy from "@amcharts/amcharts5/xy";
  import am5themes_Animated from "@amcharts/amcharts5/themes/Animated";
  import am5locales_es_ES from "@amcharts/amcharts5/locales/es_ES";

  import axios from 'axios';
  
  export default {
    name: "ChartComponent",
    data() {
        return {
        chart: null,
        root: null,
        series: null,
        sbSeries: null
        };
    },
    mounted() {
      this.createChart();
    },
    methods: {
      createChart() {
        // Create root element
        let root = am5.Root.new("chartdiv");
        root.locale = am5locales_es_ES;

        // Set themes
        root.setThemes([am5themes_Animated.new(root)]);
  
        // Create chart
        let chart = root.container.children.push(
          am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true,
            paddingLeft: 0
          })
        );
  
        // Add cursor
        let cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
          behavior: "none"
        }));
        cursor.lineY.set("visible", false);
  
        // Create axes
        let xAxis = chart.xAxes.push(
          am5xy.DateAxis.new(root, {
            baseInterval: { timeUnit: "day", count: 1 },
            renderer: am5xy.AxisRendererX.new(root, {
              minorGridEnabled: true,
              minGridDistance: 70
            }),
            tooltip: am5.Tooltip.new(root, {})
          })
        );
  
        let yAxis = chart.yAxes.push(
          am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {})
          })
        );

        yAxis.children.push(
            am5.Label.new(root, {
            text: "$ Monto",
            rotation: -90,
            y: am5.percent(50),
            centerX: am5.percent(50),
            centerY: am5.percent(50),
            fontWeight: "bold"
            })
        );

        // Add series
        let series = chart.series.push(
          am5xy.LineSeries.new(root, {
            name: "Series",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            valueXField: "date"
          })
        );
        series.fill = am5.color('#00AEEF'),
        series.fillOpacity = 0.5;
        series.strokeWidth = 2;
        series.strokes.template.set("templateField", "strokeSettings");
        series.fills.template.setAll({
            visible: true,
            fillOpacity: 0.4
        });
  
        let tooltip = series.set("tooltip", am5.Tooltip.new(root, {
          labelText: "{valueY}"
        }));
  
        // this is added in order adapter to be triggered each time position changes
        tooltip.on("pointTo", function () {
          let background = tooltip.get("background");
          background.set("fill", background.get("fill"));
        });
  
        // tooltip background takes color from data item
        tooltip.get("background").adapters.add("fill", function (fill) {
          if (tooltip.dataItem) {
            return tooltip.dataItem.dataContext.color;
          }
          return fill;
        });
  
        
        // Add scrollbar
        let scrollbar = chart.set(
          "scrollbarX",
          am5xy.XYChartScrollbar.new(root, {
            orientation: "horizontal",
            height: 60
          })
        );
  
        let sbDateAxis = scrollbar.chart.xAxes.push(
          am5xy.DateAxis.new(root, {
            baseInterval: {
              timeUnit: "day",
              count: 1
            },
            renderer: am5xy.AxisRendererX.new(root, {})
          })
        );
  
        let sbValueAxis = scrollbar.chart.yAxes.push(
          am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {})
          })
        );
  
        let sbSeries = scrollbar.chart.series.push(
          am5xy.LineSeries.new(root, {
            valueYField: "value",
            valueXField: "date",
            xAxis: sbDateAxis,
            yAxis: sbValueAxis
          })
        );
        
        sbSeries.fills.template.setAll({
            visible: true,
            fillOpacity: 0.4
        });

        // Fetch data from the server
        axios.get('/data')
          .then(response => {
            let data = response.data.map(item => ({
              date: new Date(item.date).getTime(),
              value: parseFloat(item.amount),
            }));

            // Ordenar los datos por fecha
            data.sort((a, b) => a.date - b.date);

            console.log('data',data);
            series.data.setAll(data);
            sbSeries.data.setAll(data);
          })
          .catch(error => {
            console.error(error);
          });
  
        // Make stuff animate on load
        series.appear(1000);
        chart.appear(1000, 100);
  
        // Store chart instance
        this.chart = chart;
        this.root = root;
        this.series = series;
        this.sbSeries = sbSeries;
      },
      updateChart() {
        axios.get('/data')
          .then(response => {
            let data = response.data.map(item => ({
              date: new Date(item.date).getTime(),
              value: parseFloat(item.amount),
            }));

            // Ordenar los datos por fecha
            data.sort((a, b) => a.date - b.date);

            console.log('dataupdate',data);
            this.series.data.setAll(data);
            this.sbSeries.data.setAll(data);
          })
          .catch(error => {
            console.error(error);
          });
      },
      beforeDestroy() {
        if (this.root) {
          this.root.dispose();
        }
      }
    }
  };
  </script>
  
  <style scoped>
  #chartdiv {
    width: 100%;
    height: 500px;
  }
  </style>
  
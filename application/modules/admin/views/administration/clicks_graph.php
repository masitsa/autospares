<style type="text/css">
#bar-chart2{
	height: 283px;
	width: 99.5%;	
}
</style>
<div class="row">
            <div class="col-md-12">

              <!-- Widget -->
              <div class="widget boxed">
                <!-- Widget head -->
                <div class="widget-head">
                  <h4 class="pull-left"><i class="icon-reorder"></i>Click Totals</h4>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="icon-remove"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>             

                <!-- Widget content -->
                <div class="widget-content">
                  <div class="padd">

                    <!-- Bar chart (Blue color). jQuery Flot plugin used. -->
                    <div id="bar-chart2"></div>
                    <hr />

                  </div>
                </div>
                <!-- Widget ends -->

              </div>
            </div>
          </div>
          
<script type="text/javascript">
var config_url = '<?php echo site_url();?>';

function get_date(year, month, day) {
    return new Date(year, month - 1, day).getTime();
}

/* Bar Chart starts */
$.ajax({
	type:'POST',
	url: config_url+"admin/charts/click_totals",
	cache:false,
	contentType: false,
	processData: false,
	dataType: "json",
	success:function(data){
		
		var result_bars = data.bars;
		var result_names = data.names;
		var total_categories = data.total_categories;
		
		var result2 = result_bars.split(',').map(function(item) {
			return parseInt(item, 10);
		});
		
		var names = result_names.split(',');
		
		$(function () {
		
			/* Bar Chart starts */
		
			var d1 = [];
			for (var i = 0; i <= 30; i += 1)
				d1.push([i, parseInt(Math.random() * 30)]);
		
			var d2 = [];
			for (var i = 0; i <= 30; i += 1)
				d2.push([i, parseInt(Math.random() * 30)]);
			
			var d3 = [];
			var ticks = [];
			for(r = 0; r < parseInt(total_categories); r += 1)
			{
				d3.push([r, parseInt(result2[r])]);
				ticks.push([r, names[r]]);
			}
		
			var curr = new Date();
			var day = curr.getDate();
			var month = curr.getMonth()+1;
			var year = curr.getFullYear();

			var stack = 0, bars = true, lines = false, steps = false;
			
			function plotWithOptions() {
				$.plot($("#bar-chart2"), [ d3 ], {
					series: {
						stack: stack,
						lines: { show: lines, fill: true, steps: steps },
						bars: { show: bars, barWidth: 0.8 }
					},
					grid: {
						borderWidth: 0, hoverable: true, color: "#777"
					},
					colors: ["#52b9e9", "#0aa4eb"],
					bars: {
						  show: true,
						  lineWidth: 0,
						  fill: true,
						  fillColor: { colors: [ { opacity: 0.9 }, { opacity: 0.8 } ] }
					},
					xaxis: {axisLabel: "Categories", ticks: ticks},
					yaxis: {axisLabel: "Total Collected", 
						tickFormatter: function (v, axis) {
							return ""+v;
						}
					}

				});
			}
		
			plotWithOptions();
			
			$(".stackControls input").click(function (e) {
				e.preventDefault();
				stack = $(this).val() == "With stacking" ? true : null;
				plotWithOptions();
			});
			$(".graphControls input").click(function (e) {
				e.preventDefault();
				bars = $(this).val().indexOf("Bars") != -1;
				lines = $(this).val().indexOf("Lines") != -1;
				steps = $(this).val().indexOf("steps") != -1;
				plotWithOptions();
			});
		
			/* Bar chart ends */
		
		});
	},
	error: function(xhr, status, error) {
		alert(config_url+"admin/charts/click_totals");
		//alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
	}
});
/* Bar chart ends */
</script>
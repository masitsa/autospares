<div class="widget boxed">
    <div class="widget-head">
        <h4 class="pull-left"><i class="icon-reorder"></i>Spare part additions for the last 7 days</h4>
        <div class="widget-icons pull-right">
            <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
            <a href="#" class="wclose"><i class="icon-remove"></i></a>
        </div>
        <div class="clearfix"></div>
    </div>

<div class="widget-content">
    <div class="padd">
    
        <!-- Curve chart -->
        
        <div id="curve-chart"></div>
        <hr />
        <!-- Hover location -->
        <div id="hoverdata">
            Mouse hovers at
            (<span id="x">0</span>, <span id="y">0</span>). <span id="clickdata"></span>
        </div>          
        
        <!-- Skil this line. <div class="uni"><input id="enableTooltip" type="checkbox">Enable tooltip</div> -->
    </div>
</div>
</div>

<script type="text/javascript">
var config_url = '<?php echo site_url();?>';

function get_date(year, month, day) {
    return new Date(year, month - 1, day).getTime();
}

/* Orders chart starts */
//required variables
var highest_bar;
var active = [], inactive = [];
var current_date;

//get the current day
var curr = new Date();
var day = curr.getDate();
var month = curr.getMonth()+1;
var year = curr.getFullYear();
var current_timestamp = get_date(year, month, day);
var url = config_url+"admin/charts/addition_totals/"+current_timestamp;//alert(url);
	
//get data for the last 7 days
for(r = 0; r < 8; r++)
{
	$.ajax({
		type:'POST',
		url: url,
		cache:false,
		contentType: false,
		processData: false,
		async: false,
		dataType: "json",
		success:function(data){
			
			//add the data to the array
			active.push([current_timestamp, data.active]);
			inactive.push([current_timestamp, data.inactive]);
			
			current_timestamp = current_timestamp - 86400000;
			url = config_url+"admin/charts/addition_totals/"+current_timestamp;
		},
		error: function(xhr, status, error) {
			//alert(url);
			alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
		}
	});
}

//Plot the graph
$(function () {
	
	var plot = $.plot($("#curve-chart"), 
		[
			{
				data: active,
				label: "Active"
			},
			{
				data: inactive, 
				label: "Inactive"
			}
		],
		
		{
		   series: {
			   lines: { show: true, 
						fill: true,
						fillColor: {
						  colors: [{
							opacity: 0.05
						  }, {
							opacity: 0.01
						  }]
					  }
			  },
			   points: { show: true }
		   },
			grid: { hoverable: true, clickable: true, borderWidth:0 },
			xaxis: {mode: "time",timeformat: "%d/%m/%y", axisLabel: "Day"},
			yaxis: {axisLabel: "Total Additions"},
			colors: ["#fa3031", "#54728C", "#f0ad4e"]
		}
	);
	
	function showTooltip(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css( {
			position: 'absolute',
			display: 'none',
			top: y + 5,
			width: 100,
			left: x + 5,
			border: '1px solid #000',
			padding: '2px 8px',
			color: '#ccc',
			'background-color': '#000',
			opacity: 0.9
		}).appendTo("body").fadeIn(200);
	}

	var previousPoint = null;
	$("#curve-chart").bind("plothover", function (event, pos, item) {
		var myDate = new Date(Math.round(pos.x.toFixed(2)));
		var date_display = new Date(myDate.getFullYear(), myDate.getMonth(), myDate.getDate());
					
		$("#x").text(date_display.toString());
		$("#y").text(pos.y.toFixed(2));

			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(2),
						y = item.datapoint[1].toFixed(2);
					y = Math.round(y);
					var myDate = new Date(Math.round(x));
					var date_display = new Date(myDate.getFullYear(), myDate.getMonth(), myDate.getDate());
					
					showTooltip(item.pageX, item.pageY, item.series.label + " of " + date_display.toString() + " = " + y);
				}
			}
			else {
				$("#tooltip").remove();
				previousPoint = null;            
			}
	}); 

	$("#curve-chart").bind("plotclick", function (event, pos, item) {
		if (item) {
			var x = item.datapoint[0].toFixed(2),
				y = item.datapoint[1].toFixed(2);
			y = Math.round(y);
			var myDate = new Date(Math.round(x));
			var date_display = new Date(myDate.getFullYear(), myDate.getMonth(), myDate.getDate());
					
			$("#clickdata").text("You clicked " + y + " in " + item.series.label + ".");
			plot.highlight(item.series, item.datapoint);
		}
	});

});
/* Patients chart ends */
</script>
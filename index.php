<?php


$statecode=21;

if(isset($_GET['state'])){

	$statecode=intval($_GET['state']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID-19</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/bootstrap.min.css">

  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <style type="text/css">
    	@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap');
    	*{
 		   font-family: 'Nunito', sans-serif;
	    }

	    #piechart{
	    	width: 1000px;
	    	height: 500px;
	    }

	    @media only screen and (max-width: 768px) {

	    	#piechart{
	    		width: 400px !important;
	    		margin-left: -80%;
	    	}
		  
		}

    </style>
	
</head>

<body>


	<div class="container-fluid mt-5">
		<h3 class="mt-5 text-warning text-center">COVID-19 STATISTICS</h3>

		<?php

			$apidata=file_get_contents('https://data.covid19india.org/data.json');
			$array=json_decode($apidata,true);
			echo "<pre>";
			// print_r($array['statewise'][21]);
			echo "</pre>";

		?>
		<form method="get" class="text-center">
		<select name="state" class="" onchange="this.form.submit();">
			<?php
				for($i=1;$i<count($array['statewise']);$i++){
				 if($i==$statecode){
			?>

				<option selected value="<?php echo $i; ?>"><?php echo $array['statewise'][$i]['state']; ?></option>
			<?php
					}
					else{
						?>
						<option  value="<?php echo $i; ?>"><?php echo $array['statewise'][$i]['state']; ?></option>
						<?php
					}
				}
			?>
			
		</select>
		</form>

        <div class="d-flex justify-content-center" >
		 <div id="piechart" class="im-fluid"></div>
        </div>
	

	</div>

	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['COVID-19', 'Real data'],
          ['Active',<?php echo $array['statewise'][$statecode]['active']; ?>],
          ['Recovered', <?php echo $array['statewise'][$statecode]['recovered']; ?>],
          ['Deaths', <?php echo $array['statewise'][$statecode]['deaths']; ?>]
        ]);

        var options = {
          title: '<?php echo $array['statewise'][$statecode]['state']; ?>'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

    </script>
	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="asset/bootstrap.min.js"></script>

</body>
</html>
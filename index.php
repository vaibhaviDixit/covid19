<?php


$statecode=21;
$countrycode=94;
$india=94;

if(isset($_GET['state'])){

	$statecode=intval($_GET['state']);
}
if(isset($_GET['country'])){
	$countrycode=intval($_GET['country']);
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
  	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" />
    
    <style type="text/css">
    	@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap');
    	*{
 		   font-family: 'Nunito', sans-serif;
	    }

	    body{
	    	background-color: #9772FB;
	    }
	    #piechart{
	    	position: absolute;
	    	top: 0;
	    	left: 0;
	    	width: 100%;
	    	height: 100%;
	    }

	    #chart_wrap{
	    	position: relative;
	    	padding-bottom: 100%;
	    	height: 0;
	    	overflow: hidden;
	    	box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
		border-radius: 10px;
	    }
	    .bg-1{
	    	background-color: #FF4000;
	    }
	    .bg-2{
	    	background-color: #76ff7a;
	    }
	    .bg-3{
	    	background-color: #ffa07a;
	    }
	    .bg-4{
	    	background-color: #9acd32;
	    }
	    .columns>div{
			margin-bottom: 5px;
		    font-size: 15px;
		    padding: 2px;
		    margin-right: 4px;
		    width: 80px;
		    height: auto;
		    border-radius: 10px;
		    box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;
	    }
	    .rotate{
	    	 animation: rotation 2s infinite linear;
	    }
	    select{
	    	width: 35vw !important;
	    }
	    .form-select-sm {
	    	font-size: 15px !important;
		    border: none;
	    }
	    .subtitle{
	    	width: 115px;
	    }
	    .chosen-container{
	    	width: 150px !important;
	    	font-size: 16px;
	    }
	    @keyframes rotation {
		  from {
		    transform: rotate(0deg);
		  }
		  to {
		    transform: rotate(359deg);
		  }
		}

    </style>
	
</head>

<body>


	<div class="container-fluid mt-5">
		<?php

		$arrContextOptions=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);

			$apidata=file_get_contents('https://data.covid19india.org/data.json',false, stream_context_create($arrContextOptions));
			$array=json_decode($apidata,true);


			$countryapi=file_get_contents('https://corona.lmao.ninja/v2/countries',false, stream_context_create($arrContextOptions));
			$countrydata=json_decode($countryapi,true);
			echo "<pre>";
			// print_r($countrydata);
			echo "</pre>";
			

		?>

			<div class="text-center">
				<div class="d-flex flex-wrap align-items-center justify-content-center " >
					<img src="asset/covid.png" width="50px" height="50px" class="rotate">

	         <dt class="me-2" style="font-size: 16px; line-height: 32px;"><?php echo 'COVID-19 Cases In ';
	         	
			      	if(isset($_GET['state'])){
			      		echo $array['statewise'][$statecode]['state'];
			      	}
			      	else{
			      		echo $countrydata[$countrycode]['country'];
			      	}
			     ?></dt>
	         </div>
	     </div>


		<div class="d-flex flex-wrap justify-content-center align-items-center">
			<!-- country start -->
			<div class="mx-2 mt-1">

				<form method="get">
				<select name="country" class="form-select form-select-sm selectList" onchange="this.form.submit();">
					<?php
						for($i=1;$i<count($countrydata);$i++){
						 if($i==$countrycode){
					?>

						<option selected value="<?php echo $i; ?>"><?php echo $countrydata[$i]['country']; ?></option>
					<?php
							}
							else{
								?>
								<option  value="<?php echo $i; ?>"><?php echo $countrydata[$i]['country']; ?></option>
								<?php
							}
						}
					?>
					
				</select>
				</form>
			</div>
			<!-- country ends -->

			<?php
				
				if(intval($countrycode)==$india){
					?>

				<!-- state start -->
							<div class="mx-2 mt-1 " id="statesChooser">
								<form method="get">
								<select name="state" class="form-select form-select-sm selectList" onchange="this.form.submit();">
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
							</div>
							<!-- state ends -->

				<?php		
					}

			?>
			

		</div>
		<!--  -->

		<!--  -->
			<div class="container mt-3 mb-3 text-center">
			  <div class="d-flex justify-content-center columns flex-wrap">
			    <div class=" bg-1">
			      <p class=" text-capitalize text-center mt-2">active <br/>

			      	<?php 
			      	if(isset($_GET['state'])){
			      		echo $array['statewise'][$statecode]['active'];
			      	}
			      	else{
			      		echo $countrydata[$countrycode]['active'];
			      	}

			      	 ?></p>
			    </div>
			    <div class="  bg-2">
			       <p class="text-capitalize text-center mt-2">recovered <br/>

			       		<?php 
			      	if(isset($_GET['state'])){
			      		echo $array['statewise'][$statecode]['recovered'];
			      	}
			      	else{
			      		echo $countrydata[$countrycode]['recovered'];
			      	}

			      	 ?>

			     </p>
			    </div>
			    <div class=" bg-3">
			       <p class="text-capitalize text-center mt-2">deaths <br/>

			       	<?php 
			      	if(isset($_GET['state'])){
			      		echo $array['statewise'][$statecode]['deaths'];
			      	}
			      	else{
			      		echo $countrydata[$countrycode]['deaths'];
			      	}

			      	 ?></p>
			    </div>
			   

			  </div>
			</div>
		<!--  -->
        <div class="d-flex justify-content-center" id="chart_wrap">
		 <div id="piechart" class="im-fluid"></div>
        </div>

	<!--  -->

	</div>

	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['COVID-19', 'Real data'],
          ['Recovered',	<?php 
			      	if(isset($_GET['state'])){
			      		echo $array['statewise'][$statecode]['recovered'];
			      	}
			      	else{
			      		echo $countrydata[$countrycode]['recovered'];
			      	} ?>
],
          ['Active',	<?php 
			      	if(isset($_GET['state'])){
			      		echo $array['statewise'][$statecode]['active'];
			      	}
			      	else{
			      		echo $countrydata[$countrycode]['active'];
			      	}?>
],
          ['Deaths', 	<?php 
			      	if(isset($_GET['state'])){
			      		echo $array['statewise'][$statecode]['deaths'];
			      	}
			      	else{
			      		echo $countrydata[$countrycode]['deaths'];
			      	}?>
]
        ]);

        var options = {
          width:window.innerWidth,
          height:'520px',
          is3D: true,
          colors: ['#00a884', '#FF0000', '#D3D3D3']
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

      window.onresize = function(event) {
    	drawChart();
	  };


    </script>
	
	
	<script src="asset/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" ></script>

	<script type="text/javascript">
		jQuery('.selectList').chosen();
	</script>

</body>
</html>



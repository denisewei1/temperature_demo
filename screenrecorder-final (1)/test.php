<html>

<head>
<script>
function display()
{
window.open('show.php');
}

</script>

</head>

<body>


<p> 
<a href="test.php?action=update">Update DataBase</a>

</p>

<p> <a href="test.php?action=PlotView">Click to Generate Plot View</a>
<p> <a onclick="display(this)">Click to View the Plot </a>
<form action ='test.php?action=PlotView' method='GET'>
City: 
<input type="text" name="City" />
<br />
Bigger Than:
<input type="text" name="Value" />
<br />
<input type="submit" value="Submit" />
</form>
<br />






<?php
include("pChart/pData.class");   
include("pChart/pChart.class");   

$func=$_GET['action'];
if ($func=='update'){
	$con = mysql_connect("localhost","root");
	mysql_query("CREATE DATABASE IF NOT EXISTS my_db",$con);
	mysql_select_db("my_db", $con);
	mysql_query('use my_db',$con);
	mysql_query('drop table if EXISTS Persons',$con);
	mysql_query("CREATE TABLE Persons(
													Id_P int,
													LastName varchar(255),
													FirstName varchar(255),
													Address varchar(255),
													City varchar(255)
													)",$con);
													

	
	//$con = mysql_connect("localhost","root");
	$num=0;
	$data=mysql_query("select * from Persons",$con);
	$info = mysql_fetch_array( $data );
	 while($info = mysql_fetch_array( $data )) 
		{ 
			$num=$num+1;
		} 
	 if (!$num){
		for ($i=0; $i<=40; $i++)
		{
		  
		  $a=rand(10,40);
		  mysql_query("INSERT INTO Persons(Id_P,LastName,FirstName,Address,City)
						VALUES('$a','Devin','X','xusihong649897@163.com','SZ')",$con);
						
		  $a=rand(10,40);
		  mysql_query("INSERT INTO Persons(Id_P,LastName,FirstName,Address,City)
						VALUES('$a','Devin','X','xusihong649897@163.com','SH')",$con);
		}
	}
	mysql_close($con);
	}
	if ($_GET['City'] or $_GET['Value'] )
	{
	    $city=$_GET['City'];
		$big=$_GET['Value'];
		$con = mysql_connect("localhost","root") or die(mysql_error());
		mysql_select_db("my_db", $con);
		$data=mysql_query("select * from Persons",$con) or die(mysql_error());
		$info = mysql_fetch_array( $data );
		$ArData=array();
		$num=0;
		while($info = mysql_fetch_array( $data )) 
		{ 
		    if($big<$info['Id_P'] && $info['City']==$city){
			$ArData[]=$info['Id_P'];
			$num=$num+1;
             }			
		} 
		foreach ($ArData as $value){
		//	echo $value;
		//	echo '  ';
		}
	
		$DataSet = new pData;   
		$DataSet->AddPoint($ArData);   
		$DataSet->AddSerie();   
		$DataSet->SetSerieName("Sample data","Serie1");   
		  
		// Initialise the graph   
		$Test = new pChart(700,230);   
		$Test->setFontProperties("Fonts/tahoma.ttf",10);   
		$Test->setGraphArea(40,30,680,200);   
		$Test->drawGraphArea(252,252,252);   
		$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);   
		$Test->drawGrid(4,TRUE,230,230,230,255);  
        #$Test->drawText(250,55,"Average temperature",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));
        #$Test->setAxisName(0,"Temperatures");		
		  
		// Draw the line graph   
		$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());   
		$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);   
		  
		// Finish the graph   
		$Test->setFontProperties("Fonts/tahoma.ttf",8);   
		$Test->drawLegend(45,35,$DataSet->GetDataDescription(),255,255,255);   
		$Test->setFontProperties("Fonts/tahoma.ttf",10);   
		$Test->drawTitle(60,22,"My pretty graph",50,50,50,585);   
		$Test->Render("Naked.png");
	
	}
  

  
// Dataset definition    


?>


</body>
</html>
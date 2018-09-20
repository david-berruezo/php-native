<?php
include("csv.class.php");
include("dump.php"); // beautified print_r function
/*************************************************************************/
//		EXAMPLES FOR INPUT
/*************************************************************************/
$MyCsv = new CSV();

//------------------------------------------------------------------------------------------
// Convert csv table content in PORTRAIT form to  2-dimensional array
//------------------------------------------------------------------------------------------
$MyCsv->SetInputFilename("InputPortrait.csv");
$MyCsv->SetInputTableType("P");
$ContentArray = $MyCsv->Csv2Array();


// Show in web page
echo '<div style="background-color:#000;padding:10px;color:#FFF;">This is the imported PORTRAIT table content in array form <br>';
dump($ContentArray);
echo "</div>";

//------------------------------------------------------------------------------------------
// Convert csv table content in LANDSCAPE form to  2-dimensional array
//------------------------------------------------------------------------------------------
$MyCsv->SetInputFilename("InputLandscape.csv");
$MyCsv->SetInputTableType("L");
$ContentArray = $MyCsv->Csv2Array();

// Show in web page
echo '<div style="background-color:#F00;padding:10px;color:#FFF;">This is the imported LANDSCAPE table content in array form <br>';
dump($ContentArray);
echo "</div>";


/*************************************************************************/
//		EXAMPLES FOR OUTPUT
/*************************************************************************/
//------------------------------------------------------------------------------------------
// Prepare 2 dimensional array
//------------------------------------------------------------------------------------------
$My2DimArray = array();
for( $i=0; $i<6; $i++){
	for ($j =0 ; $j<10; $j++){
		$My2DimArray["Label ".$i][$j] = "Cell $i,$j";
	}
}
echo '<div style="background-color:#00F;padding:10px;color:#FFF;">This is the array content which should be exported in both PORTRAIT  and LANDSCAPE form<br>';
dump($My2DimArray);
echo "</div>";
//------------------------------------------------------------------------------------------
// Write  csv content in portrait form
//------------------------------------------------------------------------------------------
$MyCsv->SetOutputArray($My2DimArray);
$MyCsv->SetOutputFilename("OutputPortrait.csv");
$MyCsv->SetOutputTableType("P");
$MyCsv->SetOutputNewLine(2);
$MyCsv->Array2Csv();
//------------------------------------------------------------------------------------------
// Write csv content in landscape form
//------------------------------------------------------------------------------------------
$MyCsv->SetOutputFilename("OutputLandscape.csv");
$MyCsv->SetOutputTableType("L");
$MyCsv->Array2Csv();



?>


<?php
/**
	Class name 	: 	CSV
	Written by	:	Selim ACAR
    Date			:	29.07.2011
    Version 		:	1.0
	Copyright 	:	Selim ACAR
	For Suggestions :	selimacar@hotmail.com
	Description	:	A class for simple CSV import and export.
							
				With this class you can 
				
				- import CSV content in both portrait and landscape format from files and convert it
				  to an 2-dimensional array.
				  
				- export the content of a 2-dimensional array a csv file in both portrait and landscape format
				
				- choose between different options like new line character or input line size.
				  (see comments for variables and methods)
				  
				! This class may contain some errors. But it is tested for both input and output for both portrait and landscape
				  csv content successfully. (See the index.php file for examples)
	
	
				THIS PROGRAM IS FREE SOFTWARE: you can redistribute it and/or modify
				it under the terms of the GNU General Public License as published by
				the Free Software Foundation, either version 1,2,3 of the License, or
				(at your option) any later version.

				This program is distributed in the hope that it will be useful,
				but WITHOUT ANY WARRANTY; without even the implied warranty of
				MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
class CSV
{
    /**
     * Complete path for input file
	 * Default : default.csv
     * @var  string    $CsvFileIn
     */	
	var $CsvFileIn		= NULL;
    /**
     * Type of the input table
	 * Possible values : P| L 	 (P: portrait, L : landscape)
	 * Default  : P
     *
	 * @var  char   $InputTableType
     */
	var $InputTableType		= NULL;
    /**
     * Variable to store the csv input file content for parsing within this class
	 * or later use
     *
	 * @var  string   $InputLineSize
     */
	var $InputFileContent 	= '';
    /**
     * Delimiter for the cells in the input csv file content
     * Default : ';'
	 * @var  string  $InputCsvSeparator
     */	
	var $InputCsvSeparator 	= NULL;
	
    /**
     * Maximal number of characters,which should a line in the input file contain
     * Can be set to another value via setter function 
	 *
	 * @var  integer $InputLineSize
     */		
	var $InputLineSize			= 512;

    /**
     *  Complete path for output file
     *
     * @var  string   $CsvFileOut  
     */		
	var $CsvFileOut					= NULL;
    /**
     * Array, which contains 2 dimensional data for output
     *
     * @var  array    $OutputArray  
     */
    var $OutputArray				= array();
    /**
     * Type of the output csv table. 
	 * Possible values : P| L 	 (P: portrait, L : landscape)
	 * Default  : P
     *
     * @var  char   $OutputTableType  
     */	
	var $OutputTableType		= NULL;
    /**
     * Type of the new line separator for output file. 
	 * Possible values : See $NewLineSeparators
	 * Default value :  \r\n   (CR+LF)
     *
     * @var  string   $OutputNewLine  
     */
	var $OutputNewLine 			= NULL;
	var $NewLineSeparators	= array(	
																0=>"\r", 		// CR
																1=>"\n",		// LF
																2=>"\r\n",	// CR+LF
																3=>"\n\r"		// LF+CR
															);
    /**
     * Delimiter for output csv file
	 * Default : ';'
     * @var  string    $OutputCsvSeparator
     */																
	var $OutputCsvSeparator 	= NULL;
    
	/**
     * Constructor 
     * 
	 * Set some default values
     */
	 function CSV(){
		$this->InputCsvSeparator = ';';
		$this->OutputCsvSeparator = ';';
		$this->OutputNewLine = 2;
		$this->CsvFileIn = 'default_in.csv';
		$this->CsvFileIn = 'default_out.csv';
		$this->SetInputTableType(); 
		$this->SetOutputTableType(); // Set default output table type 'P'
	 }
											
    /**
     * read a txt based file and return as a string
	 *  [NOT USED] alternatively the function FileToLines is used
     */
	function ReadFile(){
	
		if(is_file($this->CsvFileIn)){
			// Set default output file name
			$this->SetOutputFilename (str_replace('.csv', '_out.csv', $Filename));
			// read the file content
			$Filesize = filesize($this->CsvFileIn);
			$FileHandler = fopen($this->CsvFileIn, "r");
			$FileContent = @fread($FileHandler , $Filesize);
			$this->InputFileContent = trim($FileContent) ;
		}
		else {
			die("File content could not be read.");
		}
	}
	/**
	 * Writes a file on the disk
	 * 
	 * @param	string	$FileContent The file content to be written
	*/
	function WriteFile($FileContent){
		$FileContent = trim($FileContent);
		$FileHandler = fopen($this->CsvFileOut, "w");
		if(fwrite($FileHandler ,$FileContent, strlen($FileContent)))return true;
		else	return false;
	}
	
	/**
	 *  Converts a 2-dimensional array into csv txt
	 *  and write into a file on the disk.
	 * 
	*/
function Array2Csv(){

	$CsvContent = '';
	$NRows = count($this->OutputArray);
	// Check for appropiate content
	

	if($NRows <2) {echo "No content"; return false;}
	
	// Prepare CSV content
	if($this->OutputTableType == 'P'){
		$Labels = array_keys($this->OutputArray);
		$NColumns = count($Labels);
		$NRows = count($this->OutputArray[$Labels[0]]);
		// The Labels row
		$CsvContent  = implode($this->OutputCsvSeparator, $Labels) . $this->OutputNewLine;
		for($i=0;$i<$NRows;$i++){
			$Line = '';
			for($j=0;$j<$NColumns-1;$j++){

				$Cell = $this->OutputArray[$Labels[$j]][$i];
				$Line .= $Cell.$this->OutputCsvSeparator;
			}
			$Cell = $this->OutputArray[$Labels[$NColumns-1]][$i];
			$Line .= $Cell.$this->OutputNewLine;
			$CsvContent .= $Line;
		}
	}
	else if( $this->OutputTableType == 'L'){
		foreach($this->OutputArray as $Key => $Row){
			$Line = $Key . $this->OutputCsvSeparator;
			$LastCell = array_pop($Row);
			foreach($Row as  $Cell)
				$Line .= $Cell.$this->OutputCsvSeparator;
			$CsvContent .= $Line .$LastCell.$this->OutputNewLine;
		}
	}
	//Write  the csv file
	return $this->WriteFile($CsvContent); // returns true or false
}
	/**
	 *  Explode the csv file content by lines 
	 * 
	*/	
	function FileToLines(){
		//Determine which is the new line characters used in the file
		if ($fp=fopen($this->CsvFileIn,"r")) {
			$Lines = array();
			for ($i=0;!feof($fp);$i++) {
				$Line = trim(fgets( $fp, $this->InputLineSize ));
				if(strlen($Line) >0 and $Line!='')$Lines[] = $Line;
			}
			fclose($fp);
			return $Lines;
		}
		else 
			return false;
	}
	
	/**
	 * Reads the input file content and convert it 
	 * into a 2-dimensional array
	 * @param	string $Filename : Input file path if not set before.
	*/		
	function Csv2Array($Filename =''){
			// set input file name
			if(is_file($Filename))
				$this->SetInputFilename($Filename);
			
			// Read the file content
			// $this->ReadFile();
			$Lines = $this->FileToLines();
			if(count($Lines)> 0){
				$ContentArray = array();
				//---------------------------------------------------------------
				// Proceed for portrait typed table
				//---------------------------------------------------------------
				if($this->InputTableType == 'P'){
					$tmp = array_shift($Lines);
					$Labels = explode($this->InputCsvSeparator, $tmp);
					$NLabels = count($Labels);
					$RowId = 0;
					foreach($Lines as $Line){
						$RowData = explode($this->InputCsvSeparator, $Line);
						$NColumns = count($RowData);
						// [ENHANCEMENT] Here can a code  be added which checks the number of labels and number of cells for each row.
						// if they are not the same then break the script and show failure message
						for($i=0; $i<$NColumns;$i++){
							$ContentArray[$Labels[$i]][$RowId] = trim($RowData[$i]);
						}
						$RowId++;
					}
				} 
				//---------------------------------------------------------------
				// Proceed for landscape typed table
				//---------------------------------------------------------------
				else if($this->InputTableType == 'L'){
					$NLabels = count($Lines);
					foreach ($Lines as $Line){
						$RowData = explode($this->InputCsvSeparator, $Line);
						$Label = trim(array_shift($RowData));
						$NColumns = count($RowData);
						// [ENHANCEMENT] Here can a code  be added which checks the number of labels and number of cells for each row.
						// if they are not the same then break the script and show failure message
						for($i=0;$i<$NColumns;$i++)
							$ContentArray[$Label][$i] = trim($RowData[$i]); 
					}
				} // close else if for landscape table 
				return $ContentArray;
			}
			
	} // end of the function Csv2Array()
	
	
	/**
	 * Sets the full path of the input file
	 * @param	string	$Filename The full file path.
	*/	
	function SetInputFilename($Filename){
		$this->CsvFileIn = $Filename;
	}

	/**
	 * Sets the full path for output file
	 * @param	string	$Filename The full path for the output file
	*/	
	function SetOutputFilename($Filename){
		$this->CsvFileOut = $Filename ;
	}
	/**
	 * Sets the table type of the input file content
	 * @param char $Type
	*/	
	function SetInputTableType($Type='P'){
		$this->InputTableType = $Type;
	}
	/**
	 * Sets the table type for the output file content
	 * @param char $Type
	*/
	function SetOutputTableType($Type='P'){
		$this->OutputTableType = $Type;
	}	
	/**
	 *	Sets the output array
	 * 
	 * @param array $ContentArray
	*/	
	function SetOutputArray($ContentArray){
		if(count($ContentArray) > 0)
			$this->OutputArray = $ContentArray;
	}
	/**
	 * Sets the new line character for output file
	 *
	 * @param id $ID	: see $NewLineSeparators 
	*/	
	function SetOutputNewLine($ID){
		$this->OutputNewLine = $this->NewLineSeparators[$ID];
	}
	/**
	 * Sets the input line size
	 *
	 * @param integer $Size  
	*/	
	function SetInputLineSize($Size){
		$this->InputLineSize = $Size;
	}		
} // end of the 'csv' class
?>
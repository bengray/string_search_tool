<?php
	
/**
 * string_search_tool.php
 *
 * Searches a directory and all its children for files which contain a string,
 * then outputs the file path and line number of each occurrence.
 *
 * @author     Ben Gray
 *
 */

$searchString = "foo"; // The string you're searching for. CASE INSENSITIVE.

$extensionsToInclude = array("php"); // Array of file extensions to inclue (speeds up the search significantly)

$directoryToSearch = dirname(__FILE__); // Directory you're looking in. 


///////////////////////////////////////
////                               ////
////  DO NOT EDIT BELOW THIS LINE  ////
////                               ////
///////////////////////////////////////


$directory = new RecursiveDirectoryIterator($directoryToSearch);

$iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);

$count = 0;

echo "<table border='1'>";

echo "<th>File Name</th><th>Line Number</th>";

foreach ($iterator as $file) {
	
	$isFile = $file->isFile();
	
	$fileExtension = $file->getExtension();
	
	if($isFile && in_array($fileExtension, $extensionsToInclude) && $file !== __FILE__) {
	    	    
		foreach(new SplFileObject($file) as $lineNumber => $lineContent) {
	    
			if(false !== stripos($lineContent, $searchString)) {
						
				echo "<tr><td>" . $file . "</td><td>" . ($lineNumber + 1). "</td></tr>";
    			
				$count++;
		
			}

			}

	}
    
}

echo "String searched for: " . $searchString . "<br />";

echo "Total instances of string: " . $count;

echo "</table>";

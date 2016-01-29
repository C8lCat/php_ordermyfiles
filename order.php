<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> order my files </title>
		<link href='https://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Source+Code+Pro' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/dateiordnung.css">
    </head> 
	<body> 
	
<div class="header">
	<div class="container">
		<h1>Order my files</h1>
			<p>will be executed @</p> 
			<div class="code">
			<?php
			//identify folder name
			  $pfad_info = pathinfo($_SERVER["SCRIPT_FILENAME"]);
			  $pfad = $pfad_info["dirname"];
			  $array = explode("/",$pfad);
			  $ordnername = $array[count($array)-1];
			  echo "$ordnername/to_order"; 
			?>
			</div>
			<p>in</p>
			<div class="code">
			<?php
			echo $pfad;
			?>
			</div>
			
	</div>
</div>

<div class="container"> 
	 <div class="row">
		 <div class="col-sm-12 text-center">			
			<form method="post">
				<input type="submit" class="btn btn-info btn-lg" value="Order!" name="sent">
			</form>			
		</div>
	</div>
</div>


<?php
if(isset($_POST['sent'])){
?>
<div class="jumbotron">
	<div class="container">
		<?php
		// Filter
		
		$dir    = 'to_order';
		
		foreach (new DirectoryIterator($dir) as $file) { //iterate through folder $
			if (! $file->isDot()) { 
				
				$file = $file->getFilename();
				
				$filter = substr($file,-5); //take only the last 5 characters of each file
				
				
				// if(preg_match( "/ ??? /" ,$filter)  -- to change the comparing files, enter instead of ??? the file ending you want, for example .gif
				// to add: don't forget the | (or-Sign), for example |.gif
				
				if(preg_match("/.php|.html|.js|.json/",$filter)) // compare with $filter
				{
					$internetfiles[] = $file;			// if true then save in array
				}

				if(preg_match("/.gif|.jpe?g|.png|.bmp/",$filter)) 
				{
					$imagefiles[] = $file;			
				}
				
				if(preg_match("/.txt|.rtf|.wri|.pdf/",$filter)) 
				{
					$textfiles[] = $file;			
				}
				
				if(preg_match("/.exe/",$filter)) 
				{
					$programfiles[] = $file;			
				}
				
				if(preg_match("/.wav|.mid|.mp3|.ogg|.mod|.wma/",$filter)) 
				{
					$soundfiles[] = $file;			
				}
				
				if(preg_match("/.avi|.mpeg|.mpg|.flv|.wmv/",$filter)) 
				{
					$filmfiles[] = $file;			
				}

				if(preg_match("/.zip|.rar/",$filter)) 
				{
					$zipfiles[] = $file;			
				}
				
				if (is_dir($dir.'/'.$file)){
					$ordner[] = $file;
				}
				
				if(!preg_match("/.php|.html|.js|.json|.gif|.jpe?g|.png|.bmp|.txt|.rtf|.wri|.pdf|.exe|.wav|.mid|.mp3|.ogg|.mod|.wma|.zip|.rar/",$filter) && !(is_dir($dir.'/'.$file))) //add here also your added filetype to not show up twice
				{
					$allotherfiles[] = $file;			
				}
			}
		}


		//Display-function
		
		if (!is_dir("ordered")){ // if there is no folder, make one
			mkdir("ordered");
		}
		
		
		function Ausgabe($whatfile, $whatfilevariable){ //Header, array with the files
			
			echo "<h3>". $whatfile ."</h3>"; //Header

			
		if (isset($whatfilevariable)){ //if there is something in the array
			
			if (!is_dir("ordered/$whatfile")){ //if there isn't a destination folder
				mkdir("ordered/$whatfile"); // create destination folder
			}
				
			foreach ($whatfilevariable as $echovariable){ //iterate through Array
				
			echo $echovariable; // echo each file
			echo "<br>";
			
			$old = "to_order/$echovariable"; //"old" directory
			$new = "ordered/$whatfile/$echovariable"; //"new" directory
			rename($old,$new) or die ("file couldn't be moved");//move from old to new directory

		}}
		
		else {
			echo "<span>There is no ". $whatfile ."</span>"; //No file found
		}
		}

		
		// Display with Bootstraps Grid
		?>
		  <div class="row">
			<div class="col-sm-4">
				<?php Ausgabe("folder", $ordner); ?>
			</div>
			<div class="col-sm-4">
				<?php Ausgabe("text files", $textfiles); ?>
			</div>
			<div class="col-sm-4">
				<?php Ausgabe("image files", $imagefiles); ?>
			</div>
		  </div>
		  
		<hr>
		  
		  <div class="row">
			<div class="col-sm-4">
				<?php Ausgabe("music files", $soundfiles); ?>
			</div>
			<div class="col-sm-4">
				<?php Ausgabe("movie files", $filmfiles); ?>
			</div>
			<div class="col-sm-4">
				<?php Ausgabe("internet files", $internetfiles); ?>
			</div>
		  </div>
		  
		  
		 <hr>
		 
		  <div class="row">
			<div class="col-sm-4">
				<?php Ausgabe("program files", $programfiles); ?>
			</div>
			<div class="col-sm-4">
				<?php Ausgabe("zip files", $zipfiles); ?>
			</div>
			<div class="col-sm-4">
				<?php Ausgabe("other files", $allotherfiles); ?>
			</div>
		  </div>

	</div>
</div>
<?php } ?>
 </body>
</html>
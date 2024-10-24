<!DOCTYPE html>
<html>
    <head>
        <title>minify</title>
        <meta charset="UTF-8">
       

		<script src="https://code.jquery.com/jquery-3.5.0.js"></script>


        <style>
        body{ margin: 0; background-color: #D1D1D1; font-family: monospace;}
		textarea{ width: 600px; height: 40vh; border: 2px solid black; font-family: monospace; color: black; margin: 25vh 0; padding: 20px; box-sizing: border-box; resize:none; background-color: #D1D1D1;}
		input{ float: right; position: absolute; margin-top:43vh; margin-left:30px; padding: 10px; background-color: #D1D1D1; border: 2px solid black; color: black;}
		input:hover{ background-color: black; color: white; cursor: pointer;}

		#dlbutton {
			display: inline-block;
			background-color: #4CAF50;
			color: white;
			text-align: center;
			text-decoration: none;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
			border-radius: 4px;
			padding: 15px;
		}
		html, body, #results {
    height: 100%;
}

#results {
    display: flex;
    align-items: center;
    justify-content: center;
}
		
		</style>
    </head>
    <body>
		<img src="minify.png" width="120" style="position: absolute; left: 10px; top: 10px;">
		<div id="results" align="center">
			<?php

				// MINIFY HTML CODE

				// get original input
				$copy = $_POST["original"];

				// get file size of original input
				$original_size = strlen($copy);

				


				//trim space from end
				$copy = rtrim($copy);
				//replace carriage returns
				$copy = preg_replace('#\r#', '', $copy);
				//replace newlines
				//$copy = preg_replace('#\n#', '', $copy);
				//replace tabs
				$copy = preg_replace('#\t#', '', $copy);
				//replace multiple spaces with single space
				$copy = preg_replace('/[ ]{2,}/', ' ',$copy);
				// replace multiple new lines with single new line
				$copy = preg_replace('/\n{2,}/', "\n",$copy);
				// trim space from start of line
				$copy = preg_replace('/^\s+/m', '', $copy);
				
				// Insert break before a HTML comment
				$copy = preg_replace("#<!--#", "\n<!--", $copy);
				// Insert break after a HTML comment
				$copy = preg_replace("#-->#", "-->\n", $copy);
				// Insert break before a CSS/JS comment
				$copy = preg_replace("#-->\s*<#", "-->\n<", $copy);
				// Insert break after a CSS/JS comment
				$copy = preg_replace("#>\s*<!--#", ">\n<!--", $copy);
				// Close empty tags
				$copy = preg_replace('/> </', '><', $copy);



				// get file size of minified input
				$minified_size = strlen($copy);


				function deleteFile($filename){
					unlink($filename);
				}
				

			?>
			<?php
				// save the minified code to a file
				$randomFilename = uniqid();
				$myfile = fopen("minified-files/" . $randomFilename . ".html", "w") or die("Unable to open file!");
				fwrite($myfile, $copy);
				fclose($myfile);

				// download button for file
				echo "<table cellpadding='10'><tr><td>Original Size: " . $original_size . " bytes<br>Minified Size: " . $minified_size . " bytes<br>Compression: " . round(($minified_size / $original_size) * 100, 2) . "%</td><td><a id='dlbutton' href='minified-files/" . $randomFilename . ".html' download>Download Minified File</a></td></tr></table>";
			?> 
		</div>
		
		<!-- jQuery script to delete the file after it is downloaded -->
		<script>
			// delete the created file after it is downloaded
			$(document).ready(function(){				
				console.log("ready");
				$('#dlbutton').click(function(){
					// get the latest file created
					var latestFile = '<?php echo "minified-files/" . $randomFilename . ".html"; ?>';
					console.log(latestFile);
					var ajaxurl = 'delete.php',
					data =  {'file': latestFile};
					// Delay the deletion by 5 seconds (5000 milliseconds)
					setTimeout(function() {
						$.post(ajaxurl, data, function(response) {
							alert("File removed from server.");
						});
					}, 5000); // 5 seconds delay
				});
			});
			
		</script>
	</body>
</html>



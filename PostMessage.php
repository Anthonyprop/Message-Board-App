<!DOCTYPE html>
<html>
<head>

	<title>Message Board Exercise</title>
</head>
<body>
	<?php
		echo "<body style='background-color:pink'>";
		if(isset($_POST['submit'])) {
			$Subject = stripslashes($_POST['subject']);
			$Name = stripslashes($_POST['name']);
			$Message = stripslashes($_POST['message']);// Replace any '~' with '-' characters
			$Subject = str_replace("~", "-", $Subject);
			$Name = str_replace("~", "-", $Name);
			$Message = str_replace("~", "-", $Message);

			$ExistingSubjects = array();

			if(file_exists("MessageBoard/messages.txt") && filesize("MessageBoard/messages.txt") > 0){
				$MessageArray = file("MessageBoard/messages.txt");
				$count = count($MessageArray);
				for($i = 0; $i < $count; ++$i) {
					$CurrMsg = explode("~", $MessageArray[$i]);
					$ExistingSubjects[] = $CurrMsg[0];
				}
			}
			if(in_array($Subject, $ExistingSubjects)){
				echo "<p>The subject you entered already exists!<br/>\n";
				echo "Please enter a new subject and try again.<br/>\n";
				echo "Your message was not saved!</p>";
				$Subject = "";
			}
			else {


				$MessageRecord = "$Subject~$Name~$Message\n";

				$MessageFile = fopen("MessageBoard/messages.txt", "ab");

				if($MessageFile === FALSE) {
					echo "There was an error in saving your message";
				}

				else {
					fwrite($MessageFile, $MessageRecord);
					fclose($MessageFile);
					echo "Your message has been saved.\n";
					$Subject = "";
					$Message = "";
				}
			}
		}
		else {
			$Subject = "";
			$Name = "";
			$Message = "";
		}
	?>

	<h1 style="text-align: center"><span style="color: blue">Post</span> <span style="color: white">New</span><span style="color: red"> Message</span></h1>
	<hr/>
	<form action="PostMessage.php" method="POST">
		<p><span style="font-weight: bold">Subject:</span>
			<input type="text" name="subject" value="<?php echo $Subject; ?>" /></p>
		<p><span style="font-weight: bold">Name:</span>
			<input type="text" name="name" value="<?php echo $Name; ?>" /></p>
		<textarea name="message" rows="6" cols="80" ><?php echo $Message; ?></textarea><br/>
		<input type="submit" name="submit" value="Post Message"/>
		<input type="reset" name="reset" value="Reset Form"/>
	</form>
	<hr/>
	<p><a href="MessageBoard.php">View Messages</a></p>
</body>
</html>
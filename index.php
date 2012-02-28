<?
session_start();

include('db_connect.php');

/*if($_SESSION['user_id']){
	header('Location: index.php#voting');
}*/

	if (isset($_POST['login_submit'])){
		$invalid = 0;
		$voterid = $_POST['voterid'];
		$query = 'select user_id, vote_status from 4104_elections';
		$result = $mysqli->query($query);
		if($mysqli->error) print "Query failed: ".$mysqli->error;
	
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			if($voterid == $row['user_id']){
				
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['vote_status'] = $row['vote_status'];
				header('Location: index.php#voting');
			}
			$invalid = 1;
		}
    }
    
    if (isset($_POST['voter_submit'])){
    	if(empty($_POST['candidate'])){
    	$candidate = $_POST['voter_submit'];
    	}
    	else $candidate = $_POST['candidate'];
    	$query = 'update 4104_elections set vote_status = 1, candidate = '.$candidate.' where user_id = '.$_SESSION['user_id'];
		$result = $mysqli->query($query);
		if($mysqli->error) print "Query failed: ".$mysqli->error;
		
		$query = 'update 4104_candidates set votes = votes + 1 where id = '.$candidate;
		$result = $mysqli->query($query);
		if($mysqli->error) print "Query failed: ".$mysqli->error;
		
		header('Location: index.php#results');
		$_SESSION['vote_status'] = 1;
		}
    
    if (isset($_POST['logout'])){
    	session_destroy();
    	unset($_SESSION['user_id']);
    	unset($_SESSION['vote_status']);
    	unset($_SESSION['admin']);
    	}
    	
    if(isset($_POST['manager'])){
    	if($_POST['admin_id'] == 'admin'){
    	$_SESSION['admin'] = $_POST['admin_id'];
    	}
    }
    
    if(isset($_POST['clear'])){
    	if($_POST['clear'] == 'Clear All Votes'){
    	$query = 'update 4104_candidates set votes = 0';
    	$result = $mysqli->query($query);
		if($mysqli->error) print "Query failed: ".$mysqli->error;
		
    	$query = 'update 4104_elections set vote_status = 0, candidate=0';
    	$result = $mysqli->query($query);
		if($mysqli->error) print "Query failed: ".$mysqli->error;
    	}
    	else {
			if(is_array($_POST['vote_clear'])){
			$comma_separated = implode(",", $_POST['vote_clear']);
			}
			else $comma_separated = $_POST['vote_clear'];
			
			$query ='SELECT user_id, vote_status, 4104_candidates.id from 4104_elections inner join 4104_candidates on 4104_elections.candidate=4104_candidates.id where user_id in ('.$comma_separated.')';
			$result = $mysqli->query($query);
			if($mysqli->error) print "Query failed: ".$mysqli->error;
		
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if($row['vote_status'] == 1){
					$query = 'update 4104_candidates set votes = votes - 1 where id = '.$row['id'];
					$result2 = $mysqli->query($query);
					if($mysqli->error) print "Query failed: ".$mysqli->error;
				}
			}
			
			$query = 'update 4104_elections set vote_status = 0, candidate = 0 where user_id in ('.$comma_separated.')';
			$result = $mysqli->query($query);
			if($mysqli->error) print "Query failed: ".$mysqli->error;
		}
		header('Location: index.php#manager');
    }
    ?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Toontown Voting System</title>
    <link rel="stylesheet" href="css/themes/toontown_theme.css" />
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile.structure-1.0.1.min.css" /> 
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script> 
  <script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
	<style>
	@font-face { font-family: Toontown; src: url('fonts/toonti.ttf'); } 
	.imgContainer {
		width:230px;
		height:230px;
		text-align:center;
		border:2px solid #666;
	}
	.imgContainer img { 
		max-width:100%;
		max-height:100%;
		 margin-left:auto;
		 margin-right:auto;
	 }
	 .logoContainer
	 {
		 width:230ems;
		height:230ems;
		text-align:center;
	 }
	 .logoContainer img { 
		max-width:100%;
		max-height:100%;
		 margin-left:auto;
		 margin-right:auto;
	 }
	 th
	 {
		 border-bottom: 1px solid #000;
	 }
	  h3, h2
	 {
		 font-family: Toontown;
		 color:#F00;
		 font-size: 28px;
		 text-shadow: 2px 2px 2px #000;
		 
	 }
	 h1, tr:first-Child, td:first-Child
	 {
		 font-family: Toontown;
	 }
	 tr:first-Child
	 {
		 color:#F00;
	 }
	 body
	 {
		 background-color: #f7ea8d;
	 }
	</style>
</head>
<body>

	<div data-role="page" id="loginPage">
		<div data-role="header">
			<h1>Login Page</h1>
		</div>
		<div data-role="content" data-theme = 'a'>
        <div class = 'logoContainer'><img src = "img/logo.png" alt = "logo"/></div>
		<? if($invalid==1){
			echo "<h3>That was an invalid voting id.</h3>";
			}
			?>
			<p>Please log in to continue:</p>
			<form method="POST" action="index.php" data-ajax="false">
				<p><label>Voter ID Number: <input name="voterid" type="number" min="1001" max="1049" required></label></p>
				<p><button type="submit" name="login_submit">Log In</button></p>
			</form>
			<h3>The Candidates</h3>
				<a href="#candidate1">See Candidate 1: Jessica Rabbit</a><br/>
                <a href="#candidate2">See Candidate 2: Porky Pig</a><br/>
                <a href="#candidate3">See Candidate 3: Marvin the Martian</a>
			<p><a href="index.php#results">View results.</a></p>
		</div>
	</div>
	
	<div data-role="page" id="voting" >
		<div data-role="header">
			<h1>Voter Home Page</h1>
		</div>
		<div data-role="content" data-theme='a'>
         <div class = 'logoContainer'><img src = "img/logo.png" alt = "logo"/></div>
				<? if($_SESSION['user_id']){
				?>
				<h2>The Candidates</h2>
				<a href="#candidate1">See Candidate 1: Jessica Rabbit</a><br/>
                <a href="#candidate2">See Candidate 2: Porky Pig</a><br/>
                <a href="#candidate3">See Candidate 3: Marvin the Martian</a>
                
                <?
					if($_SESSION['vote_status'] == 0){
				?>
				<h2>Voting</h2>
				<form method="POST" action="index.php#results" data-ajax="false">
					<fieldset data-role="controlgroup">
						<legend>Vote for a candidate:</legend>
						<input type="radio" name="candidate" id="radio-choice-1" value="1" checked="checked" />
						<label for="radio-choice-1">Jessica Rabbit</label>
				
						<input type="radio" name="candidate" id="radio-choice-2" value="2"  />
						<label for="radio-choice-2">Porky Pig</label>
				
						<input type="radio" name="candidate" id="radio-choice-3" value="3"  />
						<label for="radio-choice-3">Marvin the Martin</label></p>
					</fieldset>
					<button type="submit" name="voter_submit">Vote</button>
				</form>
				<?
				}
				else echo "<p>You have already voted.</p>";
				echo "<p><a href=\"index.php#results\">View results.</a></p>";
                ?>
			</form>
			
			<form method="POST" action="index.php" data-ajax="false">
			<button type="submit" name="logout">Log Out</button>
			</form>
			<? }
			else echo "<p>Please <a href=\"index.php\">log in</a> to proceed.</p>";
			?>
		</div>
	</div>

	<div data-role="page" id="candidate1">
		<div data-role="header">
			<h1>Jessica Rabbit</h1>
		</div>
		<div data-role="content" data-theme='a'>
			<div class="imgContainer"><img src = "img/jessica.png" alt = "jessica"/></div>
            <ul class = "stats">
            	<h3>Stats:</h3>
            	<li>Age: Undisclosed.</li>
                <li>Gender: Female</li>
                <li>Height: 6'</li>
            </ul>
			<p> Jessica Rabbit has years and years of experience with swaying public opinion. Her realization of her own charismatic power led her to run for mayor. She was also just tired of singing at clubs for a living.</p>
             <ul class = "platform">
             	<h3>Platforms:</h3>
                <li>Tax funds will be redirected to "Cosmetic Welfare" for low-income, ugly people.</li>
            	<li>Socialized dressmaking</li>
                <li>Town-wide happy-hour from 12pm to 2am. Half-off drinks. Enforced daily.</li>
                <li>Founder of ASFA – "The Anti-Discrimination of Small Feet Alliance"</li>
            </ul>
            <h3>Quote:</h3>
			<p>"When you look <em>this</em> good, who wouldn't vote for you?"<p>
			<!--<button>Vote for Candidate 1</button>-->
			<?
			if($_SESSION['user_id']){ 
				if($_SESSION['vote_status'] == 0){
			?>
				<form method="POST" action="index.php#results" data-ajax="false">
					<button type="submit" name="voter_submit" value="1">Vote for Jessica Rabbit</button>
				</form>
			<?
				}
				echo "<a href=\"index.php#voting\">Back to voter home page</a>";
			}
			else echo "<a href=\"index.php\">Log In</a>";
			?>
		</div>		
	</div>
    
    <div data-role="page" id="candidate2">
		<div data-role="header">
			<h1>Porky Pig</h1>
		</div>
		<div data-role="content" data-theme='a'>
			<div class="imgContainer"><img src = "img/porky.png" alt = "porky"/></div>
            <ul class = "stats">
            	<h3>Stats:</h3>
            	<li>Age: 35</li>
                <li>Gender: Male</li>
                <li>Height: 3'4"</li>
            </ul>
			<p> Porky Pig is renown for his strong sense of kindness, organization, and panicked stuttering. After making immense progress on his weight-loss regimen, his newfound confidence drove him to pursue the title of Toontown Mayor. </p>
             <ul class = "platform">
             	<h3>Platforms:</h3>
                <li>Illegalization and penalization of the consumption of pork</li>
            	<li>Tax funds allocated to hair-loss preventative research and treatment</li>
                <li>Plans to build a 24/7 community gym</li>
                <li>We would know more, but he can't quite get through a single speech.</li>
            </ul>
            <h3>Quote:</h3>
			<p>"D-d-ditch the h-ham and avoid a scam! V-v-v-choose me for Toontown Mayor!"<p>
			<!--<button>Vote for Candidate 1</button>-->
			<?
			if($_SESSION['user_id']){ 
				if($_SESSION['vote_status'] == 0){
			?>
				<form method="POST" action="index.php#results" data-ajax="false">
					<button type="submit" name="voter_submit" value="2">Vote for Porky Pig</button>
				</form>
			<?
				}
				echo "<a href=\"index.php#voting\">Back to voter home page</a>";
			}
			else echo "<a href=\"index.php\">Log In</a>";
			?>
		</div>		
	</div>
	
     
    <div data-role="page" id="candidate3">
		<div data-role="header">
			<h1>Marvin the Martian</h1>
		</div>
		<div data-role="content" data-theme='a'>
			<div class="imgContainer"><img src = "img/marvin.png" alt = "marvin"/></div>
            <ul class = "stats">
            	<h3>Stats:</h3>
            	<li>Age: 2,000</li>
                <li>Gender: Male</li>
                <li>Height: 2'5"</li>
            </ul>
			<p>After failing to destroy Earth in 1957, Marvin Martian decided that the only way to rule over the puny earthlings would to be to corrupt the system from the inside, but that's actually not true at all. He is determined to bring rainbows and butterfly sparkles to humankind…in the form of uranium-based explosives.</p>
             <ul class = "platform">
             	<h3>Platforms:</h3>
                <li>Tax funds delegated to himself</li>
            	<li>Socialized human slavery</li>
                <li>Government aid to those swearing allegiance to Mars</li>
                <li>Likes dogs</li>
            </ul>
            <h3>Quote:</h3>
			<p>"Vote for me, earthlings. You have no choice!"<p>
			<!--<button>Vote for Candidate 1</button>-->
			<?
			if($_SESSION['user_id']){ 
				if($_SESSION['vote_status'] == 0){
			?>
				<form method="POST" action="index.php#results" data-ajax="false">
					<button type="submit" name="voter_submit" value="3">Vote for Marvin the Martin</button>
				</form>
			<?
				}
				echo "<a href=\"index.php#voting\">Back to voter home page</a>";
			}
			else echo "<a href=\"index.php\">Log In</a>";
			?>
		</div>
	</div>
	
	<div data-role="page" id="results">
		<div data-role="header">
			<h1>Voting Results</h1>
		</div>
		<div data-role="content" data-theme='a'>
                <div class = 'logoContainer'><img src = "img/logo.png" alt = "logo"/></div>
			<table cellpading = "10" cellspacing="10">
			<tr><th>Candidate Name</th>
			<th>Number of Votes</th>
			<th>Percentage of Votes</th>
			</tr>
			<?
			$query = 'select SUM(votes) from 4104_candidates';
			$result = $mysqli->query($query);
			if($mysqli->error) {
				 print "Query failed: ".$mysqli->error;
			}
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$totalvotes = $row['SUM(votes)'];
			}
			
			$query = 'select * from 4104_candidates';
			$result = $mysqli->query($query);
			if($mysqli->error) {
				 print "Query failed: ".$mysqli->error;
			}
			
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				echo "<tr><td>".$row['name']."</td>";
				echo "<td>".$row['votes']."</td>";
				if($totalvotes != 0) echo "<td>".(round($row['votes']/$totalvotes*100, 1))."%</td></tr>";
				else echo "<td>0%</td></tr>";
				}
			?>
			</table>
			
			<p>
			<?
			if($_SESSION['user_id']){
				echo "<a href=\"index.php#voting\">Back to voter home page</a>";
			}
			else echo "<a href=\"index.php\">Log In</a>";
			?>
			</p>
		</div>
	</div>
	
	<div data-role="page" id="manager">
		<div data-role="header">
			<h1>Manager Page</h1>
		</div>
		<div data-role="content" data-theme='a'>
			<? if($_SESSION['admin']){
			$query = 'select * from 4104_elections';
			$result = $mysqli->query($query);
			if($mysqli->error) {
				 print "Query failed: ".$mysqli->error;
			}
			?>
            <form method="POST" action="index.php#manager" data-ajax="false">
                <table cellpadding = "5">
                    <tr>
                        <th>Voter ID</th>
                        <th>Has Voted</th>
                        <th>Voted For</th>
                   </tr>
               <!-- dynamically w/PHP populate the rest of the table with the user's info -->
               <?
               while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				echo "<tr><td>".$row['user_id']."</td>";
				echo "<td><input type=\"checkbox\" class=\"voter_checks\" name=\"vote_clear[]\" value=\"".$row['user_id']."\" ";
				if($row['vote_status'] == 1){
					echo "checked=\"true\"";
					}
				echo " /></td>";
				echo "<td>".$row['candidate']."</td></tr>";
				}
				?>
                </table>
                <input type="submit" name="clear" value="Clear Selected Votes"/>
                <input type="submit" name="clear" value="Clear All Votes"/>
             </form>
             
            <form method="POST" action="index.php#manager" data-ajax="false">
				<button type="submit" name="logout">Log Out</button>
			</form>
             <?
             }
             else {
             ?>
             <form method="POST" action="index.php#manager" data-ajax="false">
				<p><label>Log In ID:<input name="admin_id" required></label> </p>
				<p><button type="submit" name="manager">Log In</button></p>
			</form>
			<?
             }
             ?>
		</div>	
	</div>
	
		</div>
		
	</div>
</body>
</html>
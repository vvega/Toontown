<!doctype html>
<?php
	include('db_connect.php');
	echo "ARE YOU WORKING";
	if (isset($_POST['submit'])){
		$voterid = $_POST['voterid'];
		$query = 'select user_id from 4104_elections';
		$result = $mysqli->query($query);
				if($mysqli->error) {
				 print "Query failed: ".$mysqli->error;
			}
	
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			if($voterid == $row['user_id']){
				header('Location: http://INSERT-NEXT-URL');
			}
			else echo "you suck";
		}
    }
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Toontown Voting System</title>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
	<!--
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile.structure-1.0.1.min.css" />
	-->
	<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
	<style>
	.imgContainer {
		width:300px;
		height:400px;
		background:black;
		text-align:center;
	}
	.imgContainer img { 
		width:250px;
		height:250px;
	 }
	</style>
</head>
<body>

	<div data-role="page" id="loginPage">
		
		<div data-role="header">
			<h1>Login Page</h1>
		</div>
		
		<div data-role="content">
			<p>Please log in to continue.</p>
			<form method="POST" action="index.php">
				<p><label>Voter ID Number: <input name="voterid" type="number" min="1001" max="1049" required></label></p>
				<p><button type="submit" name="submit">Log In</button></p>
				<a href="#candidate1">See Candidate 1</a>
			</form>
		</div>
		
	</div>

	<div data-role="page" id="candidate1">
		
		<div data-role="header">
			<h1>Jessica Rabbit</h1>
		</div>
		
		<div data-role="content">
			<div class="imgContainer"></div>
            <ul class = "stats">
            	<h3>Stats:</h3>
            	<li>Age: Undisclosed.</li>
                <li>Gender: Female</li>
                <li>Height: 6'</li>
            </ul>
			<p> Jessica Rabbit has years and years of experience with swaying public opinion. Her realization of her own charismatic power led her to run for mayor. She was also just tired of singing at clubs for a living.</p>
             <ul class = "stances">
             	<h3>Tax funds will be redirected to "Cosmetic Welfare" for low-income, ugly people.</h3>
            	<li>Socialized dressmaking</li>
                <li>Town-wide happy-hour from 12pm to 2am. Half-off drinks. Enforced daily.</li>
                <li>Founder of ASFA – "The Anti-Discrimination of Small Feet Alliance"</li>
            </ul>
			<p>Quote: "When you look this good, who wouldn't vote for you?"<p>
			<!--<button>Vote for Candidate 1</button>-->
			<a href="#results" data-role="button">Vote for Jessica Rabbit</a>
		</div>
		
	</div>
    
    <div data-role="page" id="candidate2">
		
		<div data-role="header">
			<h1>Candidate 2</h1>
		</div>
		
		<div data-role="content">
			<div class="imgContainer"></div>
			<p>This candidate's platform statement goes here.</p>
			<!--<button>Vote for Candidate 1</button>-->
			<a href="#results" data-role="button">Vote for Candidate 1</a>
		</div>
		
	</div>
	
     
    <div data-role="page" id="candidate3">
		
		<div data-role="header">
			<h1>Candidate 3</h1>
		</div>
		
		<div data-role="content">
			<div class="imgContainer"></div>
			<p>This candidate's platform statement goes here.</p>
			<!--<button>Vote for Candidate 1</button>-->
			<a href="#results" data-role="button">Vote for Candidate 1</a>
		</div>
		
	</div>
    
	<div data-role="page" id="results">
		
		<div data-role="header">
			<h1>Voting Results</h1>
		</div>
		
		<div data-role="content">
			<table>
				<tr>
					<td>Candidate 1:</td><td>33%</td>
				</tr>
				<tr>
					<td>Candidate 2:</td><td>33%</td>
				</tr>
				<tr>
					<td>Candidate 3:</td><td>33%</td>
				</tr>
			</table>
		</div>
		
	</div>
	
	<div data-role="page" id="manager">
		
		<div data-role="header">
			<h1>Manager Page</h1>
		</div>
		
		<div data-role="content">
			
		</div>
		
	</div>

</body>
</html>
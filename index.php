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
		width:230px;
		height:230px;
		background:black;
		text-align:center;
		border:2px solid #666;
	}
	.imgContainer img { 
		max-width:100%;
	 }
	 th
	 {
		 border-bottom: 1px solid #000;
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
				<a href="#candidate1">See Candidate 1: Jessica Rabbit</a><br/>
                <a href="#candidate2">See Candidate 2: Porky Pig</a><br/>
                <a href="#candidate3">See Candidate 3: Marvin the Martian</a>
				<a href="#candidate1">See Candidate 1</a>
			</form>
		</div>
		
	</div>

	<div data-role="page" id="candidate1">
		
		<div data-role="header">
			<h1>Jessica Rabbit</h1>
		</div>
		
		<div data-role="content">
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
			<a href="#results" data-role="button">Vote for Jessica Rabbit</a>
		</div>		
	</div>
    
    <div data-role="page" id="candidate2">
		
		<div data-role="header">
			<h1>Porky Pig</h1>
		</div>
		
		<div data-role="content">
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
			<a href="#results" data-role="button">Vote for Porky Pig</a>
		</div>		
	</div>
	
     
    <div data-role="page" id="candidate3">
		
		<div data-role="header">
			<h1>Marvin the Martian</h1>
		</div>
		
				<div data-role="content">
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
			<a href="#results" data-role="button">Vote for Marvin the Martian</a>
		</div>	
		
	</div>
			<h1>Candidate 1</h1>
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
					<td>Jessica Rabbit:</td><td>33%</td>
				</tr>
				<tr>
					<td>Porky Pig:</td><td>33%</td>
				</tr>
				<tr>
					<td>Marvin the Martian:</td><td>33%</td>
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
            <form name = "user_votes">
                <table cellpadding = "5">
                    <tr>
                        <th>Voter ID</th>
                        <th>Has Voted</th>
                   </tr>
               <!-- dynamically w/PHP populate the rest of the table with the user's info -->
                   <tr>
                        <td>ExampleID</td>
                        <td>
                            <input type = "checkbox" class ="voter_checks" name ="exampleid">
                        </td>
                   </tr>
                </table>
                <input type = "submit" name = "clear" value = "Clear All Votes"/>
             </form>
		</div>	
	</div>
			
		</div>
		
	</div>
</body>
</html>
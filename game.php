<?php 
	
$con = mysqli_connect('localhost', 'root', '')
	or die(mysqli_error());

	// mysqli_select_db('rock_paper_scissors', $con)	
	// or die(mysqli_error());

	$con->select_db('rock_paper_scissors');

if( isset($_POST['submit']) == TRUE ):

	//hold a variable
		$username = trim(strip_tags(stripslashes($_POST['username'])));

		//store our session
		$_SESSION['username'] = $username;

		//Redirect the user
		header("Location:./");

endif;
if( isset($_GET['logout']) == TRUE ){
	session_destroy();
	header("Location: ./ ");
}

function display_items($item = null){

	$items = array(
		"rock" 		=> '<a href="?item=rock">Rock<img src="images/rock.jpg"></a>',
		"paper"		=>'<a href="?item=paper">Paper<img src="images/paper.jpg"></a>',
		"scissors"	=>'<a href="?item=scissors">Scissors<img src="images/scissors.jpg"></a>'

	);
	if( $item == null) :
	foreach( $items as $item => $value) : 
		echo $value;
	endforeach;
	else :
		// echo $items[$item];
		echo str_replace("?item={$item}", "#", $items[$item]);
	endif; 

}
function game(){
	global $con;

	if( isset($_GET['item']) == TRUE):

		
		//valid Items
		$items = array('rock', 'paper', 'scissors');

		//User's Item
		$user_item = strtolower($_GET['item']);

		//computer's Item
		$comp_item = $items[rand(0, 2)];
		

		//User's item isn't valid
		if( in_array($user_item, $items) == FALSE ):
			echo "You must choose either a Rock | Paper | Scissors";
			die;
		endif;

		//Scissors > Paper
		//Paper > Rock
		// Rock > Scissors

		if( $user_item == 'scissors' && $comp_item == 'paper' ||
			$user_item == 'paper' && $comp_item== 'rock' ||
			$user_item == 'rock' && $comp_item == 'scissors'):
				echo '<h2>You Win!</h2>';
				$outcome = 'yes';
		endif;

		if( $comp_item == 'scissors' && $user_item == 'paper' ||
			$comp_item == 'paper' && $user_item== 'rock' ||
			$comp_item == 'rock' && $user_item == 'scissors'):
				echo '<h2>You Lose!</h2>';
				$outcome = 'no';


		endif;

		if( $user_item == $comp_item):
			echo '<h2>Tie!</h2>';
			$outcome = 'tie';

		endif;

		//User's item
		display_items($user_item);

		//Computer's item
		display_items($comp_item);

		//Add a go back link
		echo '<div id="again" ><a href="./"> <br> Play Again</a></div>';

		$sql = "INSERT INTO `rock_paper_scissors` (`id`, `username`, `win`) VALUES ('null', '". $_SESSION['username']."', '$outcome')";
		$res = mysqli_query($con, $sql) or die(mysqli_error());
	else: 

		display_items();

		
	endif;

}


?>
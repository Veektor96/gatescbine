<?php
/*
Plugin Name: plugin1
Description: Genereaza si afiseaza retete pentru gatit
Version: 0.1.0
Author: Gatesc Bine development team
Text Domain: gatescbine
Domain Path: /languages
*/


function myplugin_activate() {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "plugin1";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// sql to create table
		$sql = "CREATE TABLE MyGuests (                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,                                                                                                                                                                                                                                                                                                                                                                                                                                                    
		firstname VARCHAR(30) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
		lastname VARCHAR(30) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
		email VARCHAR(50),                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
		reg_date TIMESTAMP                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
		)";

		// use exec() because no results are returned
		$conn->exec($sql);
		//echo "Table MyGuests created successfully";
		}
	catch(PDOException $e)
		{
		echo $sql . "<br>" . $e->getMessage();
		}

	$conn = null;
}
register_activation_hook( __FILE__, 'myplugin_activate' );



function pippin_show_fruits() {
	$fruits = array(
		'apples',
		'oranges',
		'kumkwats',
		'dragon fruit',
		'peaches',
		'durians'
	);
	$list = '<ul>';
 
	foreach($fruits as $fruit) :
		$list .= '<li>' . $fruit . '</li>';
	endforeach;
 
	$list .= '</ul>';
 
	return $list;
}
add_shortcode( 'foobar', 'pippin_show_fruits' );
 

 
function gatescbine_form(){
 $msg = '                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
    <div id="content">                                                                                                                                                                                                                
    <form action="';
 $msg = $msg . esc_url( admin_url('admin-post.php') );
 $msg = $msg . '" method="post">
        <label for="id">Id reteta</label>
        <input type="text" name="id" id="fullname" required>
        <label for="message">Nume reteta</label>
        <textarea name="nume" id="message"></textarea>
        <input type="hidden" name="action" value="gatesc_contact_form">
		<input type="hidden" id="txtUrl" name="txtUrl" value="" />
		<script>
		document.getElementById(\'txtUrl\').value = window.location.href;
		</script>
        <input type="submit" value="Send My Message">
    </form>
	</div>';
	return $msg;
}
add_shortcode( 'gatescbine_form', 'gatescbine_form' );

function gatescbine_form_callback(){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "plugin1";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("INSERT INTO `retete`(`id`, `nume`) VALUES (:id, :nume)"); 
		$stmt->bindParam(':id', $_POST["id"]);
		$stmt->bindParam(':nume', $_POST["nume"]);
		$stmt->execute();
		}
	catch(PDOException $e)
		{
		echo $sql . "<br>" . $e->getMessage();
		}

	$conn = null;
	
	header("Location: " . $_POST["txtUrl"]);
	die();
}

add_action( 'admin_post_nopriv_gatesc_contact_form', 'gatescbine_form_callback' );
add_action( 'admin_post_gatesc_contact_form', 'gatescbine_form_callback' );


?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
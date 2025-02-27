<?php 
define('PROJECT','Blog');
require_once'./components/header.php'; 
$jane_grafik = "Нерабочий день";
$john_grafik = "Нерабочий день";

switch(date("w"))
{
    case 1:
    case 3:
    case 5:
        $john_grafik = "8:00-12:00";
        break;
	case 2:
		case 4:
		case 6:
			$jane_grafik = "12:00-16:00";
			break;
    default;
        echo 'Please make a new selection...';
        break;
}




?>

<body >
	<div id="app">
	<table class = "main_table">
		<tr>
			<th class="custom_td">№</th>	
			<th >Фамилия Имя</th>
			<th>График работы</th>
		<tr>
		<tr>
			<td>1</td>
			<td>John Styles</td>
			<td><?php echo $john_grafik; ?></td>
		</tr>
		<tr>
			<td>2</td>
			<td>Jane Doe</td>
			<td><?php echo $jane_grafik; ?></td>
		</tr>
		
	</table>	

	<?php

		$a = 0;
		$b = 0;
		
		for ($i = 0; $i <= 5; $i++) {
		   $a += 10;
		   $b += 5;
		   echo  "a = " . $a . " b =  " . $b . "<br>";
		}
		
		echo "End of the for loop: a = $a, b = $b<br>";
		
		$i = 0;
		$a = 0;
		$b = 0;
		while($i<=5){
		    $i++;
		    $a += 10;
		    $b += 5;
		}
		
		echo "End of the while loop: a = $a, b = $b <br>";
		
		$i = 0;
		$a = 0;
		$b = 0;
		do{
		    $i++;
		    $a += 10;
		    $b += 5;
		}while($i<=5);
		
		 echo "End of the do-while loop: a = $a, b = $b<br>";
		
	?>
	</div>
</body>
<?php  require_once'./components/footer.php'; ?>
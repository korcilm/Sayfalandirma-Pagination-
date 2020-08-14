<!DOCTYPE html>
<html>
<head>
	<title>Sayfalandırma (Pagination)</title>
</head>
<body>
	<?php 

	session_start();
	ob_start();

	$user="root";
	$pass="";

	// PDO veritabanı bağlantısı 
	try {
		$db=new PDO("mysql:host=localhost; dbname=pagination; charset=utf8;" ,$user,$pass);
	}catch (PDOException $error) {
		echo "Database bağlantısı kurulamadı";
		$error->getMessage();
	}
	// bir sayfadaki sonuç sayısı
	$results_per_page = 5;


	// veritabanındaki saklanan verinin sayısı
	$query=$db->query("SELECT * FROM alphabet");
	$number_of_results=$query->rowCount();	


	// oluşacak toplam sayfa sayısını bulma
	$number_of_pages = ceil($number_of_results/$results_per_page);

	// ziyaretçinin o anda hangi sayfa numarasında olduğunu belirleme
	if (!isset($_GET['page'])) {
		$page = 1;
	} else {
		$page = $_GET['page'];
	}
	// görüntülenen sayfadaki sonuçlar için sql LIMIT başlangıç numarasını belirleme
	$this_page_first_result = ($page-1)*$results_per_page;

	// seçilen sonuçları veritabanından alın ve sayfada görüntüleyin
	$sql="SELECT * FROM alphabet LIMIT ". $this_page_first_result .",".  $results_per_page ;
	$query=$db->prepare($sql);	
	$query->execute();

	while($row = $query->fetch()) {
		echo $row['id'] . ' ' . $row['alphabet']. '<br>';
	}

	// sayfalara olan bağlantıları göster
	for ($page=1;$page<=$number_of_pages;$page++) {
		echo '<a href="index.php?page=' . $page . '">' . $page . '</a> ';
	}
	?>

</body>
</html>
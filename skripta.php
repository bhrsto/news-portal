<?php
    include 'connect.php';

    if(isset($_POST['submit'])){
        $title = $_POST['title'];
        $about = $_POST['about'];
        $content = $_POST['content'];
        $slika = $_FILES['slika']['name'];
        $category = $_POST['category'];
    
        if(isset($_POST['arhiva'])){
            $arhiva=1;
           }else{
            $arhiva=0;
           }

        $odrediste = 'C:\xampp\htdocs\pwa\slike/' . $slika;
        move_uploaded_file($_FILES['slika']['tmp_name'], $odrediste);

       
        $query = "INSERT INTO unos (naslov, kratakSadrzaj, sadrzaj, slika, kategorija, arhiva) VALUES('$title', '$about', '$content', '$slika', '$category', '$arhiva')";

        $result = mysqli_query($conn, $query) or die('Error querying database');

        mysqli_close($conn);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rheinische Post</title>
    <link rel="stylesheet" type="text/css" href="shared.css">
    <link rel="stylesheet" href="clanak.css">
</head>
<body>
    <header>
        <div class="naslov">
        <h1 class="logo">RP ONLINE</h1>
            <nav>
            <ul>
                <li><a href="index.php">POCETNA</a></li>
                <li><a href="sport.php">SPORT</a></li>
                <li><a href="politika.php">POLITIKA</a></li>
                <li><a href="unos.html">UNOS</a></li>
                <li><a href="administracija.php">ADMINISTRACIJA</a></li>
            </ul>
            </nav>
        </div>
    </header>

      <section>
        <div class="naslovSekcije">
            <h2><?php echo $category; ?></h2>
        </div>
        <div class="clanak">
            <div class="naslovClanka">
                <h2><?php echo $title; ?></h2>
            </div>
            <div class="slika">
            <img src="/pwa/slike/<?php echo $slika; ?>" alt="">

            </div>
            <div class="tekst">
                <span><?php echo $about; ?><br></span>        
            
                <p> 
                    <?php echo $content; ?>
                </p>
            </div>
        </div>
          
        </div>
    </section>
      <footer>
        <div class="container">
          &copy; Branimir Hrsto, branimir.hrsto@gmail.com, 2023.
        </div>
      </footer>


</body>
</html>
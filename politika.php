<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rheinische Post</title>
  <link rel="stylesheet" type="text/css" href="shared.css">
  <link rel="stylesheet" href="index.css">

  <style>
   
  </style>
</head>
<body>
    <header>
        <div class="naslov">
        <h1 class="logo">RP ONLINE</h1>
        <nav>
            <ul>
                
            <?php 
                  if(isset($_SESSION['level']) && $_SESSION['level'] == 1){
                    echo '<li><a href="index.php">POCETNA</a></li>';
                    echo '<li><a href="sport.php">SPORT</a></li>';
                    echo '<li><a href="politika.php">POLITIKA</a></li>';
                    echo '<li><a href="unos.php">UNOS</a></li>';
                    echo '<li><a href="administracija.php">ADMINISTRACIJA</a></li>';
                    echo' <form action="logout.php" method="post">
                              <button type="submit" name="logout">Odjava</button>
                          </form>';
                  }else if(isset($_SESSION['level'])){
                    echo '<li><a href="index.php">POCETNA</a></li>';
                    echo '<li><a href="sport.php">SPORT</a></li>';
                    echo '<li><a href="politika.php">POLITIKA</a></li>';
                    echo' <form action="logout.php" method="post">
                              <button type="submit" name="logout">Odjava</button>
                          </form>';
                  }else{
                    echo '<li><a href="index.php">POCETNA</a></li>';
                    echo '<li><a href="sport.php">SPORT</a></li>';
                    echo '<li><a href="politika.php">POLITIKA</a></li>';
                    echo '<li><a href="registracija.php">REGISTRACIJA</a></li>';
                    echo '<li><a href="login.php">PRIJAVA</a></li>';
                  }
                 
                ?>
            </ul>
            </nav>
        </div>
      </header>


    
      <section>
 <?php
 define('PUTANJA', 'slike/');

    include 'connect.php';
      $query = "SELECT * FROM unos WHERE arhiva=1 AND kategorija='politika'";
      $result = mysqli_query($conn, $query);
      echo '  <div class="naslovSekcije">
                    <h2>Politka</h2>
                </div>';
      while($row = mysqli_fetch_array($result)){
      echo ' 
            
      <a href="clanak.php?id='.$row['id'].'">
            <div class="clanak">
                <div class="slika">
                    <img src="' . PUTANJA .$row['slika'] . '">
                </div>
                <div class="tekst">
                    
                    <h3>'. $row["naslov"] .'</h3>
                    <p>'. $row["kratakSadrzaj"] .'</p>
                </div>
        
            </div>
        </a>';
      }?>
        </section>


 

  <footer>
    <div class="container">
      &copy; Branimir Hrsto, branimir.hrsto@gmail.com, 2023.
    </div>
  </footer>
</body>
</html>

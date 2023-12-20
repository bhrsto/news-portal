<?php
    include 'connect.php';
    define('PUTANJA', 'slike/');

        if (isset($_GET['id'])) {
                $articleId = $_GET['id'];

                
                $query = "SELECT * FROM unos WHERE id = $articleId";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
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
                
            <?php 
                  if(isset($_SESSION['level']) && $_SESSION['level'] == 1){
                    echo '<li><a href="index.php">POCETNA</a></li>';
                    echo '<li><a href="sport.php">SPORT</a></li>';
                    echo '<li><a href="politika.php">POLITIKA</a></li>';
                    echo '<li><a href="unos.html">UNOS</a></li>';
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
        <div class="naslovSekcije">
            <?php echo"<h2>".$row['kategorija']."</h2>";?>
        </div>
        <div class="clanak">
            <div class="naslovClanka">
            <?php echo"<h2>".$row['naslov']."</h2>";?> 
            </div>
            <div class="slika">
                <?php echo '<img src="' . PUTANJA . $row['slika'] . '" alt="">';?>
            </div>
            <div class="tekst">
            <?php echo"<span>".$row['kratakSadrzaj']."</span>";?> <br>        
            <?php echo"<p>".$row['sadrzaj']."</p>";?> 
                
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

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
        <form action="registracija.php" method="post">  
            <div class="form-item">
                <span id="porukaIme" class="bojaPoruke"></span>
                <label for="title">Ime: </label>
                <div class="form-field">
                    <input type="text" name="ime" id="ime" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <span id="porukaPrezime" class="bojaPoruke"></span>
                <label for="title">Prezime: </label>
                <div class="form-field">
                    <input type="text" name="prezime" id="prezime" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <span id="porukaUsername" class="bojaPoruke"></span>
                <label for="title">Korisničko ime: </label>
                <div class="form-field">
                    <input type="text" name="korIme" id="username" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <span id="porukaPass" class="bojaPoruke"></span>
                <label for="title">Lozinka: </label>
                <div class="form-field">
                    <input type="password" name="lozinka1" id="pass" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <span id="porukaPassRep" class="bojaPoruke"></span>
                <label for="title">Lozinka: </label>
                <div class="form-field">
                    <input type="password" name="lozinka2" id="passRep" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" value="Prihvati" name="submit" id="slanje">Prihvati</button>
            </div>
        </form>

        <?php

include 'connect.php';
if(isset($_POST["submit"])){
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $username = $_POST['korIme'];
    $lozinka = $_POST['lozinka1'];
    $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);
    $razina = 0;
    $registriranKorisnik = '';
    $errorMessage = ''; // Variable to store the error message
// Provjera postoji li u bazi već korisnik s tim korisničkim imenom
    $sql = "SELECT * FROM korisnik WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $korIme);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
    }

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "<h1>Korisničko ime već postoji!</h1>";
    $registriranKorisnik = false; // Set $registriranKorisnik to false to indicate that registration failed
 } else {
     // Ako ne postoji korisnik s tim korisničkim imenom - Registracija korisnika u bazi pazeći na SQL injection
     $sql = "INSERT INTO korisnik (ime, prezime, username, sifra, razina) VALUES (?, ?, ?, ?, ?)";
     $stmt = mysqli_stmt_init($conn);
     if (mysqli_stmt_prepare($stmt, $sql)) {
         mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $username, $hashed_password, $razina);
         mysqli_stmt_execute($stmt);
         $registriranKorisnik = true;
     }
 }
 
}


mysqli_close($conn);
?>

   
    </section>

    <script type="text/javascript">
    document.getElementById("slanje").onclick = function(event) {
    
        var slanjeForme = true;
        
        // Ime korisnika mora biti uneseno
        var poljeIme = document.getElementById("ime");
        var ime = document.getElementById("ime").value;
        if (ime.length == 0) {
            slanjeForme = false;
            poljeIme.style.border="2px dashed red";
            document.getElementById("porukaIme").innerHTML="<br>Unesite ime!<br>";
        } else {
            poljeIme.style.border="2px solid green";
            document.getElementById("porukaIme").innerHTML="";
        }
        // Prezime korisnika mora biti uneseno
        var poljePrezime = document.getElementById("prezime");
        var prezime = document.getElementById("prezime").value;
        if (prezime.length == 0) {
            slanjeForme = false;
            poljePrezime.style.border="2px dashed red"; 
            document.getElementById("porukaPrezime").innerHTML="<br>Unesite Prezime!<br>";
        } else {
            poljePrezime.style.border="2px solid green";
            document.getElementById("porukaPrezime").innerHTML="";
        }
        
        // Korisničko ime mora biti uneseno
        var poljeUsername = document.getElementById("username");
        var username = document.getElementById("username").value;
        if (username.length == 0) {
            slanjeForme = false;
            poljeUsername.style.border="2px dashed red";
            document.getElementById("porukaUsername").innerHTML="<br>Unesite korisničko ime!<br>";
        } else {
            poljeUsername.style.border="2px solid green";
            document.getElementById("porukaUsername").innerHTML="";
        }
        
        // Provjera podudaranja lozinki
        var poljePass = document.getElementById("pass");
        var pass = document.getElementById("pass").value;
        var poljePassRep = document.getElementById("passRep");
        var passRep = document.getElementById("passRep").value;
        if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
            slanjeForme = false;
            poljePass.style.border="2px dashed red";
            poljePassRep.style.border="2px dashed red";
            document.getElementById("porukaPass").innerHTML="<br>Lozinke nisu iste!<br>";
            
            document.getElementById("porukaPassRep").innerHTML="<br>Lozinke nisu iste!<br>";
        } else {
            poljePass.style.border="2px solid green";
            poljePassRep.style.border="2px solid green";
            document.getElementById("porukaPass").innerHTML="";
            document.getElementById("porukaPassRep").innerHTML="";
        }
        
        if (slanjeForme != true) {
             event.preventDefault();
        }
      
        
    };
 </script>

    <footer>
    <div class="container">
      &copy; Branimir Hrsto, branimir.hrsto@gmail.com, 2023.
    </div>
  </footer>


</body>
</html>




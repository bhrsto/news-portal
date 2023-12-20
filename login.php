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
        <form action="login.php" method="post">  
            
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
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" value="Prihvati" name="submit" id="slanje">Prihvati</button>
                
            </div>
        </form>
        
        <?php
session_start();
include 'connect.php';


if(isset($_POST['submit'])){
    $korIme = $_POST['korIme'];
    $lozinka = $_POST['lozinka1'];
    $uspjesnaPrijava = false;

    $sql = "SELECT username, sifra, razina FROM korisnik WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, 's', $korIme);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $imeKorisnika = $row['username'];
            $lozinkaKorisnika = $row['sifra'];
            $levelKorisnika = $row['razina'];

            if(password_verify($lozinka, $lozinkaKorisnika)){
                $uspjesnaPrijava = true;

                if($levelKorisnika == 1){
                    $admin = true;
                    
                } else{
                    $admin = false;
                }
                $_SESSION['username'] = $imeKorisnika;
                $_SESSION['level'] = $levelKorisnika;
            } else{
                $uspjesnaPrijava = false;
            }
        } 

        if (($uspjesnaPrijava == true && $admin == true) || (isset($_SESSION['username']) && $_SESSION['level'] == 1)) {
            header('Location: administracija.php');
            exit();
        }elseif ($uspjesnaPrijava == true && $admin == false) {
           echo '<h2>Bok ' . $imeKorisnika . '! Uspješno ste prijavljeni, ali niste administrator.</h2>';
        } elseif (isset($_SESSION['username']) && $_SESSION['level'] == 0) {
            echo '<h2>Bok ' . $_SESSION['username'] . '! Uspješno ste prijavljeni, ali niste administrator.<h2>';
        } elseif (!$uspjesnaPrijava) {
            echo '<h2><a href="registracija.php">Morate se registrirati!</a></h2>';
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>
    </section>    
    </body>
</html>





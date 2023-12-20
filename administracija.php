<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
<?php
include 'connect.php';
define('PUTANJA', 'slike/');

$query = "SELECT * FROM unos";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)){
    echo'
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="form-item">
                <label for="title">Naslov vjesti:</label>
                <div class="form-field">
                    <input type="text" name="title" class="form-field-textual" value="'.$row['naslov'].'">
                </div>
            </div>

            <div class="form-item">
            <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label>
                <div class="form-field">
                    <textarea name="about" id="" cols="30" rows="10" class="form-field-textual">'.$row['kratakSadrzaj'].'</textarea>
                </div>
            </div>

            <div class="form-item">
            <label for="content">Sadržaj vijesti:</label>
                <div class="form-field">
                    <textarea name="content" id="" cols="30" rows="10" class="form-field-textual">'.$row['sadrzaj'].'</textarea>
                </div>
            </div>

            <div class="form-item">
            <label for="pphoto">Slika:</label>
                <div class="form-field">
                    <input type="file" class="input-text" id="pphoto" value="'.$row['slika'].'" name="slika"/> <br><img src="' . PUTANJA . $row['slika'] . '" width=100px>

                </div>
            </div>

            <div class="form-item">
            <label for="category">Kategorija vijesti:</label>
                <div class="form-field">
                    <select name="category" id="" class="form-field-textual" value="'.$row['kategorija'].'">
                        <option value="sport">Sport</option>
                        <option value="politika">Politika</option>
                    </select>
                </div>
            </div>

            <div class="form-item">
            <label>Spremiti u arhivu: 
                <div class="form-field">';
                    if($row['arhiva'] == 0) {
                        echo '<input type="checkbox" name="archive" id="archive"/> 
                        Arhiviraj?';
                        } else {
                            echo '<input type="checkbox" name="arhiva" id="archive" checked/> Arhiviraj?';
                        }
            echo '</div>
            </label>
            </div>
            </div>

            <div class="form-item">
            <input type="hidden" name="id" class="form-field-textual" value="'.$row['id'].'">
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" name="update" value="Prihvati"> Izmjeni</button>
                <button type="submit" name="delete" value="Izbriši"> Izbriši</button>
            </div>
        </form>';   
    }
    ?>
</section>

<?php
    if(isset($_POST['delete'])){
        $id=$_POST['id'];
        $query = "DELETE FROM unos WHERE id=$id ";
        $result = mysqli_query($conn, $query);
       }

    
    if(isset($_POST['update'])){
        $picture = $_FILES['slika']['name'];
        $title=$_POST['title'];
        $about=$_POST['about'];
        $content=$_POST['content'];
        $category=$_POST['category'];
        if(isset($_POST['arhiva'])){
         $arhiva=1;
        }else{
         $arhiva=0;
        }
        $target_dir = 'C:\xampp\htdocs\pwa\slike/' . $slika;
        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
        $id=$_POST['id'];
        $query = "UPDATE unos SET naslov='$title', kratakSadrzaj='$about', sadrzaj='$content', 
        slika='$picture', kategorija='$category', arhiva='$arhiva' WHERE id=$id ";
        $result = mysqli_query($conn, $query);
        }
       
?>


 <footer>
    <div class="container">
      &copy; Branimir Hrsto, branimir.hrsto@gmail.com, 2023.
    </div>
  </footer>
</body>
</html>
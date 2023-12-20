<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rheinische Post</title>
    <link rel="stylesheet" type="text/css" href="shared.css">

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
        <form action="skripta.php" method="POST" enctype="multipart/form-data">
            <div class="form-item">
                <span id="porukaTitle" class="bojaPoruke"></span>
                <label for="title">Naslov vijesti</label>
                <div class="form-field">
                    <input type="text" name="title" id="title" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <span id="porukaAbout" class="bojaPoruke"></span>
                <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                <div class="form-field">
                    <textarea name="about" id="about" cols="30" rows="10" id="about" class="form-field-textual"></textarea>
                </div>
            </div>

            <div class="form-item">
                <span id="porukaContent" class="bojaPoruke"></span>
                <label for="content">Sadržaj vijesti</label>
                <div class="form-field">
                    <textarea name="content" id="content" cols="30" rows="10" id="content" class="form-field-textual"></textarea>
                </div>
            </div>

            <div class="form-item">
                <span id="porukaSlika" class="bojaPoruke"></span>
                <label for="pphoto">Slika:</label>
                <div class="form-field">
                    <input type="file" class="input-text" id="pphoto" name="slika"/>
                </div>
            </div>
            

            <div class="form-item">
                <span id="porukaKategorija" class="bojaPoruke"></span>
                <label for="category">Kategorija vijesti</label>
                <div class="form-field">
                    <select name="category" id="category" class="form-field-textual">
                        <option value="sport">Sport</option>
                        <option value="politika">Politika</option>
                    </select>
                </div>
            </div>

            <div class="form-item">
                <label>Potvrdi: 
                <div class="form-field">
                    <input type="checkbox" name="arhiva">
                </div>
                </label>
            </div>

            <div class="form-item">
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" value="Prihvati" name="submit" id="slanje">Prihvati</button>
            </div>
            </form>
        </section>

        :
 <script type="text/javascript">
    document.getElementById("slanje").onclick = function(event) {
    
        var slanjeForme = true;
        

        var poljeTitle = document.getElementById("title");
        var title = document.getElementById("title").value;

        if (title.length < 5 || title.length > 30) {
            slanjeForme = false;
            poljeTitle.style.border="2px dashed red";
            document.getElementById("porukaTitle").innerHTML="Naslov vjesti mora imati između 5 i 30 znakova!<br>";
            document.getElementById("porukaTitle").style.color = "red";
        } else {
            poljeTitle.style.border="2px solid green";
            document.getElementById("porukaTitle").innerHTML="";
        }
        

        var poljeAbout = document.getElementById("about");
        var about = document.getElementById("about").value;

        if (about.length < 10 || about.length > 100) {
            slanjeForme = false;
            poljeAbout.style.border="2px dashed red";
            document.getElementById("porukaAbout").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
            document.getElementById("porukaAbout").style.color = "red";

        } else {
            poljeAbout.style.border="2px solid green";
            document.getElementById("porukaAbout").innerHTML="";
        }

        var poljeContent = document.getElementById("content");
        var content = document.getElementById("content").value;

        if (content.length == 0) {
            slanjeForme = false;
            poljeContent.style.border="2px dashed red";
            document.getElementById("porukaContent").innerHTML="Sadržaj mora biti unesen!<br>";
            document.getElementById("porukaContent").style.color = "red";
            
        } else {
            poljeContent.style.border="2px solid green";
            document.getElementById("porukaContent").innerHTML="";
        }

        var poljeSlika = document.getElementById("pphoto");
        var pphoto = document.getElementById("pphoto").value;

        if (pphoto.length == 0) {
            slanjeForme = false;
            poljeSlika.style.border="2px dashed red";
            document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>";
            document.getElementById("porukaSlika").style.color = "red";
        } else {
            poljeSlika.style.border="2px solid green";
            document.getElementById("porukaSlika").innerHTML="";
        }

        var poljeCategory = document.getElementById("category");

        if(document.getElementById("category").selectedIndex == -1) {
            slanjeForme = false;
            poljeCategory.style.border="2px dashed red";
            document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>";
            document.getElementById("porukaKategorija").style.color = "red";
        } else {
            poljeCategory.style.border="2px solid green";
            document.getElementById("porukaKategorija").innerHTML="";
        }
        
        if (slanjeForme == false) {
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
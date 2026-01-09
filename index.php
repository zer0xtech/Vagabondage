<?php
require('config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $session_connecte = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel= "stylesheet" href="index.css">
    <title>Document</title>
</head>

<body>
    <div class="barrenav">
        <div class="SiteLogo">
            <a id="LienLogo" href="#"><img src="images\VagabondLogo.jpg" style="width: 100px; min-width: 33px;"></a>
        </div>
        <div>
            <a href="#">Accueil</a>
        </div>
        <div class ="BoutonRecherche">
            <input type="search" placeholder="Miyamoto, chapitre 328..."/>
            <button>Chercher</button>
        </div>
        <div>
            <?php
            if (!$session_connecte = true) {
                echo '<a href="upload.php">Créer</a>';
            }
            ?>
        </div>
        <div class="BoutonProfil">
            <?php
            if (isset($_SESSION['id'])) {
                echo '<a href="profile.php?id=' . $_SESSION['id'] . '">Profil</a>';
            } else {
                echo '<a href="login.php">Connexion</a>';
            }
            ?>
        </div>
        <div>
            <?php
            if ($session_connecte = true) {
                echo '<a href="logout.php">Déconnexion</a>';
            }
            ?>
        </div>
    </div>

    <div class="gallery">
        <div class="publications">
            <div class="Username">
                <a href="profile.php">@LOIC_LE_GRAND</a>            
            </div>
            <div class="Images">
                <a href="content.php"><img src="images\GirlVaga.jpg" witdh="400px"; height="390px"></a>
            </div>
            <div class="BoutonsPosts">
                <a href="#"><button>AIMER &#129655;</button></a>
                <a href="upload.php"><button>PARTAGER &#128227;</button></a>
            </div>
            <div class="Likes">
                <p><strong>Aimé par : </strong>@OusmaneYang, @KINGSULLY, @MatysDuBrana, @SachO, <u>voir plus (117)</u></p>
            </div>
            <div class="Description">
                <p>#foryou #vagabond #otsu #trend #manga #miyamotomusashi #takezo #shinmentakezo #anitok #7kcc c#viral #vagabondmangaedit #matahachihoniden</p>
            </div>
            <div class="Commentaires">
                <input type="search" placeholder="Publier un commentaire :"/>
                <button>POSTER</button>
                <div class="EspaceCommentaires">
                    <p>@KINGSULLY : ca tue de fou frérot<br>@ : Merci pour tout<br>@SachO : Classique.</p>
                </div>
            </div>
        </div>
        <div class="publications">
            <div class="Username">
                <a href="profile.php">@ousmaneyang</a>           
            </div>
            <div class="Images">
                <a href="content.php"><img src="images\MiyamotoMusashiVagabond.png" witdh="400px"; height="390px"></a>
            </div>
            <div class="BoutonsPosts">
                <a href="#"><button>AIMER &#129655;</button></a>
                <a href="upload.php"><button>PARTAGER &#128227;</button></a>
            </div>
            <div class="Likes">
                <p><strong>Aimé par : </strong>@MatysDuBrana, @KINGSULLY, @C0RENT1N, @ADE, @DDENDEN, <u>voir plus (83)</u></p>
            </div>
            <div class="Description">
                <p>i love the manga so much... #fypシ #manga #mangarecommendation #vagabond #mangaedit #mangatiktok #mangacollection #seinen</p>
            </div>
            <div class="Commentaires">
                <input type="search" placeholder="Publier un commentaire :"/>
                <button>POSTER</button>
                <div class="EspaceCommentaires">
                    <p>@KINGSULLY : Type shit type shit<br>@C0RENT1N : Voilààà<br>@ProstARTHUR : PEAK.</p>
                </div>
            </div>
        </div>
        <div class="publications">
            <div class="Username">
                <a href="profile.php">@KINGSULLY</a>      
            </div>
            <div class="Images">
                <a href="content.php"><img src="images\MusachiLooking.png" witdh="400px"; height="390px"></a>
            </div>
            <div class="BoutonsPosts">
                <a href="#"><button>AIMER &#129655;</button></a>
                <a href="upload.php"><button>PARTAGER &#128227;</button></a>
            </div>
            <div class="Likes">
                <p><strong>Aimé par : </strong>@OusmaneYang, @SachO, @R4Darme, @OzmeNari0, @uull, @LOIC_LE_GRAND, <u>voir plus (51)</u></p>
            </div>
            <div class="Description">
                <p>MY GOAT #foryou #vagabond #otsu #trend #mercipourtout #FYP #fyp #mangacollector#mangatheque #miyamotomusashi #kojirosasaki #figurine</p>
            </div>
            <div class="Commentaires">
                <input type="search" placeholder="Publier un commentaire :"/>
                <button>POSTER</button>
                <div class="EspaceCommentaires">
                    <p>@wailLA : Insane... @LOIC_LE_GRAND : Amazing!! @OSCARDIAAAAAZ : wow</p>
                </div>
            </div>
        </div>
        <div class="publications">
            <div class="Username">
                <a href="profile.php">@Gaetan.T</a>           
            </div>
            <div class="Images">
                <a href="content.php"><img src="images\Vagabond3.jpg" witdh="350px"; height="390px"></a>
            </div>
            <div class="BoutonsPosts">
                <a href="#"><button>AIMER &#129655;</button></a>
                <a href="upload.php"><button>PARTAGER &#128227;</button></a>
            </div>
            <div class="Likes">
                <p><strong>Aimé par : </strong>@LOIC_LE_GRAND, @PIERreeeee, @ahhron, @ProstARTHUR, <u>voir plus (17)</u></p>
            </div>
            <div class="Description">
                <p>#vagabondmanga #mangahaul #mangacollection #mangacollector #deluxemanga #anitok c#viral #vagabondmangaedit #matahachihoniden</p>
            </div>
            <div class="Commentaires">
                <input type="search" placeholder="Publier un commentaire :"/>
                <button>POSTER</button>
                <div class="EspaceCommentaires">
                    <p>@HAM00DY : dang, looks peak @MatysDuBrana : il est làààà @duckies : best manga</p>
                </div>
            </div>
        </div>
        <div class="publications">
            <div class="Username">
                <a href="profile.php">@Sachoo</a>          
            </div>
            <div class="Images">
                <a href="content.php"><img src="images\Miyamoto2.jpg" witdh="300px"; height="390px"></a>
            </div>
            <div class="BoutonsPosts">
                <a href="#"><button>AIMER &#129655;</button></a>
                <a href="upload.php"><button>PARTAGER &#128227;</button></a>
            </div>
            <div class="Likes">
                <p><strong>Aimé par : </strong>@HAYAAN, @MMHUGO, @aallexiss, @timoté, @duckies9292, @MATT, <u>voir plus (7)</u></p>
            </div>
            <div class="Description">
                <p>#foryou #manga #fyp #mangacollection #takehikoinoue #anime #animeedit #animanga #peak #peakfiction #banger #jepleure</p>
            </div>
            <div class="Commentaires">
                <input type="search" placeholder="Publier un commentaire :"/>
                <button>POSTER</button>
                <div class="EspaceCommentaires">
                    <p>@MATT : better than 86?? @HAYAAN : art goes crazy @YacinGOATED : t'es bon, t'es bon</p>
                </div>
            </div>
        </div>
        <div class="publications">
            <div class="Username">
                <a id="User" href="profile.php">@wailLA</a>           
            </div>
            <div class="Images">
                <a href="content.php"><img src="images\Vagabond1.jpg" witdh="350px"; height="390px"></a>
            </div>
            <div class="BoutonsPosts">
                <a href="#"><button>AIMER &#129655;</button></a>
                <a href="upload.php"><button>PARTAGER &#128227;</button></a>
            </div>
            <div class="Likes">
                <p><strong>Aimé par : </strong>@OSCARDIAAAAAZ, @toto, @YacinGOAT, @alexisMaisV2, @wailLA, <u>voir plus (72)</u>...</p>
            </div>
            <div class="Description">
                <p>#lesitedefouque #jeviensdefaire #ptncestvraimentunebeauté #pourlesyeuxmeme #siyapasdejs #nahsahcestincroyable</p>
            </div>
            <div class="Commentaires">
                <input type="search" placeholder="Publier un commentaire :"/>
                <button>POSTER</button>
                <div class="EspaceCommentaires">
                    <p>@PIERreeeee : énorme @LOIC_LE_GRAND : pedri>> @KINGSULLY : &#129351</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
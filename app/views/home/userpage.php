<!DOCTYPE html>
<html>

<head>
    <!-- make page responsive-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Garbage Site">
    <link rel="stylesheet" href="/public/static/style.css">
    <link rel="stylesheet" href="/public/static/loginStyle.css">
    <link rel="stylesheet" href="/public/static/style-events.css">
    <title>User Page</title>
    <script src="https://kit.fontawesome.com/342e71a7d6.js" crossorigin="anonymous" async></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js" async></script>
    <script type="text/javascript" src="/public/static/js/misc.js"></script>
    <script type="text/javascript" src="/public/static/js/recycle_info.js"></script>
    <script type="text/javascript" src="/public/static/js/map.js"></script>
    <script type="text/javascript" src="/public/static/js/event.js"></script>
    <!-- for mapbox -->
    <!--    <script src='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js'></script>-->
    <!--    <link href='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css' rel='stylesheet' />-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin="" async></script>
    <!-- <script type="text/javascript" src="../static/js/map.js"></script> -->
</head>

<body>
<!--Menu-->
<nav class="navbar" id="Bar">
    <div class="menu-container">

        <div class="dropdown">
            <!-- Butonum Menu Options pentru ecrane mici-->
            <button class="navbutton" onclick="hide('drop1')">Menu</button>
            <!-- Lista dropDown cu optiunile din meniu pentru ecrane mici-->
            <div class="dropdownlist" id="drop1" style="display:none;">
                <a href="#Evenimente" class="droplink"><i class="fas fa-recycle"></i>Evenimente</a>
                <a href="#Reciclare" class="droplink"><i class="fas fa-recycle"></i> Cum să reciclăm?</a>
                <a href="#Situatia" class="droplink"><i class="fas fa-recycle"></i> Raportează o problemă</a>
                <a href="#Informatie" class="droplink"><i class="fas fa-recycle"></i> Informații adiționale</a>
                <a href='stats' class="droplink"><i class="fas fa-recycle"></i> Statistici</a>
                <?php if ($_SESSION['IS_ADMIN'] ?? false) { ?>
                    <a class="droplink" onclick="document.getElementById('id04').style.display='block'"><i
                                class="fas fa-recycle"></i>Creează un raport</a>
                <?php } ?>
                <a href='logout' class="droplink"><i class="fas fa-recycle"></i> Logout</a>
            </div>
            <!--            <button class="navbutton" onclick="document.location.href='logout'">Logout</button>-->
        </div>

        <ul class="menu-options">
            <!-- Butoanele din meniul principal-->
            <li class="option"><a href="#Evenimente" class="navbarlink"><i class="fas fa-recycle"></i>
                    Evenimente</a>
            </li>
            <li class="option"><a href="#Reciclare" class="navbarlink"><i class="fas fa-recycle"></i> Cum să
                    reciclăm?</a>
            </li>
            <li class="option"><a href="#Informatie" class="navbarlink"><i class="fas fa-recycle"></i>
                    Informații adiționale</a>
            </li>
            <li class="option"><a href="#Situatia" class="navbarlink"><i class="fas fa-recycle"></i> Raportează o
                    problemă</a></li>
            <li class="option"><a href='stats' class="navbarlink"><i class="fas fa-recycle"></i> Statistici</a></li>


            <?php if ($_SESSION['IS_ADMIN'] ?? false) { ?>
                <li class="option"><a class="navbarlink"
                                      onclick="document.getElementById('id04').style.display='block'"><i
                                class="fas fa-recycle"></i>Creează un raport</a></li>
            <?php } ?>
            <li class="option"><a href='logout' class="navbarlink"><i class="fas fa-recycle"></i> Logout</a></li>


        </ul>

    </div>
</nav>
<!-- PROFILE -->
<!-- <section id="Profil">
<div class="card">
    <img src="/public/static/images/avatar.png" alt="Default"
         style="width:100%; border-radius:4px">
    <h1>Generic Name</h1>
    <p class="usertitle">Citizen</p>
    <p>Region</p>
    <p>Some info about the dude</p>
    <p>
        <button style="width:100%" class="authentificationBtn">See Profile</button>
    </p>
</div>
</section> -->

<!-- Events -->
<!-- card -->
<section id="Evenimente">
    <div class="title-event"> Ajuta natura! Participa la evenimentele de ecologizare!</div>
    <div class="card-container">
        <?php if (isset($data)) {
            foreach ($data['events'] as $event) { ?>
                <div class="card">
                    <header class="article-header">
                        <div class="event-date">
                            <span class="date"><?= $event['data'] ?></span>
                        </div>
                        <h2 class="article-title">
                            <?= $event['titlu'] ?>
                        </h2>
                    </header>
                    <div class="event-details">
                        <?= $event['detalii'] ?>
                    </div>

                    <div class="tags">
                        <?php
                        foreach (explode(",", $event['tags']) as $tag) {
                            if (!empty($tag)) {
                                echo "<div>$tag</div>";
                            }
                        }
                        ?>
                    </div>
                    <button class="see-more" onclick="showDetails(<?=$event['id']?>)">Vezi mai mult</button>
                <?php if ($_SESSION['IS_ADMIN'] ?? false) { ?>
                    <button class="deleteBtn" onclick="deleteEvent(<?=$event['id']?>)">Sterge eveniment</button>
                <?php } ?>
                </div>
            <?php }
        } ?>
        <!-- card for admin -->
        <?php if ($_SESSION['IS_ADMIN'] ?? false) { ?>
            <div class="card" id="adminCard">
                <header class="article-header">
                    <div class="event-date">
                        Data:
                        <input type="date" id="event-date" required>
                    </div>
                    <h2 class="article-title">
                        Scrie un titlu:
                        <input type="text" id="text-article" required>
                    </h2>
                </header>
                <textarea id="event-details" cols="20"  placeholder="Adauga O Descriere Scurta"></textarea>
                <textarea id="event-description" cols="20"  placeholder="Scrie Toate Detaliile"></textarea>
                <div class="tags">
                    Adauga 3 tag-uri importante:
                    <input type="text" class="tag-article" required>
                    <input type="text" class="tag-article" required>
                    <input type="text" class="tag-article" required>
                </div>
                <div id="error-message-admin"></div>
                <button type="submit" class="createEvent" onclick="saveEvent()">Creaza Eveniment!</button>
            </div>
        <?php } ?>

</section>

<!-- HOW TO RECYCLE -->
<section id="Reciclare">

    <div class="garbage-info">
        <div class="garbage-type">
            <button onclick="revealInfo('hartie')"><i class="fas fa-newspaper"></i> Hârtie</button>
            <button onclick="revealInfo('becuri')"><i class="fas fa-lightbulb"></i> Becuri</button>
            <button onclick="revealInfo('plastic')"><i class="fas fa-shopping-bag"></i> Plastic</button>
            <button onclick="revealInfo('metal')"><i class="fas fa-tools"></i> Metal</button>
            <button onclick="revealInfo('sticla')"><i class="fas fa-wine-bottle"></i> Sticlă</button>
            <button onclick="document.location.href='info'"><i class="fas fa-info-circle"></i> Mai mult</button>

        </div>

        <div class="content">
            <div class="recycleElement hartie">
                <h1>Hârtia – salvează copacii pentru un aer mai curat</h1>
                <p>
                    <b>De ce să reducem consumul și să reciclăm hârtia?</b><br> Hârtia consumată de fiecare dintre noi
                    înseamnă cam 6 copaci tăiaţi pe an. Dacă aceste cifre nu sunt impresionante, următoarele cu
                    siguranță vor fi. Știați că circa 50.000
                    tone de hârtie ajung la gropile de gunoi în fiecare an fără a fi recuperate? Oxigenul necesar pentru
                    320 de oameni ajunge astfel la gunoi.
                    <br><br><b>Cum reducem consumul de hârtie?</b><br> Câțiva pași simpli pe care să îi urmați
                    indiferent dacă sunteți încă pe băncile școlii sau desfășurați o muncă de birou:
                </p>
                <ul>
                    <li> Folosiți caietele și agendele până la ultima pagină!</li>
                    <li> Dacă mai rămân pagini, folosiți-le drept ciorne!</li>
                    <li> Fotocopiază şi imprimă faţă-verso!</li>
                </ul>
                <p>
                    Reciclarea face parte și ea din metodele de reducere a consumul de hârtie. Acasă sau la școală
                    colectați hârtia separat pentru a o duce la centrele de reciclare. Ambalajele din carton pentru
                    lapte și suc conțin fibră de cea mai bună calitate și de asemenea
                    este important să le reciclăm. Există însă și hârtie care nu se reciclează: șervețelele de hârtie,
                    hârtia cu capse, hârtia cerată, pungile din hârtie impermeabilă, hârtia deteriorată prin putrezire
                    și hârtia murdărită de mâncare.
                    Chiar dacă vă gândiți că faceți un bine, uitați de ambalajele de fastfood sau pungile de cadouri.
                </p>
            </div>
            <div class="recycleElement becuri">
                <h1>Becuri, neoane, baterii - o categorie specială de deșeuri</h1>
                <p>
                    Indiferent de dimensiunea acestora, bateriile conțin o serie de metale valoroase, cum ar fi
                    nichelul, cobaltul şi argintul, a căror recuperare înseamnă reducerea consumului acestora. În plus,
                    bateriile conţin o serie de materiale periculoase cum ar fi
                    mercur, nichel, plumb, cadmiu, litiu. Mercurul dintr-o baterie de tip pastilă poate polua 500 de
                    litri de apă sau un metru pătrat de sol pe o perioadă de 50 de ani. Tocmai de aceea este bine să vă
                    faceți o obișnuință din reciclarea
                    bateriilor, acumulatorilor mici sau bateriilor şi acumulatorilor auto. Ați observat deja că
                    producătorii au înlocuit becurile tradiționale cu cele economice care consumă de 5 ori mai puțin
                    decât becurile cu filament. Efectul direct
                    se simte în economiile din factura de energie electrică care ajung la 50 de euro anual. Reducerea
                    consumului de electricitate are însă un efect benefic și asupra mediului deoarece duce la scăderea
                    emisiilor de gaze cu efect de
                    seră. De ce să reciclăm becurile? Unele becuri conţin mercur, care este foarte toxic şi poate crea
                    probleme de mediu dacă este depozitat necorespunzător. În plus, becurile conţin componente
                    electronice ce pot fi refolosite sau
                    reciclate. Becurile și bateriile uzate se pot depune pentru reciclare la punctele special amenajate
                    din hipermarket-uri sau centre comerciale iar bateriile auto folosite pot fi duse la magazinul de
                    unde se va cumpăra următorul
                    acumulator.
                </p>
            </div>
            <div class="recycleElement plastic">
                <h1>Plasticul se degradează în 500 de ani</h1>
                <p>
                    <b>De ce să reducem consumul și să reciclăm plasticul?</b><br> Plasticul ajunge în natură unde se
                    degradează în 500 de ani! Estimările oamenilor de știință, arată că pe mări și oceane plutesc 159
                    milioane de kilograme de deşeuri
                    din plastic. Plasticul din oceane ucide 1.000.000 de păsări și 100.000 de mamifere marine anual.
                    Dacă vi se pare că aceasta nu vă afectează și pe voi, mai avem un argument în favoarea reciclării.
                    Știați că plasticul se descompune
                    în bucăţi şi particule foarte mici care sunt consumate de organismele marine, care sunt consumate de
                    pești și în final ajung în om? Producţia de plastic utilizează 8% din producţia de petrol a
                    globului. O tonă de sticle de plastic
                    reciclate înseamnă 1,5 tone de dioxid de carbon mai puțin în atmosferă. Prin reciclarea unei singure
                    sticle de plastic economisim energie care ar putea ţine aprins un bec timp de 6 ore.
                    <br><br><b>Cum să reciclăm plasticul?</b><br> Acum că v-am convins de importanța reciclării
                    pasticului, iată cum o puteți face corect. În containerul pentru plastic își găsesc locul sticlele
                    PET, diverse ambalaje și vase de plastic,
                    caserole, pungi, CD-uri și DVD-uri. Pentru a folosi spaţiul de depozitare la maximum, este
                    recomandat să turtiți PET-urile şi ambalajele de plastic. În containerul pentru plastic nu aruncați
                    ambalajele cu urme de resturi menajere
                    sau farfuriile și paharele de unică folosință!
                </p>
            </div>
            <div class="recycleElement metal">
                <h1>Metalul– ușor de reciclat</h1>
                <p>
                    <b>Știați că aluminiul poate fi reciclat la nesfârşit fără să îşi piardă calităţile? Dar că o
                        doză
                        de aluminiu se degradează în circa 500 ani?</b><br> Data viitoare când consumați sucuri sau bere
                    la cutie puteți avea în vedere următoarele intormații cheie. Reciclând o doză de aluminiu se
                    economiseşte
                    energie pentru prelucrarea altor 20 de doze noi. Energia economisită prin reciclarea unei cutii de
                    aluminiu poate alimenta un televizor timp de trei ore. În containerul pentru Metale se pot colecta
                    doze de aluminiu, folii de aluminiu,
                    fier, cupru, agrafe de hârtie metalice. La fel ca în cazul celorlalte materiale care se reciclează,
                    dozele sau ambalajele care conţin resturi alimentare nu își au locul în container.</p>
            </div>
            <div class="recycleElement sticla">
                <h1>Sticla - rezistă un milion de ani fără să se degradeze</h1>
                <p>
                    <b>De ce să reciclăm sticla? </b><br>Sticla este unul dintre cele mai rezistente materiale,
                    degradarea acesteia având loc într-un milion de ani! Vestea bună este că se poate recicla 100% fără
                    a-şi pierde din proprietăţi. Un borcan
                    de sticlă conține energia necesară unui bec pentru a lumina timp de 4 ore. Atunci când pentru
                    producerea de sticle şi borcane noi se foloseşte sticlă reciclată, energia necesară pentru topire
                    este redusă. În containerul de colectare
                    selectivă pentru sticlă se pot aduna sticle, borcane și alte ambalaje din sticlă. Oglinda, becurile
                    și neoanele nu își au locul însă în aceste containere.
                </p>
            </div>
        </div>
    </div>

</section>
<!--USEFUL INFORMATION-->
<section id="Informatie">
    <div class="title">
        <div class="fas fa-info-circle title-event"> Aici sunt câteva informații utile</div>
    </div>
    <div class="info-content">
        <div class="info">
            <img src="/public/static/images/deseuri.jpg" alt="image" class="info-image">
            <a href="https://salubris.ro/servicii/colectarea-separata-a-deseurilor/" rel="noreferrer" target=" _blank">Colectarea
            separată
            a
            deșeurilor</a>
        </div>
        <div class="info">
            <img src="/public/static/images/deseuri.jpg" alt="image" class="info-image">
            <a href="https://salubris.ro/orasul-verde/impreuna-colectam-separat/activitati-de-promovare-a-colectarii-separate/"
               rel="noreferrer"
               target=" _blank">Activități de promovare a colectării separate</a>
        </div>
        <div class="info">
            <img src="/public/static/images/deseuri.jpg" alt="image" class="info-image">
            <a href="https://salubris.ro/orasul-verde/impactul-colectarii-separate/" rel="noreferrer" target=" _blank">Impactul
            colectării
            separate</a>
        </div>
    </div>
</section>
<!-- YOUR SITUATION -->

<section id="Situatia">
    <div class="situation-elements">
        <div class="map-container">
            <div id="map" class="map-controller"></div>
        </div>
    </div>
</section>
<!-- ISSUE	-->
<div id="id03" class="modal">
    <form id="rform" class="modal-content animate" onsubmit="repForm()">
        <div>
            <!-- choose a type of problem -->
            <select id="issues" name="issues">
                <option value="" disabled selected>Alege tipul de problema pe care o ai</option>
                <option value="1">Deșeuri pe stradă</option>
                <option value="2">Colectare a gunoiului necorespunzătoare</option>
            </select>
            <label for="reporttext">Detalii:</label>
            <textarea id="reporttext" rows="5" cols="60" placeholder="Detalii problemă"></textarea>
        </div>
        <div>
            <button type="submit" class="submitbutton" onclick="document.getElementById('id03').style.display='none'"
                    formaction="javascript:;">
                Submit
            </button>
        </div>
        <div>
            <button type="button" class="cancelbutton" onclick="document.getElementById('id03').style.display='none'">
                Cancel
            </button>
        </div>
    </form>
</div>
<!--Report-->
<div id="id04" class="modal">
    <form id="materials" onsubmit="matForm()">
        <div class="content-raport-employee">
            <!-- choose tha street -->
            <select id="place" name="location">
                <option value="" disabled selected>Alege zona pentru care vrei sa faci raportarea</option>
                <?php
                if (isset($data)) {
                    foreach ($data['locations'] as $loc) {
                        echo '<option>' . $loc . '</option>';
                    }
                }
                ?>
            </select>
            <select id="mtype" name="type">
                <option value="" disabled selected>Alege tipul de raport</option>
                <option value="1">Materiale colectate</option>
                <option value="2">Materiale reciclate</option>
            </select>
            <input type="number" name="paper" placeholder="Cantitatea de hartie">
            <input type="number" name="plastic" placeholder="Cantitatea de plastic">
            <input type="number" name="glass" placeholder="Cantitatea de sticla">
            <input type="number" name="waste" placeholder="Cantitatea de deseuri menajere">
            <input type="number" name="metal" placeholder="Cantitatea de metal">
            <input type="number" name="mixedGarbage" placeholder="Deseuri mixte/nesortate">
            <button type="submit" class="submitbutton" formaction="javascript:;">Submit</button>
            <button type="button" class="cancelbutton" onclick="document.getElementById('id04').style.display='none'">
                Cancel
            </button>
        </div>
    </form>
</div>
<!--Card Information-->
<div id="id05" class="modal">
    <div class="card-info">
        <div id="modal-content-05"></div>
        <button class="closeBtn" onclick="document.getElementById('id05').style.display='none'">Închide</button>

    </div>
</div>
<!-- FOOTER -->
<footer>
    <div class="projectInfo">
        <div class="authors">
            Iuliana Holban & Simona Sîrbu & Constantin Suruniuc
        </div>
        <div class="docInfo">
            <button class="docBtn" onclick="document.location.href='doc'"> Documentatia Tehnica</button>
            <button  class="docBtn" onclick="document.location.href='userGuide'">Ghidul utilizatorului</button>
        </div>
    </div>
</footer>

<script>
    window.onload = initMap;
</script>

<!--<script>-->
<!--mapboxgl.accessToken = 'pk.eyJ1IjoiaXVsaWZlaWYiLCJhIjoiY2s5eDB4aTFmMGVldjNla29tMzNpd291NyJ9.iVjuD8Ffuo-D6x3ZN2f3rg';-->
<!--var map = new mapboxgl.Map({-->
<!--container: 'map', // container id-->
<!--style: 'mapbox://styles/mapbox/streets-v11',-->
<!--center: [27.58, 47.17], // starting position-->
<!--zoom: 9 // starting zoom-->
<!--});-->
<!---->
<!--// Add zoom and rotation controls to the map.-->
<!--map.addControl(new mapboxgl.NavigationControl());-->
<!---->
<!--</script>-->

</body>

</html>
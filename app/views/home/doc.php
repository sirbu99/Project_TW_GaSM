<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>GaSM Scholarly HTML</title>
    <link rel="stylesheet" href="scholarly.css">
    <link rel="stylesheet" href="/public/static/docStyle.css">
</head>

<body>
<section class="docBackground">
<section>
    <header >
        <h2 class="centerText">Garbage Smart Monitor - GaSM</h2>
    </header>
    <div>
        <ol>
            <li>
                <span>Iuliana</span>
                <span>Holban</span>
            </li>
            <li>
                <span>Simona</span>
                <span>Sîrbu</span>
            </li>
            <li>
                <span>Constantin</span>
                <span>Suruniuc</span>
            </li>
        </ol>
    </div>
    <section>
        <h2>Abstract</h2>
        <p>
            Să se creeze o aplicație Web capabilă, pe baza unui API REST/GraphQL propriu, să gestioneze informațiile
            privitoare la colectarea, sortarea și reciclarea gunoiului – pe categorii: menajer, hârtie, plastic etc.
            – la nivelul cetățeanului, personalului autorizat și factorilor de decizie.<br>

            Se va oferi suport pentru raportarea de către utilizatori a locurilor unde s-a acumulat o cantitate
            substanțială de gunoi, în vederea descongestionării. Pe unitate de timp (zi, săptămână, lună), vor fi
            generate rapoarte numerice și grafice – disponibile în formatele HTML, CSV și PDF – referitoare la
            situația actuală la nivel de cartier/localitate, evidențiindu-se zonele cele mai curate/mizere.<br>

            Interacțiunea cu utilizatorul va respecta principiile designului Web responsiv. Sistemul va oferi suport
            și pentru inițierea unor campanii de sensibilizare a locuitorilor privitoare la colectarea selectivă a
            gunoiului și a raportării incidentelor vizând depozitarea neadecvată a acestuia.<br>
        </p>
    </section>
    <section>
        <h2>Motivație</h2>
        <p>
            Aplicația are ca și scop gestionarea informațiilor despre colectarea și reciclarea gunoiului, procesarea
            acestora în rapoarte și grafice utile, informarea utilizatorilor despre evenimente ecologice și preluarea
            informațiilor de la utilizatori despre cantități excesive de gunoi și colectarea necorespunzătoare a
            gunoiului.
        </p>
    </section>
    <section>
        <h2>Structură</h2>
        <ul>
            <li>Pagină de login/register</li>
            <li>Pagina principală care conține:</li>
            <ul>
                <li>Listă cu evenimente</li>
                <li>Informații despre reciclare</li>
                <li>Hartă pentru raportarea de probleme</li>
            </ul>
            <li>Pagină cu informații în detaliu despre reciclare</li>
            <li>Pagină pentru vizualizarea și descărcarea de statistici</li>
            <li>API pentru inserarea și preluarea de informații</li>
        </ul>
        <section>
            <h2>Login/Register</h2>
            <p>
                User-ul se poate autentifica cu ajutorul email-ului si a unei parole si se poate înregistra cu : nume, prenume, email, parola și locație. 
            </p>
            <img src="/public/static/images/documentation/login.png" alt="image" class="center">
            <img src="/public/static/images/documentation/register.png" alt="image" class="center">
        </section>
        <section>
            <h2>Pagina principală</h2>
            <p>
                Sistemul oferă suport pentru inițierea unor campanii de sensibilizare a locuitorilor privitoare la colectarea selectivă a gunoiului prin oferirea posibilității de a participa la evenimente. Un utilizator simplu poate vizualiza lista de evenimente, iar dacă este interesat de eveniment, poate vedea mai multe informații apăsând pe butonul "Vezi mai mult". Aici utilizatorul va avea afișate toate detaliile despre eveniment si va putea scrie comentarii. Un admin poate adăuga și șterge un eveniment.
            </p>
            <img src="/public/static/images/documentation/event_admin.PNG" alt="image" class="center">
            <img src="/public/static/images/documentation/eventUser.PNG" alt="image" class="center">
            <img src="/public/static/images/documentation/eventDescription.PNG" alt="image" class="center">

            <p>
                User-ul are la dispoziție informații pe scurt despre modul în care trebuie să recicleze, iar dacă dorește sa citeasca mai în detaliu, are la dispoziție butonul 'mai mult', care îl va redirecționa la pagina cu toate informațiile disponibile.

            </p>
            <img src="/public/static/images/documentation/info.png" alt="image" class="center">
            <img src="/public/static/images/documentation/infoPage.PNG" alt="image" class="center">
            <p>
                Sistemul oferă și posibilitarea de a raporta anumite probleme legate de cantități excesive de gunoi și colectarea necorespunzătoare a
                gunoiului. Pentru a putea crea un raport, utilizatorul trebuie sa aleaga locatia respectivă pe hartă și să completeze informațiile cerute.
            </p>
            <img src="/public/static/images/documentation/harta.png" alt="image" class="center">

            <p>
                Pentru utilizatorii care sunt admini, sistemul ofera si posibilitatea de a creea un raport cu detalii despre colectarea / reciclarea gunoiului (butonul "Creează un raport" din meniu).
            </p>
            <img src="/public/static/images/documentation/report.png" alt="image" class="center">

        </section>
        <section>
            <h2>Pagina pentru vizualizarea și descărcarea de statistici</h2>
            <p>
                Pagina poate fi accesata cu ajutorul butonului din meniu "Statistici". Ea pune la dispoziție posibilitatea de a descărca rapoarte în format JSON sau CSV pentru anumite perioade (zi/luna). Deasemenea în pagina sunt afișate grafice care reprezintă situația actuală. În pagină mai este afișată o harta care ofera informatii despre numărul și tipul de plângeri depuse pentru o anumită zonă.
            </p>
            <img src="/public/static/images/documentation/reports.png" alt="image" class="center">
            <img src="/public/static/images/documentation/map.png" alt="image" class="center">

        </section>
        <section>
            <h2>API pentru inserarea și preluarea de informații</h2>
            <p></p>
        </section>
    </section>
    <h2 class="centerText">Detalii tehnice</h2>
    <hr>
    <section>
        <h2>Register</h2>
        <p>Funcția javascript de mai jos preia datele din formularul pentru înregistrare, verifică dacă informațiile sunt valide și le trimite către funcția register() din API, care va salva datele în baza de date.</p>
        <pre>
            async function register(e)
            {
                e.preventDefault();
                const email = document.getElementById('register-email').value;
                const first_name= document.getElementById('fname').value;
                const last_name= document.getElementById('lname').value;
                const pass1= document.getElementById('pass1').value;
                const pass2= document.getElementById('pass2').value;
                const street= document.getElementById('street').value;
                if (!document.getElementById('register').checkValidity()) {
                    document.getElementById('register').reportValidity();
                    document.getElementById("error-message-register").innerHTML = 'Formular invalid!';
                    return false;
                }

                if (pass1 !== pass2) {
                    document.getElementById("error-message-register").innerHTML = 'Parolele nu coincid!';
                    return false;
                }

                const response = await fetch("/home/register", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: serialize({email,first_name,last_name,password:pass1,pass2,street})
                })
                    .then(data => {
                        if (data.status === 400) {
                            document.getElementById("error-message-register").innerHTML = 'Email deja existent';
                        }
                        if (data.status === 200) {
                             window.location.href = "/home";
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        </pre>
        <p>Funcția register() care salvează datele:</p>
        <pre>
            public function register()
            {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $conn = Database::instance()->getconnection();
                    $query = "SELECT * FROM users where email = ?";
                    $statement = $conn->prepare($query);
                    if (!$statement) {
                        die('Error at statement' . var_dump($conn->error_list));
                    }
                    $statement->bind_param('s', $email);
                    $email = $_POST['email'];
                    $statement->execute();
                    $result = $statement->get_result();
                    if ($result->num_rows > 0)
                    {
                        http_response_code(400);
                        exit;
                    }

                    $query = "INSERT INTO users values(null, ?, ?, ?, ?, ?, ?)";
                    $statement = $conn->prepare($query);
                    if (!$statement) {
                        die('Error at statement' . var_dump($conn->error_list));
                    }
                    $statement->bind_param('ssssdd', $firstname, $lastname, $email, $password, $location, $admin);
                    $firstname = $_POST['first_name'];
                    $lastname = $_POST['last_name'];
                    $email = $_POST['email'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    var_dump($_POST);
                    $admin = 0;
                    $location = $_POST['street'] ?? 1;
                    $statement->execute();
                    exit;
                } else {
                    http_response_code(405);
                    require_once ERROR_PATH . '405_error.php';
                }
            }
        </pre>
    </section>
    <hr>
    <section>
        <h2>Middlewares</h2>
        <p>Am creat 2 clase pentru Middleware: AuthMiddleware și RolesMiddleware. </p>
        <p>AuthMiddleware interzice accesarea altor link-uri decât cele disponibile.</p>
        <pre>
            class AuthMiddleware
            {

                const EXCLUDED_PAGES = [
                    'home:loginpage',
                    'home:login',
                    'home:register',
                    'home:statistics',
                    'home:page_404',
                ];

                public static function run($controller, $method)
                {
                    $isLoggedIn = $_SESSION['LOGGED_IN'] ?? false;
                    $myRoute = strtolower(get_class($controller) . ":" . $method);
                    return  $isLoggedIn || in_array($myRoute, self::EXCLUDED_PAGES);
                }
            }
        </pre>
        <p>RolesMiddleware interzice efectuarea operaților precum insearea datelor/evenimentelor pentru utilizatorii simpli.</p>
        <pre>
            class RolesMiddleware
            {
                const ADMIN_PAGES = [
                    'api:insertdata',
                    'api:insertevent',
                    'api:deleteEvent',
                ];

                public static function run($controller, $method)
                {
                    $myRoute = strtolower(get_class($controller) . ":" . $method);
                    if (in_array($myRoute, self::ADMIN_PAGES) && empty($_SESSION['IS_ADMIN'])) {
                        return false;
                    }
                    return true;
                }
            }
        </pre>

    </section>
    <hr>
    <section>
        <h2>Înserarea datelor</h2>
        <p>Funcția insertdata() permite unui admin sa adauge informații despre cantitățile de materiale reciclate. Ea este folosită pentru butoanele "Creeaza un raport" și pentru butonul de încărcare a unui raport. </p>
        <pre>
            public function insertdata()
            {
                $headers = apache_request_headers();
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $conn = Database::instance()->getconnection();
                    $query = 'insert into materials values (null,?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    $statement = $conn->prepare($query);
                    if (!$statement) {
                        file_put_contents('../app/logs/error.log', 'Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
                        http_response_code(500);
                        die;
                    }
                    $statement->bind_param('dsddddddd', $location, $date, $type, $paper, $metal, $waste, $glass, $plastic, $mixed);
                    if(in_array('application/json', $headers)){

                        $inputJSON = file_get_contents('php://input');
                        $input = json_decode($inputJSON, TRUE);
                        foreach ($input as $part){
                            $location = $this->getlocid($part['LocationName']);
                            $date = $part['Date'] ?? date('Y-m-d H:i:s');
                            $paper = $part['paper'] ?? 0;
                            $metal = $part['metal'] ?? 0;
                            $plastic = $part['plastic'] ?? 0;
                            $waste = $part['waste'] ?? 0;
                            $glass = $part['glass'] ?? 0;
                            $mixed = $part['mixed'] ?? 0;
                            $type = $part['type'] ?? 1;
                            $statement->execute();
                        }
                    }else{
                        $location = $this->getlocid($_POST['location']);
                        $date = date('Y-m-d H:i:s');
                        $paper = $_POST['paper'] ?? 0;
                        $metal = $_POST['metal'] ?? 0;
                        $plastic = $_POST['plastic'] ?? 0;
                        $waste = $_POST['waste'] ?? 0;
                        $glass = $_POST['glass'] ?? 0;
                        $mixed = $_POST['mixedGarbage'] ?? 0;
                        $type = $_POST['type'] ?? 1;
                        $statement->execute();
                    }

                    http_response_code(200);
                    exit;

                } else {
                    http_response_code(405);
                    require_once '../app/errors/405_error.php';
                }
            }
        </pre>

    </section>
    <hr>
    <section>
        <h2>Evenimente</h2>
        <p>La fel ca si insertdate(), insertevent() este o funcție care permite unui admin sa adauge un card cu eveniment.</p>
        <pre>
            public function insertevent()
            {
                if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                    http_response_code(405);
                    require_once '../app/errors/405_error.php';
                    exit;
                }
                file_put_contents('../app/logs/error.log', $_POST);
                $conn = Database::instance()->getconnection();
                $query = 'insert into event (titlu,data,id_autor,detalii, tags, descriere) values (?, ?, ?, ?, ?, ?)';
                $statement = $conn->prepare($query);
                if (!$statement) {
                    die('Error at statement' . var_dump($conn->error_list));
                }
                $statement->bind_param('ssdsss', $title, $date, $author_id, $details, $tags, $description);
                $date = $_POST["date"]; //validare si corectare format data
                $title = $_POST["title"];
                $author_id = intval($_SESSION["ID"] ?? 0);
                $details = $_POST["details"];
                $tags = $_POST["tags"];
                $description = $_POST["description"];

                $statement->execute();
                http_response_code(200);

            }

            <p>Funcția getEventInfo() va afișa un poup pentru utilizator/admin cu toate detaliile despre un eveniment.</p>
        <pre>
             public function getEventInfo()
            {
                if (!isset($_GET['id'])) {
                    return [];
                }
                $query = "select * from event where id = ?";
                $conn = Database::instance()->getconnection();
                $id_event = $_GET['id'];
                $statement = $conn->prepare($query);
                if (!$statement) {
                    file_put_contents('../app/logs/error.log','Error at statement' . var_dump($conn->error_list), FILE_APPEND | LOCK_EX);
                    http_response_code(500);
                    die;
                }
                if (isset($_GET['id'])) {
                    $statement->bind_param('d', $id_event);
                }
                $statement->execute();
                $result = $statement->get_result();
                header("Content-Type:application/json");
                $event = $result->fetch_assoc();
                $event['comments'] = $this->getComments($id_event);
                echo json_encode($event);
                exit;
            }
        </pre>

    </section>
    <hr>
    <section>
        <h2 class="centerText">Referințe</h2>
        <ul>
            <li>
                <a href="https://developer.mozilla.org/en-US/">MDN Web Docs</a>
            </li>
            <li>
                <a href="https://www.w3schools.com/">W3Schools</a>
            </li>
            <li>
                <a href="https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch">MDN - Fetch API</a>
            </li>
            <li>
                <a href="https://www.php.net/manual/ro/index.php">PHP Mannual</a>
            </li>
        </ul>
    </section>
</section>
</section>

</body>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>GaSM Scholarly HTML</title>
    <link rel="stylesheet" href="scholarly.css">
    <link rel="stylesheet" href="/public/static/docStyle.css">
</head>

<body>
<article>
    <header>
        <h1>GaSM</h1>
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
        </section>
    </section>
</article>

</body>
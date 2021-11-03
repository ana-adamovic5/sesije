<?php
 
/*
naša index.html stranica predstavlja samo skriptu koja će pozivati druge stranice da se učitaju
ne sadrži nikakav HTML




kreiramo asocijativni niz proizvoda
svaki clan niza predstavlja proizvod, opet u formi niza sa 3 parametra: cena, naziv, id
*/
    $proizvodi = array(
        array(
            'id' => 1,
            'naziv' => 'Knjiga',
            'cena' => 30.5
        ),
        array(
            'id' => 2,
            'naziv' => 'Lopta',
            'cena' => 67.45
        ),
        array(
            'id' => 3,
            'naziv' => 'Kisobran',
            'cena' => 203.7
        ),
        array(
            'id' => 4,
            'naziv' => 'Laptop',
            'cena' => 130.7
        )
    );
    
    /*
    svaka sesija treba da počne
    ovaj početak treba da se desi pre ispisivanja bilo kakvog HTML zato ga i pišemo ovde
    
    session_start(); automatski pokreće novu sesiju ili nastavlja postojeću
 
    Mi cemo kao parametar sesije kreirati korpu (ako on vec nije kreiran !isset($_SESSION['korpa'] ), kako bismo u njoj pamtili sve informacije vezane za kupovinu prozvoda. 
    Ta korpa će predstavljati na početku prazan niz, ali kasnije cemo tu pamtiti id svakog proizvoda kojeg budemo kupili
    */
    session_start();
    if(!isset($_SESSION['korpa'])){
        $_SESSION['korpa'] = array();
    }
    
 
 
 
    /* 
    narednim upitom proveravamo da li je neko kliknuo na dugme Kupi u našoj formi u katalog.php stranici, ako jeste hoćemo da obradimo tu kupovinu
    Ono sto je bitno napomenuti jeste da $_POST['submit'] proverava da li postoji polje poslato sa nazivom (name) submit, ne tipom (type)
    Ako pogledamo našu formu u katalogu 
    
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $proizvod['id'];?>">
        <input type="submit" name="submit" value="Kupi">
    </form>
 
    Možemo videti da nam je tipe dugmeta submit, ali da nam je naziv submit takođe. Vodimo računa da pri pozivu post varijable koristimo naziv (name)
    Takoođe bitno nam je koji je value našeg inputa, jer preko njega ćemo proveravati koje je dugme pritisnuto. Ovo smo mogli i da predupredimo tako što bismo naziv inputa promenili
    Više o POST metodi ovde https://www.php.net/manual/en/reserved.variables.post.php
 
    u našem konkretnom uslovu proveravamo da li $_POST['submit'] postoji, ako postoji da li je on jednak "Kupi" 
    ako jeste u našu sesiju - korpa dodajemo ID koji smo prosledili kao skriveno polje 
    $_SESSION['korpa'][] ova linija kaže da na prvo sledeće slobodno mesto dodam neku vrednost
    header('Location: .'); - ovaj header nam omogućava da nakon obrade forme odemo na određenu adresu, nekad će to biti home, nekad news feed,...
    sve zavisi od toga šta naša aplikacija treba da radi
    U našem slučaju ovo nas vodi na root folder, a kada porenemo root folder u lokalu po difoltu dobije index.php stranicu
    Ono što će se desiti jeste prikaz kataloga, koji je dole include-ovan.
    */
    if(isset($_POST['submit']) && $_POST['submit']=='Kupi'){
        $_SESSION['korpa'][] = $_POST['id'];
        header('Location: .'); 
        exit();
    }
    
    /*
    Ovaj uslov, slično kao prethodni proverava da li smo poslali POST zahtev sa name="submit" i value = "Isprazni",
    ako jesmo hocemo da obrisemo nasu korpu iz sesije i kao lokaciju da ostanemo na trenutnoj poziciji, odnosno u korpi.
    Pogledaj kasnija objasnjenja za ?vidi_korpu 
    */
    if(isset($_POST['submit']) && $_POST['submit']=='Isprazni'){
        unset($_SESSION['korpa']);
        header('Location: ?vidi_korpu');
        exit();
    }
    
    /*
    Napomenuli smo na vezbama da podaci ka serveru mogu da se salju i preko POST i preko GET metode
    razlika je u tome sto POST metoda salje zapakovane informacije u formi paketa koji kasnije odredjena funkcija ispituje
    dok GET metoda parametre salje preko URLa nakon ?
   
 Probajte ovaj primer:
 
    <?php
        echo 'Dobrodosli ' . htmlspecialchars($_GET["name"]) ." ". htmlspecialchars($_GET["surname"]). '!';
    ?>
    kao url u browser-u unesite sledece: 
http://localhost:8080/{NAZIV FOLDERA}}/{NAZIV FAJLA}.php?name=pera&surname=peric    
 
    U nasem uslovu obradjuemo klik na link vidi_korpu
    Kako smo do njega dosli?
    Ako odemo na katalog.php videcemo liniju <a href="?vidi_korpu" >Vidi korpu</a>
    Znamo da linkovi u okviru a tagova treba da vode na odredjenu stranicu u nasem slucaju mi ne zelimo samo da odemo na korpa.php
    jer prost odlazak tamo nam ne daje nista, potrebno nam je da prenesemo sve podatke o nasoj sesiji - korpa
    i to radi koristeci GET metodu
    anchor tagovi po difoltu koriste GET metode zbog linkova
    
    ako se desilo da je neko prosledio GET zahtev sa vidi_korpu (znak pitanja je samo token)
    hocemo da kreiramo promenljivu korpa kao prazan niz i ukupno kao vrednost u kojoj cemo upisivati ukupan iznos kupljenih proizvoda
    za svaki ID u sesiji-korpa i svaki proizvod u korpi, ako su id-evi isti, zelimo proizvod da stavimo u korpu
    i ukupan iznos da povecamo za cenu
 
    na kraju for-a, ali i dalje u okviru uslova zelimo da pozovemo korpa.php stranicu da se prikaze
    Poziv za prikazivanje pisemo unutar funkcije kako nam korpa ne bi uvek bila vidljiva, vec samo onda kada kliknemo na link
    */
 
    if(isset($_GET['vidi_korpu'])){
        $korpa = array();
        $ukupno = 0;
        foreach($_SESSION['korpa'] as $id){
            foreach($proizvodi as $proizvod){
                if($proizvod['id'] == $id){
                    $korpa[] = $proizvod;
                    $ukupno += $proizvod['cena'];
                    break;
                }
            }
        }
        
        include 'korpa.php';
        exit();
    }
 
 
    #katalog zelimo da uvek bude vidljiv na stranic
    
    include 'katalog.php';
    
 
 
    #primer vezan za dinamicke linkove
    include("dinamicki.html");
    if(isset($_GET['poruka'])){
        echo "<hr>";
        switch($_GET['poruka']){
            case 1:
                echo "Ovo je sadrzaj prve poruke";
                break;
            case 2:
                echo "Ovo je sadrzaj druge poruke";
                break;
            case 3:
                echo "Ovo je sadrzaj trece poruke";
                break;
            default:
        }
    }

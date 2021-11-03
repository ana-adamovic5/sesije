<html>
<style>
    table {
        border-collapse: collapse;
    }

    td,
    th {
        border: 1px solid black;
    }
</style>

<body>
    <h1>Korpa</h1>
    <!-- Ako postoje proizvodi u korpi zelim da ih prikazem kroz jednu tabelu, u suprotnom {pogledaj else} -->
    <?php if (count($korpa) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>Naziv</th>
                    <th>Cena</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td>Ukupno:</td>
                    <td><?php echo $ukupno; ?></td>
                    <!-- Prikazujem ukupan ukupnu vrednost proizvoda u footeru tabele -->
                </tr>
            </tfoot>
            <tbody>
                <!-- Za svaki proizvo u KORPI ($korpa promenljiva u index.php) hocu da ispisem njihov naziv i cenu -->
                <?php foreach ($korpa as $proizvod) : ?>
                    <tr>
                        <td><?php echo $proizvod['naziv']; ?></td>
                        <td><?php echo $proizvod['cena']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Ako nemam proizvode u korpi hocu da ispisem da ih nema i da mogu da nastave sa kupovinom -->
    <?php else : ?>
        <p>Nema proizvoda u korpi</p>
    <?php endif; ?>
    <!-- Kreiramo formu kojom cemo isprazniti sve elemente iz korpe i dozvoliti vracanje na prethodnu stranu odnosno katalog.php
        kao action i href postavljamo ?
        action atribut specificira mesto na koje cemo poslati podatke ili otici nakon sto je forma obradjena
        u nasem slucaju mi zelimo da se vratimo na sam pocetak
        Kako znamo da nas ? vraca na pocetak, pa ako se vratimo na GET objasnjenje u index.php fajlu
        vidimo da se nakon ? prosledjuju parametri koji treba da se obrade, to mogu biti parametri unutar samog fajla ili mogu biti linkovi ka drugim stranicama/resursima
        kao kada smo obradjivali vidi_korpu, u ovom slucaju obradjujemo prazan bez-parametarski URL sto nas zapravo vodi na index.php -->
    <form method="post" action="?">
        <p>
            <a href="?">Nastavi sa kupovinom</a>
            <input type="submit" name="submit" value="Isprazni">
        </p>
    </form>
</body>

</html>
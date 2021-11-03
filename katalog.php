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
    <p>Vasa korpa sadrzi: <?php echo count($_SESSION['korpa']); ?> poizvoda</p>
    <!-- zelimo da prebrojimo sve proizvode u korpi i na vrhu prikazemo broj proizvoda u korpi-->

    <a href="?vidi_korpu">Vidi korpu</a>
    <!-- kao sto smo u index.html skripti rekli, hocemo da vidimo korpu, tako sto cemo u GET metodi proslediti link vidi_korpu koja ce nam pozvati izvrsavanje korpa.php skripte
    -->
    <table border="1">
        <thead>
            <tr>
                <th>Naziv proizvoda</th>
                <th>Cena proizvoda</th>
            </tr>
        </thead>
        <tbody>
            <!-- za sve proizvode u nasoj listi proizvoda u faju index.php hocu da kreiram novi red u tabeli koji ce imati naziv i cenu ali cu id da prosledim kao skriveno polje koje cu proslediti u POST metodi pored svakog proizvoda zelim da imam dugme "Kupi" koje cu da obradjujem u POST metodi-->

            <?php foreach ($proizvodi as $proizvod) : ?>
                <tr>
                    <td><?php echo $proizvod['naziv']; ?></td>
                    <td><?php echo $proizvod['cena']; ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $proizvod['id']; ?>">
                            <input type="submit" name="submit" value="Kupi">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
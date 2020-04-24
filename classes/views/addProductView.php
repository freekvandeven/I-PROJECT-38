<main>
    <form method="POST" enctype="multipart/form-data">

        <label for="Titel">Titel voorwerp: </label>
        <input type="text" name="Titel" id="Titel" required> <br>

        <label for="Beschrijving">Beschrijving: </label>
        <input type="text" name="Beschrijving" id="Beschrijving" required><br>

        <label for="Rubriek">Rubriek: </label>
        <select id="Rubriek" name="categorie" required>
            <option value="Auto's, boten en motoren">Autos, boten en motoren</option>
            <option value="Baby">Baby</option>
            <option value="Muziek en Instrumenten">Muziek en instrumenten</option>
            <option value="Elektronica">Elektronica</option>
            <option value="Mode">Mode</option>
        </select><br>

        <label for=img>Select image: </label>
        <input type=file id=img name=img accept=image/*> <br>

        <label for="Startprijs">Startprijs: </label>
        <input type="number" name="Startprijs" id="Startprijs" required><br>

        <label for="Betalingswijze">Betalingswijze: </label>
        <select id="Betalingswijze" name="Betalingswijze" required>
            <option value="Contact">Contact</option>
            <option value="Bank">Bank</option>
            <option value="Anders">Anders</option>
        </select> <br>

        <label for="Betalingsinstructie">Betalingsinstructie: </label> <!-- verander naar Betalingsinstructies met een S-->
        <input type="text" name="Betalingsinstructie" id="Betalingsinstructie"><br>

        <label for="Looptijd">Looptijd: </label>
        <select id="Looptijd" name="Looptijd" required>
            <option value="1">1</option>
            <option value="3">3</option>
            <option value="5">5</option>
            <option value="7" selected="selected">7</option>
            <option value="10">10</option>
        </select><br>

        <label for="Verzendinstructies">Verzendinstructies: </label>
        <input type="text" name="Verzendinstructies" id="Verzendinstructies"><br>

        <input type="submit" name="submit" value="Verzenden">
    </form>
</main>
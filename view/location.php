<?php

namespace Anax\View;

/**
 * Geo search.
 */
// if ($coords) {
//     foreach ($coords as $coord) {
//     }
// }
?>

<form method="post" action="<?= url("location") ?>">
    <fieldset>
        <legend>
            <label for="location">Location:</label>
        </legend>
        <input type="text" name="location" placeholder="Comma-separate">
        <button type="submit">Search</button>
    </fieldset>
</form>

<?php if ($coords) : ?>
    <ul>
        <?php foreach ($coords as $coord) : ?>
            <?php if (strlen($coord[1][1]) > 0) : ?>
                <li><p><?= $coord[1][1] ?></p></li>
            <?php else : ?>
                <li><?= $coord[1][2] ?> weather: <?= $coord[0]->hourly->summary ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
   integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
   crossorigin=""></script>

<div id="mapid" style="height: 200px;"></div>

<p>Don't forget to read the <a hreg="docs">docs</a></p>



<script>
    var mymap = L.map('mapid').setView([30.505, 10.09], 2);
    
    // L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mymap);
    <?php if ($coords) : ?>
        <?php foreach ($coords as $coord) : ?>
            <?php if (strlen($coord[1][1]) == 0) : ?>
                L
                    .marker([<?= strval($coord[0]->latitude) ?>, <?= strval($coord[0]->longitude) ?>])
                    .addTo(mymap)
                    .bindPopup("<?= $coord[1][2] ?>")
                    .openPopup();
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</script>


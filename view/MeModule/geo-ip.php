<?php

namespace Anax\View;

/**
 * Validate IP.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>



<div class="geoIP">
    <?php if ($res): ?>
        <?php if (isset($res["fetch"])) : ?>
            <p>IP: <?= $res["fetch"]->ip ?></p>
            <p>Type: <?= $res["fetch"]->type ?></p>
            <p>Country: <?= $res["fetch"]->country_name ?></p>
            <p>Region: <?= $res["fetch"]->region_name ?></p>
            <p>City: <?= $res["fetch"]->city ?></p>
            <p>Capital: <?= $res["fetch"]->location->capital ?></p>
        <?php endif; ?>
    <?php endif; ?>
</div>
<div class="geoForm">
    <form method="post" action="<?= url("geo/search") ?>">
    <fieldset>
        <legend>IP:</legend>
            <input type="text" value="<?= $defaultIP ?>" name="ip">
            <button type="submit">Search</button>
        </form>
        <form class="reset" method="post" action="<?= url("geo/reset") ?>">
            <button type="submit">Reset</button>
        </fieldset>
    </form>
</div>
<form method="post" action="<?= url("api/geo/search") ?>">
    <fieldset>
        <legend>
            <label for="ip">API call:</label>
        </legend>
        <input type="text" value="<?= $defaultIP ?>" name="ip">
        <button type="submit">Search</button>
    </fieldset>
</form>


<p>API can be found via <a href="api/ip">/api/geo/search</a></p>
<p>Example 1: <a href="api/geo/search?ip=1.2.3.4">/api/geo/search?ip=1.2.3.4</a></p>
<p>Example 2: <a href="api/geo/search?ip=216.58.208.110">/api/geo/search?ip=216.58.208.110</a></p>
<p>Example 3: <a href="api/geo/search?ip=1.2.3.4.5">/api/geo/search?ip=1.2.3.4.5</a></p>

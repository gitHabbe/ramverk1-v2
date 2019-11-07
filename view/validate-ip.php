<?php

namespace Anax\View;

/**
 * Validate IP.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<div class="validateIP">
    <h1>Validate IP</h1>
    <?php if ($res[1]) : ?>
        <h4 class="validateResult"><?= $res[1] ?></h4>
        <?php if ($res[0] != $res[2] && $res[2] != "") : ?>
            <p>Host is: <?= $res[2] ?></p>
        <?php endif; ?>
    <?php endif; ?>
    <p>Input an IP4 or IP6 to validate it's format</p>
    <form method="post" action="<?= url("validate/check") ?>">
        <fieldset>
            <legend>IP validator</legend>
            <!-- <label for="text">IP:</label> -->
            <input type="text" name="ip" required>
            <button type="submit">Check ip</button>
        </form>
        <form class="reset" method="post" action="<?= url("validate/reset") ?>">
            <button type="submit">Reset</button>
        </fieldset>
    </form>
    <form action="api/ip" method="get">
        <fieldset>
            <legend>API call</legend>
            <input type="text" name="ip">
            <button type="submit">Check</button>
        </fieldset>
    </form>
    <p>API can be found via <a href="api/ip">/api/ip</a></p>
    <p>Example 1: <a href="api/ip?ip=1.2.3.4">/api/ip?ip=1.2.3.4</a></p>
    <p>Example 2: <a href="api/ip?ip=216.58.208.110">/api/ip?ip=216.58.208.110</a></p>
    <p>Example 3: <a href="api/ip?ip=1.2.3.4.5">/api/ip?ip=1.2.3.4.5</a></p>
</div>

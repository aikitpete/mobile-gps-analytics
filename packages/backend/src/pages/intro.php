<h2>Track, store and analyse mobile GPS traces</h2>
<p>
    This prototype records location traces from a phone's browser, stores them in a SQL database,
    shows them on a map and estimates how much battery continuous tracking uses.
</p>
<p>
    Created as a student project on cycling behaviour in the Öresund region. Register an account to try it out,
    then open <strong>Collect</strong> on a phone and keep the page open while you ride.
</p>
<?php if ($user === null): ?>
    <p><a class="button" href="index.php?action=signup">Create an account</a></p>
<?php endif; ?>

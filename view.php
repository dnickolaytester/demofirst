<?php

$conn = pg_connect("host=localhost dbname=mydb user=postgres password=pg1234")
  or die('Could not connect: ' . pg_last_error());


$isDetail = false;
if(isset($_GET['id']) && $_GET['id']) { // $_GET['id'] == 0
    $isDetail = true;
    //@todo SQL injection and try
    //$query = 'select id, abstime(dt_ex) as dt_ex, (dt_ex + wait) as dt_ans, wait, state from main where id= ' . intval($_GET['id']) .'ORDER BY dt_ex DESC';

    $query = 'select main.state, main.id_req, main.wait, response.body from main
join response on main.id_req=response.id_req where main.id= ' . intval($_GET['id']);

}elseif(isset($_GET['dt']) && $_GET['dt']) {

    $timestamp = strtotime($_GET['dt']);

    $beginOfDay = strtotime("midnight", $timestamp);
    $endOfDay = strtotime("tomorrow", $beginOfDay) - 1;

    $query = 'select id, abstime(dt_ex) as dt_ex, (dt_ex + wait) as dt_ans, wait, state from main where dt_ex>=' . $beginOfDay . ' and dt_ex<=' . $endOfDay . ';';

} else {

    $query = 'select id, abstime(dt_ex) as dt_ex, (dt_ex + wait) as dt_ans, wait, state from main ORDER BY dt_ex DESC';

}

$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());


// Printing results in HTML
if($isDetail) {
    echo "<table cellpadding='10'>\n";
    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
        
        foreach ($line as $col_value) {
            echo "\t<tr>\n";
            echo "\t\t<td>$col_value</td>\n";
            echo "\t</tr>\n";
        }
        
    }
    echo "</table>\n";
} else {
    echo "<table cellpadding='10'>\n";
    echo "<tr><th>id</th><th>id_req</th><th>dt_ex</th><th>wait</th><th>state</th></tr>";
    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
        echo "\t<tr>\n";
        foreach ($line as $col_value) {
            echo "\t\t<td>$col_value</td>\n";
        }
        echo "\t</tr>\n";
    }
    echo "</table>\n";
}

pg_free_result($result);
pg_close($conn);

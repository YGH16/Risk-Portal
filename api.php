<?php
    // Access Link : /api.php?account_type=lol

    // Add access to the database
    include "./Database/database.php";

    // Add access to queries
    include "./Queries/queries.php";
    
    header("Access-Control-Allow-Origin: *");
    // Returned Content Type
    header("Content-Type:application/json");

    // ENDPOINT 1 - Open PnL Exposure
    if(isset($_GET['open_pnl_exposure']) && $_GET['open_pnl_exposure'] !="") {

        // Check what the param is equal to
        if($_GET["open_pnl_exposure"] == 1){
            // Run Query 1 (Reference Queries.php)
            $result = $conn -> query($open_expo_pnl_t1);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);
        }
        elseif($_GET["open_pnl_exposure"] == 2){
            // Run Query 2
            $result = $conn -> query($open_expo_pnl_current);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);

        }
        else{
            header("HTTP/1.1 404 Not Found");
        }
    } 

    // ENDPOINT 2 - Account Type Statistics
    elseif(isset($_GET['account_type']) && $_GET['account_type'] !="") {
        
        // Check what the param is equal to
        if($_GET["account_type"] == 1){
            // Run Query 3
            $result = $conn -> query($account_type_stats);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);
        }
        else{
            header("HTTP/1.1 404 Not Found");
        }
    }

    // ENPOINT 3 - Symbol Exposure
    elseif(isset($_GET['symbol_exposure']) && $_GET['symbol_exposure'] !="") {

        // Check what the param is equal to
        if($_GET["symbol_exposure"] == 1){
            // Run Query 4
            $result = $conn -> query($symbol_expo);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);
        }
        else{
            header("HTTP/1.1 404 Not Found");
        }
    }

    // ENDPOINT 4 - Top 10 PnL
    elseif(isset($_GET['top_10_pnl']) && $_GET['top_10_pnl'] !="") {

        // Check what the param is equal to
        if($_GET["top_10_pnl"] == 1){
            // Run Query 5
            $result = $conn -> query($top_10_pnl_MAM);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);
        }
        elseif($_GET["top_10_pnl"] == 2){
            // Run Query 6
            $result = $conn -> query($top_10_pnl_nonMAM);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);

        }
        else{
            header("HTTP/1.1 404 Not Found");
        }
    }

    // ENPOINT 5 - Bottom 10 PnL
    elseif(isset($_GET['bottom_10_pnl']) && $_GET['bottom_10_pnl'] !="") {
        
        // Check what the param is equal to
        if($_GET["bottom_10_pnl"] == 1){
            // Run Query 7
            $result = $conn -> query($bottom_10_pnl_MAM);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);
        }
        elseif($_GET["bottom_10_pnl"] == 2){
            // Run Query 8
            $result = $conn -> query($bottom_10_pnl_nonMAM);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);

        }
        else{
            header("HTTP/1.1 404 Not Found");
        }
    }

    // ENPOINT 6 - Suspicious Account
    elseif(isset($_GET['suspicious_accounts']) && $_GET['suspicious_accounts'] !="") {
        
        // Check what the param is equal to
        if($_GET["suspicious_accounts"] == 1){
            // Run Query 4
            $result = $conn -> query($suspicious_accounts);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);
        }
        else{
            header("HTTP/1.1 404 Not Found");
        }
    }

    // ENPOINT 7 - Tick Monitoring - COME BACK TO
    elseif(isset($_GET['tick_monitoring']) && $_GET['tick_monitoring'] !="") {
        echo $_GET['tick_monitoring'];
    }

    // ENPOINT 8 - Top 10 Client Exposure
    elseif(isset($_GET['top_10_client_exposure']) && $_GET['top_10_client_exposure'] !="") {
        
        // Check what the param is equal to
        if($_GET["top_10_client_exposure"] == 1){
            // Run Query 4
            $result = $conn -> query($top_10_client_expo);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);
        }
        else{
            header("HTTP/1.1 404 Not Found");
        }
    }

    // ENPOINT 9 - Close Trades PnL - Needs An Additional Param - COME BACK TO
    elseif(isset($_GET['start_date']) && $_GET['start_date'] !="" && isset($_GET['end_date']) && $_GET['end_date'] != "") {

        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];

        // Query needs to be in declared inside the endpoint as it requires dynamic data and needs to be formated with the corrected dates
        
        $trades_between_2_dates = "SELECT date_format(t.close_time,'%Y-%m-%d') Date,sum(t.totalprofit) Total_Closed_PnL from fxbackoffice.mt4_trades t
        join fxbackoffice.mt4_users u on u.login = t.login 
        where t.close_time >= '$start_date' and t.close_time < '$end_date' + interval 1 day and t.cmd<2 
        and u.group not regexp 'sub|test|demo' and t.login >'200000' 
        group by date_format(t.close_time,'%Y-%M-%D')
        order by t.close_time asc";

        $result = $conn -> query($trades_between_2_dates);

        if($result -> num_rows > 0){
            while($row = $result -> fetch_assoc()){
                $rows[] = $row;
            }
        }
        else {
            header("HTTP/1.1 500 Some Went Wrong");
        }
        
        echo json_encode($rows);

    }


    // ENPOINT 10 - AIF Sync
    elseif(isset($_GET['aif_sync']) && $_GET['aif_sync'] !="") {
        
        // Check what the param is equal to
        if($_GET["aif_sync"] == 1){
            // Run Query 4
            $result = $conn -> query($aif_open_expo);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);
        }
        else{
            header("HTTP/1.1 404 Not Found");
        }
    }

    // ENPOINT 11 - FMT Sync
    elseif(isset($_GET['fmt_sync']) && $_GET['fmt_sync'] !="") {
        
        // Check what the param is equal to
        if($_GET["fmt_sync"] == 1){
            // Run Query 4
            $result = $conn -> query($fmt_open_expo);

            if($result -> num_rows > 0 ){
                while($row = $result -> fetch_assoc()){
                    $rows[] = $row;
                }
            }
            else {
                header("HTTP/1.1 500 Some Went Wrong");
            }

            // Return Results in JSON
            echo json_encode($rows);
        }
        else{
            header("HTTP/1.1 404 Not Found");
        }
    }

    else{
        echo "Correct Param Not Passed";
    }

    $conn -> close();

?>
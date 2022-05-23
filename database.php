<?php

// Data Source Name : AZURE
$servername = "blackwellglobal.mysql.database.azure.com";
$username = "chappie_azure@blackwellglobal";
$password = "Npvjm8ctnEsF2XWAQU8jzgh4ux2fZfUD";
$dbname = "mt5_live";

$conn = new mysqli($servername, $username, $password);

if ($conn -> connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// $sql = "SELECT * FROM mt5_live.suspicious_clients_weekly;";
// $sql = "SELECT 
// D2.login,
//    # upper(d6.Tag) as Tag,
// round( D4.Equity,2) as Equity,
//   ROUND(d4.floating,2) AS Open_PnL,  
// ROUND(SUM(IF(D1.action<=1 and D1.TIME>= (CURDATE() - Interval 0 day),
//     D1.Profit+D1.Storage+D1.Commission,
//     0)),2) AS TODAY_Closed_PnL,  
//  ROUND(SUM(IF(D1.action<=1 and D1.TIME>= (CURDATE() - Interval 1 day) and D1.TIME< (CURDATE() - Interval 0 day),
//  D1.Profit+D1.Storage+D1.Commission,
//    0)),2) AS YESTERDAY_Closed_PnL      

// FROM
// mt5_live.mt5_deals AS D1
//     INNER JOIN
// mt5_live.mt5_users AS D2 ON D1.login = D2.login
// join mt5_live.mt5_accounts as d4 on d1.login = d4.login
// join mt5_live.mt5_groups as d3 on d2.group = d3.Group
// join fxbackoffice.user_tags as d5 on d5.userId = d2.id
// join fxbackoffice.tags as d6 on d5.tagId = d6.id
// WHERE
// -- (D1.Time >=DATE_FORMAT(NOW() - Interval 7 day ,'%Y-%m-01') and D1.Time< DATE_FORMAT(NOW(),'%Y-%m-01')) and (D2.Name not like '%closed%') and 
// -- (D1.action >= 6 OR D1.action <= 1)
// d2.balance > 0 and
// (d5.tagId = 41 or d5.tagid = 56 or d5.tagId = 46)

//     GROUP BY D2.login"
// ;
// $sql = "SELECT t.Login,
// round(sum(t.totalprofit*if(isnull(s.Mid),1,s.mid)),2) as Total_Profit_USD
// FROM fxbackoffice.mt4_trades t
// join fxbackoffice.mt4_users u on t.login = u.login
// left join (SELECT symbol,(ask+bid)/2 mid FROM fxbackoffice.mt4_prices where right(symbol,1)='q' and (symbol='eurusdq' or symbol='gbpusdq')) s on left(s.symbol,3) = left(u.currency,3)

// where t.login > '200000' and t.cmd < 2 and t.OPEN_TIME<curdate() and (t.CLOSE_TIME >=curdate()  or t.CLOSE_TIME<'2000') and t.totalProfit>0
// and u.group not regexp 'sub|demo|test' and u.group regexp 'mam'
// group by t.Login
// order by total_profit_usd desc
// limit 10"
// ;

$sql = "SELECT if(right(t.SYMBOL,1) regexp 'q|x|m|s|v|i',left(t.symbol,6),t.symbol) Symbols, 
round(sum(t.volume / 100),2) as Volume, round(sum(if(t.cmd = 0,t.volume/100,0))-sum(if(t.cmd = 1,t.volume/100,0)),2) Net_Exposure 
FROM fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on t.login = u.login
left join (SELECT symbol,(ask+bid)/2 mid FROM fxbackoffice.mt4_prices where right(symbol,1)='q' and (symbol='eurusdq' or symbol='gbpusdq')) s on left(s.symbol,3) = left(u.currency,3)
where t.login > '200000' and t.cmd < 2 and t.OPEN_TIME<curdate() and (t.CLOSE_TIME >=curdate()  or t.CLOSE_TIME<'2000')
and u.group not regexp 'sub|demo|test'
group by symbols"
;

$result = $conn -> query($sql);

if($result -> num_rows > 0){
    while($row = $result->fetch_assoc()) {
        // echo "Login: " . $row["login"]. " - Name: " . $row["name"]. " - Group: " . $row["group"]. " - Country: " . $row["country"]. " - Balance: " . $row["balance"]. " - Equity: " . $row["equity"].  "<br>";
        $rows[] = $row;
    }
} else {
    echo "0 Results";
}

echo json_encode($rows);

$conn -> close();

?>
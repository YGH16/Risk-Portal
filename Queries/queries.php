<?php

// Query 1 - Open Exposure PnL t-1 (Yesterday)
$open_expo_pnl_t1 = 
"SELECT round(sum(if(isnull(s.Mid),1,s.mid)*d.profit),2) Floating FROM mt5_live.mt5_daily d
join (select login, max(datetime) datetime from mt5_live.mt5_daily group by login) d1 on d1.login = d.login and d1.Datetime=d.datetime
left join (SELECT symbol,(ask+bid)/2 mid FROM fxbackoffice.mt4_prices where right(symbol,1)='q' and (symbol='eurusdq' or symbol='gbpusdq')) s on left(s.symbol,3) = left(d.currency,3)

where d.login > '200000' and d.group not regexp 'test|demo|sub'
and from_unixtime(d.Datetime) = from_unixtime(d1.datetime)"
;

// Query 2 - Open Exposure PnL Current
$open_expo_pnl_current = 
"SELECT 
round(sum(t.totalprofit*if(isnull(s.Mid),1,s.mid)),2) as Total_Profit_USD 
FROM fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on t.login = u.login
left join (SELECT symbol,(ask+bid)/2 mid FROM fxbackoffice.mt4_prices where right(symbol,1)='q' and (symbol='eurusdq' or symbol='gbpusdq')) s on left(s.symbol,3) = left(u.currency,3)
where t.login > '200000' and t.cmd < 2 and (t.CLOSE_TIME<'2000')
and u.group not regexp 'sub|demo|test'"
;

// Query 3 - Account Type Statistics

// PREVIOUS QUERY----
// $account_type_stats = "select if(u.group regexp 'aif','AIF',if(u.group regexp 'sub','MAM',if(u.group regexp 'pro', 'Pro','Retail'))) 'Account Type',round(sum(if(u.group regexp '6_aif|1_aif',0,u.equity)),2) Equity,round(sum(if(u.group regexp '6_aif|1_aif',0,u.Balance)),2) Balance,round(sum(t.lots),2) Exposure from fxbackoffice.mt4_users u 
// left join( select login,sum(if(cmd=1,lots*-1,lots)) lots from fxbackoffice.mt4_trades where (login>'200000' or login between '80001' and '80007') and close_time < '2000' and cmd<2 group by login) t on u.login = t.login
// where u.group not regexp 'test|demo|mam' and (u.login>'200000' or u.login between '80001' and '80007')
// group by `account type`"
// ;

$account_type_stats = "select `account type`,sum(Equity) Equity,sum(Balance) Balance,sum(if(isnull(Exposure),0,exposure)) Exposure from (
select u.login,u.group, if(u.group regexp 'aif','AIF',if(u.group like '%mam%_2%','MAM B-Book',if(u.group like '%mam%_%','MAM A-Book',if(u.group regexp 'pro', 'Pro',if(u.group regexp '2_','Retail B-Book','Retail A-Book'))))) 'Account Type',round(sum(if(u.group regexp '6_aif|1_aif',0,u.equity)),2) Equity,round(sum(if(u.group regexp '6_aif|1_aif',0,u.Balance)),2) Balance,round(sum(t.lots),2) Exposure from fxbackoffice.mt4_users u 
left join( select login,sum(if(cmd=1,lots*-1,lots)) lots from fxbackoffice.mt4_trades where (login>'200000' or login between '80001' and '80007') and close_time < '2000' and cmd<2 group by login) t on u.login = t.login
#right join (select login,u.group,equity,balance from fxbackoffice.mt4_users u where u.group like '%sub_aif%') u1 on u1.login = u.login
where u.group regexp 'real|sub_aif' and u.group not regexp 'test|demo|sub|flavio|alphacore'  and (u.login>'200000' or u.login between '80001' and '80007') and u.isdeleted=0
group by `account type` 
union all
select u.login,u.group, if(u.group regexp 'aif','AIF',if(u.group like '%mam%_2%','MAM B-Book',if(u.group like '%mam%_%','MAM A-Book',if(u.group regexp 'pro', 'Pro',if(u.group regexp '2_','Retail B-Book','Retail A-Book'))))) 'Account Type',round(sum(if(u.group regexp '6_aif|1_aif',0,u.equity)),2) Equity,round(sum(if(u.group regexp '6_aif|1_aif',0,u.Balance)),2) Balance,round(sum(t.lots),2) Exposure from fxbackoffice.mt4_users u 
left join( select login,sum(if(cmd=1,lots*-1,lots)) lots from fxbackoffice.mt4_trades where (login>'200000' or login between '80001' and '80007') and close_time < '2000' and cmd<2 group by login) t on u.login = t.login
#right join (select login,u.group,equity,balance from fxbackoffice.mt4_users u where u.group like '%sub_aif%') u1 on u1.login = u.login
where u.group regexp 'sub_aif' and u.group not regexp 'test|demo|flavio|alphacore'  and (u.login>'200000' or u.login between '80001' and '80007') and u.isdeleted=0
group by `account type`

union all
select u.login,u.group, 'MAM B-Book' as 'Account Type',round(sum(if(u.group regexp '6_aif|1_aif',0,u.equity)),2) Equity,round(sum(if(u.group regexp '6_aif|1_aif',0,u.Balance)),2) Balance,round(sum(t.lots),2) Exposure from fxbackoffice.mt4_users u 
left join( select login,sum(if(cmd=1,lots*-1,lots)) lots from fxbackoffice.mt4_trades where (login>'200000' or login between '80001' and '80007') and close_time < '2000' and cmd<2 group by login) t on u.login = t.login
#right join (select login,u.group,equity,balance from fxbackoffice.mt4_users u where u.group like '%sub_aif%') u1 on u1.login = u.login
  where u.group regexp 'mam_flavio|mam_alphacore' and u.group not regexp 'test|demo'  and (u.login>'200000' or u.login between '80001' and '80007') and u.isdeleted = 0
group by `account type`) as a
group by a.`account type`"
;

// Query 4 - Symbol Exposure
$symbol_expo = 
"SELECT if(right(t.SYMBOL,1) regexp 'q|x|m|s|v|i',left(t.symbol,6),t.symbol) Symbols, 
round(sum(t.volume / 100),2) as Volume, round(sum(if(t.cmd = 0,t.volume/100,0))-sum(if(t.cmd = 1,t.volume/100,0)),2) Net_Exposure 
FROM fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on t.login = u.login
left join (SELECT symbol,(ask+bid)/2 mid FROM fxbackoffice.mt4_prices where right(symbol,1)='q' and (symbol='eurusdq' or symbol='gbpusdq')) s on left(s.symbol,3) = left(u.currency,3)
where t.login > '200000' and t.cmd < 2 and t.OPEN_TIME<curdate() and (t.CLOSE_TIME >=curdate()  or t.CLOSE_TIME<'2000')
and u.group not regexp 'sub|demo|test'
group by symbols"
;

// Query 5 - Top 10 PnL MAMs
$top_10_pnl_MAM = 
"SELECT t.Login,
round(sum(t.totalprofit*if(isnull(s.Mid),1,s.mid)),2) as Total_Profit_USD
FROM fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on t.login = u.login
left join (SELECT symbol,(ask+bid)/2 mid FROM fxbackoffice.mt4_prices where right(symbol,1)='q' and (symbol='eurusdq' or symbol='gbpusdq')) s on left(s.symbol,3) = left(u.currency,3)

where t.login > '200000' and t.cmd < 2 and t.OPEN_TIME<curdate() and (t.CLOSE_TIME >=curdate()  or t.CLOSE_TIME<'2000') and t.totalProfit>0
and u.group not regexp 'sub|demo|test' and u.group regexp 'mam'
group by t.Login
order by total_profit_usd desc
limit 10"
;

// Query 6 - Top 10 PnL Non MAMs
$top_10_pnl_nonMAM = 
"SELECT t.Login,
round(sum(t.totalprofit*if(isnull(s.Mid),1,s.mid)),2) as Total_Profit_USD
FROM fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on t.login = u.login
left join (SELECT symbol,(ask+bid)/2 mid FROM fxbackoffice.mt4_prices where right(symbol,1)='q' and (symbol='eurusdq' or symbol='gbpusdq')) s on left(s.symbol,3) = left(u.currency,3)

where t.login > '200000' and t.cmd < 2 and t.OPEN_TIME<curdate() and (t.CLOSE_TIME >=curdate()  or t.CLOSE_TIME<'2000') and t.totalProfit>0
and u.group not regexp 'sub|demo|test|mam'
group by t.Login
order by total_profit_usd desc
limit 10"
;

// Query 7 - Bottom 10 PnL MAMs
$bottom_10_pnl_MAM = 
"SELECT t.Login,
round(sum(t.totalprofit*if(isnull(s.Mid),1,s.mid)),2) as Total_Profit_USD
FROM fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on t.login = u.login
left join (SELECT symbol,(ask+bid)/2 mid FROM fxbackoffice.mt4_prices where right(symbol,1)='q' and (symbol='eurusdq' or symbol='gbpusdq')) s on left(s.symbol,3) = left(u.currency,3)

where t.login > '200000' and t.cmd < 2 and t.OPEN_TIME<curdate() and (t.CLOSE_TIME >=curdate()  or t.CLOSE_TIME<'2000') and t.totalProfit<0
and u.group not regexp 'sub|demo|test' and u.group regexp 'mam'
group by t.Login
order by total_profit_usd asc
limit 10"
;

// Query 8 - Bottom 10 PnL Non MAMs
$bottom_10_pnl_nonMAM = 
"SELECT t.Login,
round(sum(t.totalprofit*if(isnull(s.Mid),1,s.mid)),2) as Total_Profit_USD
FROM fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on t.login = u.login
left join (SELECT symbol,(ask+bid)/2 mid FROM fxbackoffice.mt4_prices where right(symbol,1)='q' and (symbol='eurusdq' or symbol='gbpusdq')) s on left(s.symbol,3) = left(u.currency,3)

where t.login > '200000' and t.cmd < 2 and t.OPEN_TIME<curdate() and (t.CLOSE_TIME >=curdate()  or t.CLOSE_TIME<'2000') and t.totalProfit<0
and u.group not regexp 'sub|demo|test|mam' 
group by t.Login
order by total_profit_usd asc
limit 10"
;

// Query 9 - Suspicious Accounts
$suspicious_accounts = 
"SELECT 
D2.login,
   # upper(d6.Tag) as Tag,
round( D4.Equity,2) as Equity,
  ROUND(d4.floating,2) AS Open_PnL,  
ROUND(SUM(IF(D1.action<=1 and D1.TIME>= (CURDATE() - Interval 0 day),
    D1.Profit+D1.Storage+D1.Commission,
    0)),2) AS TODAY_Closed_PnL,  
 ROUND(SUM(IF(D1.action<=1 and D1.TIME>= (CURDATE() - Interval 1 day) and D1.TIME< (CURDATE() - Interval 0 day),
 D1.Profit+D1.Storage+D1.Commission,
   0)),2) AS YESTERDAY_Closed_PnL      

FROM
mt5_live.mt5_deals AS D1
    INNER JOIN
mt5_live.mt5_users AS D2 ON D1.login = D2.login
join mt5_live.mt5_accounts as d4 on d1.login = d4.login
join mt5_live.mt5_groups as d3 on d2.group = d3.Group
join fxbackoffice.user_tags as d5 on d5.userId = d2.id
join fxbackoffice.tags as d6 on d5.tagId = d6.id
WHERE
-- (D1.Time >=DATE_FORMAT(NOW() - Interval 7 day ,'%Y-%m-01') and D1.Time< DATE_FORMAT(NOW(),'%Y-%m-01')) and (D2.Name not like '%closed%') and 
-- (D1.action >= 6 OR D1.action <= 1)
d2.balance > 0 and
(d5.tagId = 41 or d5.tagid = 56 or d5.tagId = 46)

    GROUP BY D2.login"
;

// Query 10 - Tick Monitoring


// Query 11 - Top 10 Client Exposure
$top_10_client_expo = 
"SELECT t.Login,if(right(t.SYMBOL,1) regexp 'q|x|m|s|v|i',left(t.symbol,6),t.symbol) Symbols, 
#round(sum(t.volume / 100),2) as Volume, 
round(sum(if(t.cmd = 0,t.volume/100,0))-sum(if(t.cmd = 1,t.volume/100,0)),2) Net_Exposure,
# round(sum(if(t.cmd = 0,t.volume/100,0)),2) as Buy_Volume,round(sum(if(t.cmd = 1,t.volume/100,0)),2) as Sell_Volume, 
round(sum(t.totalprofit*if(isnull(s.Mid),1,s.mid)),2) as Total_Profit_USD
#, u.Currency, if(isnull(s.Mid),1,s.mid) as USD_rate 
FROM fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on t.login = u.login
left join (SELECT symbol,(ask+bid)/2 mid FROM fxbackoffice.mt4_prices where right(symbol,1)='q' and (symbol='eurusdq' or symbol='gbpusdq')) s on left(s.symbol,3) = left(u.currency,3)

where t.login > '200000' and t.cmd < 2 and t.OPEN_TIME<curdate() and (t.CLOSE_TIME >=curdate()  or t.CLOSE_TIME<'2000')
and u.group not regexp 'sub|demo|test'
group by t.Login,symbols
order by abs(sum(if(t.cmd = 0,t.volume/100,0))-sum(if(t.cmd = 1,t.volume/100,0))) desc
limit 10"
;

// Query 12 - Closed Trades PnL - Done in the api.php file ENDPOINT 9 as it requires dynamic and changing inputs

// Query 13 - AIF Sync
$aif_open_expo = 
"SELECT t.login,round(sum(if(t.close_TIME<'2000',if(cmd=1,t.lots*-1,t.lots),0)),2) Volume from fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on u.login = t.login 
where t.cmd<2 and t.login>'80000' 
and u.group regexp 'aif'  
group by t.login"
;

// Query 14 - FMT Sync
$fmt_open_expo = 
"SELECT t.login,round(sum(if(t.close_time<'2000',if(cmd=1,t.lots*-1,t.lots),0)),2) Volume, u.group from fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on u.login = t.login 
where t.cmd<2 and t.login>'90000' 
and u.group regexp 'fmt' and u.group regexp 'mam'  
group by t.login"
;
?>
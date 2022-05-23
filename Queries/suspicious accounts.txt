SELECT 
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

        GROUP BY D2.login
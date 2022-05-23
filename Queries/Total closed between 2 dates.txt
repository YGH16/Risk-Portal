SELECT sum(t.totalprofit) Total_Closed_PnL from fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on u.login = t.login 
where t.close_time >= ? and t.close_time < ? + interval 1 day and t.cmd<2 
and u.group not regexp 'sub|test|demo' and t.login >'200000' 
SELECT t.login,round(sum(if(cmd=1,t.lots*-1,t.lots)),2) Volume from fxbackoffice.mt4_trades t
join fxbackoffice.mt4_users u on u.login = t.login 
where t.close_time <'2000' and t.cmd<2 and t.login>'80000' 
and u.group regexp 'aif'  
group by t.login
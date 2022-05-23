SELECT t.Login,if(right(t.SYMBOL,1) regexp 'q|x|m|s|v|i',left(t.symbol,6),t.symbol) Symbols, 
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
limit 10
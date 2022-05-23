<?php include "./includes/header.php"?>

    <!-- Page Heading -->
    <h1 class="dashboard-heading">Blackwell Global</h1>

    <!-- CSS GRID Wrapper -->
    <div class="wrapper">
        <!-- TILE 1 - OpenExposurePnl -->
        <div class="item item1">
            <div>
                <!-- Widget Title -->
                <p class="widget-title">Open Exposure PnL</p>
                
                <canvas id="open_exposure_pnl" width="400" height="400"></canvas>

            </div>
        </div>

        <!-- TILE 2 - AccountTypeStatistics -->
        <div class="item item2">
            <div>
                <!-- Widget Title -->
                <p class="widget-title">Account Types Statistics</p>

                <select style="margin-left: 100px;" id="account-selector" class="option-selector">
                    <option value="1">Equity</option>
                    <option value="2">Balance</option>
                    <option value="3">Exposure</option>
                </select>

                <canvas id="account_stats" width="400" height="400"></canvas>
            </div>
        </div>

        <!-- TILE 3 - SymbolExposure -->
        <div class="item item3">
            <div>
                <!-- Widget Title -->
                <p class="widget-title">Symbol Exposure</p>

                <table class="table" style="padding-left: 20px; font-size: 30px;" >
                    <tr>
                        <th>Symbol</th>
                        <th>Volume</th>
                        <th>Net exposure</th>
                    </tr>
                    <tbody id="symbol-exposure">

                    </tbody>
                </table>
            </div>
        </div>
        <!-- TILE 4 - Top10Pnl -->
        <div class="item item4">
            <div>
                <!-- Widget Title -->
                <p class="widget-title">Top 10 PnL</p>

                <select style="margin-left: 250px;" id="top-10-pnl-selector" class="option-selector">
                    <option value="1">MAMs</option>
                    <option value="2">NonMAMs</option>
                </select>

                <canvas id="top_10_pnl" width="200" height="200"></canvas>
            </div>
        </div>
        <!-- TILE 5 - Bottom10Pnl -->
        <div class="item item5">
            <div>
                <!-- Widget Title -->
                <p class="widget-title">Bottom 10 PnL</p>

                <select style="margin-left: 220px;" id="bottom_10_pnl-selector" class="option-selector">
                    <option value="1">MAMs</option>
                    <option value="2">NonMAMs</option>
                </select>

                <canvas id="bottom_10_pnl" width="400" height="400"></canvas>
            </div>
        </div>

        <!-- TILE 6 - SuspiciousAccounts -->
        <div class="item item6">
            <div>
                <!-- Widget Title -->
                <p class="widget-title">Suspicious Accounts</p>
                <div style="overflow-y: scroll; height:300px;";>
                    <table class="table">
                        <tr>
                            <th>Login</th>
                            <th>Equity</th>
                            <th>Open PnL</th>
                            <th>PnL t-1</th>
                            <th>PnL</th>
                        </tr>
                        <tbody id="suspicious-accounts">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TILE 7 - TickMonitoring -->
        <div class="item item7">
            <div>
                <!-- Widget Title -->
                <p class="widget-title">Tick Monitoring</p>
                
            </div>
        </div>

        <!-- TILE 8 - Top10ClientExposure -->
        <div class="item item8">
            <div>
                <!-- Widget Title -->
                <p class="widget-title">Top 10 Client Exposure</p>
                
                <table class="table">
                    <tr>
                        <th>Login</th>
                        <th>Symbol</th>
                        <th>Net exposure</th>
                        <th>Client PnL</th>
                    </tr>
                    <tbody id="client_exposure"></tbody>
                
                </table>
                
            </div>
        </div>

        <!-- TILE 9 - CloseTradesPnl -->
        <div class="item item9">
            <div>
                <!-- Widget Title -->
                <div style="display: inline-block;">
                <p class="widget-title">Close Trades PnL</p>
                <input style="margin-left: 60px; border:none; border-radius:5px; height:20px; padding:5px;" type="text" id="start-date" placeholder="Start Date: YYYY-MM-DD" required>
                <input style="border:none; border-radius:5px; height:20px; padding:5px;" type="text" id="end-date" placeholder="End Date: YYYY-MM-DD" required>
                <button id="close_trades_pnl_btn" style="padding:6px 20px; border: none; border-radius:3px;" type="submit">Submit</button>
                </div>
                
                <div style="overflow-x: scroll">
                    <div style="position:relative; width:1500px;">
                        <canvas id="close_trade_pnl" width="2000px" height="400px" ></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- TILE 10 - AIFSync -->
        <div class="item item10">
            <div>
                <!-- Widget Title -->
                <p class="widget-title">AIF Sync</p>

                <div style="overflow-y: scroll; height:300px;">
                    <table class="table" style="padding-left: 50px;">
                        <tr>
                            <th>Account Number</th>
                            <th>Open Exposure</th>
                        </tr>
                        <tbody id="aif_sync">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TILE 11 - FMTSync -->
        <div class="item item11">
            <div>
                <!-- Widget Title -->
                <p class="widget-title">FMT Sync</p>
                
                <div style="overflow-y: scroll; height:300px;" >
                    <table class="table" style="padding-left: 50px;">
                        <tr>
                            <th>Account Number</th>
                            <th>Open Exposure</th>
                        </tr>
                        <tbody id="fmt_sync">

                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>


    </div>

    <!-- Script that injects all the graphs and runs the JQuery code -->
    <script src="./javascript/script.js"></script>


<?php include "./includes/footer.php"?>
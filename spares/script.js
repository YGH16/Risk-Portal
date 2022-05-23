// function to load on startup
function onStart(){
    // open expo pnl
    // open_pnl_expo_t1();
    // open_pnl_expo_current();
    open_exposure_pnl();

    // account stats
    account_stats($('#account-selector').val());

    // Symbol Exposure
    symbol_exposure();

    // top 10 pnl
    top_10_pnl($('#top-10-pnl-selector').val());

    // bottom 10 pnl
    bottom_10_pnl($('#bottom_10_pnl-selector').val());

    // suspicious accounts
    suspicious_accounts();

    // top 10 client exposure
    top_10_client_exposure();

    // aif sync
    aif_sync();

    // fmt sync
    fmt_sync();

    // Get Yesterdays Date
    var date = new Date();
    date.setDate(date.getDate() - 1);
    var yesterdaysDate = date.toISOString().slice(0,10)

    // Get Todays Date
    var todayDate = new Date().toISOString().slice(0, 10);

    // Set date in fields
    $('#start-date').val(yesterdaysDate);
    $('#end-date').val(todayDate);
    
    closed_trades_pnl(yesterdaysDate,todayDate);
}

// Refreshes Every Minute
function dataGraphs(){
    // open expo pnl
    // open_pnl_expo_t1();
    open_pnl_expo_current();

    open_exposure_pnl();

    // account stats
    account_stats($('#account-selector').val());

    // top 10 pnl
    top_10_pnl($('#top-10-pnl-selector').val());

    // bottom 10 pnl
    bottom_10_pnl($('#bottom_10_pnl-selector').val());
}

// Refreshes every couple milliseconds
function dataTables(){
    // Symbol Exposure
    symbol_exposure();

    // suspicious accounts
    suspicious_accounts();

    // top 10 client exposure
    top_10_client_exposure();

    // aif sync
    aif_sync();

    // fmt sync
    fmt_sync();

}

// new ENPOINT 1
async function open_exposure_pnl(){
    var graphdata = [];
    var graphlabels = [];
    // Open Exposure Pnl t-1
    // $.get("http://localhost/Risk/api.php?open_pnl_exposure=1", (data, status) => {
    //     graphlabels.push("T-1");
    //     graphdata.push(data[0]["Floating"]);

    // })
    // // Open Exposure Pnl Current USD
    // $.get("http://localhost/Risk/api.php?open_pnl_exposure=2", (data, status) => {
    //     graphlabels.push("Current USD");
    //     graphdata.push(data[0]["Total_Profit_USD"]);

    // })

    var pnl_t1 = await fetch("http://localhost/Risk/api.php?open_pnl_exposure=1",{
        method: 'GET'
    });
    var pnl_t1_data = await pnl_t1.json();

    var pnl_current = await fetch("http://localhost/Risk/api.php?open_pnl_exposure=2",{
        method: 'GET'
    });
    var pnl_current_data = await pnl_current.json()

    console.log(pnl_t1_data[0]["Floating"])
    console.log(pnl_current_data[0]["Total_Profit_USD"])

    graphlabels.push("T-1", "Current USD");
    graphdata.push(pnl_t1_data[0]["Floating"],pnl_current_data[0]["Total_Profit_USD"]);


    console.log(graphlabels)
    console.log(graphdata)

    // Check if chart exists and delete on call if it exists
    var chartStatus = Chart.getChart('open_exposure_pnl')
    if (chartStatus != undefined) { chartStatus.destroy() }

    var openExpoPnl = document.getElementById('open_exposure_pnl').getContext('2d');
    new Chart(openExpoPnl, {
        type: 'bar',
        data: {
            labels: graphlabels,
            datasets: [{
                label: 'PnL',
                data: graphdata,
                backgroundColor: [
                    'rgba(240, 255, 0, 1)'
                ],
                borderColor: [
                    'rgba(240, 255, 0, 1)'
                ],
                borderWidth: 1,
                borderRadius: 10
            }]
        },

        options: {
            scales: {
                y: {
                    beginAtZero: true,

                }            
            }
        }
    });
}

// Endpoint 1
// function open_pnl_expo_t1(){
//     $.get("http://localhost/Risk/api.php?open_pnl_exposure=1", (data, status) => {
//         // Clear current value
//         $('#pnl_yesterday').empty()
//         // Inject new value into DOM
//         $('#pnl_yesterday').text(data[0]["Floating"])
//     })
// }

// // Endpoint 1 - Query 2
// function open_pnl_expo_current(){
//     $.get("http://localhost/Risk/api.php?open_pnl_exposure=2", (data, status) => {
//         // Clear current value
//         $('#pnl_current').empty()
//         // Inject new value into DOM
//         $('#pnl_current').text(data[0]["Total_Profit_USD"])
//     })
// }

// Endpoint 2 - COME BACK TO
function account_stats(option){
    $.get("http://localhost/Risk/api.php?account_type=1", (data, status) => {

        var graphlabels = [];
        var graphdata = [];

        if(option == 1){
            data.forEach(element => {
                graphlabels.push(element["account type"])
                graphdata.push(element["Equity"])
            })
        }
        else if(option == 2){
            data.forEach(element => {
                graphlabels.push(element["account type"])
                graphdata.push(element["Balance"])
            })
        }
        else{
            data.forEach(element => {
                graphlabels.push(element["account type"])
                graphdata.push(element["Exposure"])
            })
        }

        // Check if chart exists and delete on call if it exists
        var chartStatus = Chart.getChart('account_stats')
        if (chartStatus != undefined) { chartStatus.destroy() }

        const account_stat = document.getElementById('account_stats').getContext('2d');
        new Chart(account_stat, {
            type: 'doughnut',
            data: {
                labels: graphlabels,
                datasets: [{
                    label: 'Number of Votes',
                    data: graphdata,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
}

// Enpoint 3
function symbol_exposure(){
    $.get("http://localhost/Risk/api.php?symbol_exposure=1", (data, status) => {
        // Clean out table
        $('#symbol-exposure').empty()
        // Loop through data appending it to the table body
        data.forEach(element => {
            $('#symbol-exposure').append("<tr>" + "<td>" + element['Symbols'] + "</td>" + "<td>" + element['Volume'] + "</td>" + "<td>" + element['Net_Exposure'] + "</td>" + "</tr>")
        })

    })
}

// Endpoint 4
function top_10_pnl(option){
    $.get(`http://localhost/Risk/api.php?top_10_pnl=${option}`, (data, status) => {

        var graphlabels = []
        var graphdata = []

        data.forEach(element => {
            graphlabels.push(element["Login"])
            graphdata.push(element["Total_Profit_USD"])
        })

        // Check if chart exists and delete on call if it exists
        var chartStatus = Chart.getChart('top_10_pnl')
        if (chartStatus != undefined) { chartStatus.destroy() }

        // Draw graph
        var top_pnl = document.getElementById('top_10_pnl').getContext('2d');
        new Chart(top_pnl, {
            type: 'bar',
            data: {
                labels: graphlabels,
                datasets: [{
                    label: 'PnL',
                    data: graphdata,
                    backgroundColor: [
                        'rgba(139, 196, 58, 1)'
                    ],
                    borderColor: [
                        'rgba(139, 196, 58, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 10
                }]
            },

            options: {
                scales: {
                    y: {
                        beginAtZero: true,

                    }            
                }
            }
        });


    })
}

// Enpoint 5
function bottom_10_pnl(option){
    $.get(`http://localhost/Risk/api.php?bottom_10_pnl=${option}`, (data, status) => {

        var graphlabels = []
        var graphdata = []

        data.forEach(element => {
            graphlabels.push(element["Login"])
            graphdata.push(element["Total_Profit_USD"])
        })

        // Check if chart exists and delete on call if it exists
        var chartStatus = Chart.getChart('bottom_10_pnl')
        if (chartStatus != undefined) { chartStatus.destroy() }

        // Draw graph
        const bottom_pnl = document.getElementById('bottom_10_pnl').getContext('2d');
        new Chart(bottom_pnl, {
            type: 'bar',
            data: {
                labels: graphlabels,
                datasets: [{
                    label: 'PnL',
                    data: graphdata,
                    backgroundColor: [
                        'rgba(255, 60, 56, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 60, 56, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 10
                }]
            },

            options: {
                scales: {
                    y: {
                        beginAtZero: true,

                    }            
                }
            }
        });

    })
}

// Endpoint 6
function suspicious_accounts(){
    $.get(`http://localhost/Risk/api.php?suspicious_accounts=1`, (data, status) => {

        // Clear current table
        $('#suspicious-accounts').empty()

        // Loop through data appending into table
        data.forEach(element => {
            $('#suspicious-accounts').append("<tr>" + "<td>" + element['login'] + "</td>" + "<td>" + element['Equity'] + "</td>" + "<td>" + element['Open_PnL'] + "</td>" + "<td>" + element['YESTERDAY_Closed_PnL'] + "</td>" + "<td>" + element['TODAY_Closed_PnL'] + "</td>" + "</tr>")
        })
    })
}

// Enpoint 7 - COME BACK TO
function tick_monitoring(){
    console.log("come back to")
}

// Enpoint 8
function top_10_client_exposure(){
    $.get(`http://localhost/Risk/api.php?top_10_client_exposure=1`, (data, status) => {

        // Empty table body
        $('#client_exposure').empty()

        // Loop through data appending into table
        data.forEach(element => {
            $('#client_exposure').append("<tr>" + "<td>" + element['Login'] + "</td>" + "<td>" + element['Symbols'] + "</td>" + "<td>" + element['Net_Exposure'] + "</td>" + "<td>" + element['Total_Profit_USD'] + "</td>" + "</tr>")
        })
    })
}

// Enpoint 9
function closed_trades_pnl(start,end){
    $.get(`http://localhost/Risk/api.php?start_date=${start}&end_date=${end}`, (data, status) => {

        var graphdata = [];

        data.forEach(element => {
            graphdata.push({x:element["Date"], y: parseFloat(element["Total_Closed_PnL"])})
        })

        var chartStatus = Chart.getChart('close_trade_pnl')
        if (chartStatus != undefined) { chartStatus.destroy() }

        const close_trades_pnl = document.getElementById('close_trade_pnl').getContext('2d');
        new Chart(close_trades_pnl, {
            type: "scatter",
            data: {
                datasets: [{
                    label: "Day's PnL",
                    data: graphdata,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },

            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        })
    });
}

// Enpoint 10
function aif_sync(){
    $.get(`http://localhost/Risk/api.php?aif_sync=1`, (data, status) => {

        // Clear table body
        $('#aif_sync').empty();

        // Loop through data appendinginto table
        data.forEach(element => {
            $('#aif_sync').append("<tr>" + "<td>" + element['login'] + "</td>" + "<td>" + element['Volume'] + "</td>" + "</tr>")
        })
    })
}

// Endpoint 11
function fmt_sync(){
    $.get(`http://localhost/Risk/api.php?fmt_sync=1`, (data, status) => {

        // Clear table body
        $('#fmt_sync').empty();

        // Loop through data appendinginto table
        data.forEach(element => {
            $('#fmt_sync').append("<tr>" + "<td>" + element['login'] + "</td>" + "<td>" + element['Volume'] + "</td>" + "</tr>")
        })
    })
}


// On Document Load
$(function(){

    onStart();


    // Close trade pnl button press handler
    $('#close_trades_pnl_btn').click(() => {

        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();

        closed_trades_pnl(startDate, endDate);
    })

    // Check for change on account stats tab
    $('#account-selector').on('change',(e) =>{
        account_stats(e.target.value);
    })

    // Check for change on top 10 PnL tab
    $('#top-10-pnl-selector').on('change',(e) =>{
        top_10_pnl(e.target.value);

    })

    // Check for change on bottom 10 PnL tab
    $('#bottom_10_pnl-selector').on('change',(e) =>{
        bottom_10_pnl(e.target.value);

    })

    setInterval(dataTables, 1000)
    setInterval(dataGraphs, 60000)

});

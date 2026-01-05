<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Midtrans Snap Direct</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-PsNdWysSRWU44dJt"></script>
</head>
<body>
    <h1>Test Midtrans Snap Payment</h1>
    <button onclick="testPayment()">Test Essential Package</button>

    <div id="debug"></div>

    <script>
    function testPayment() {
        const debugDiv = document.getElementById('debug');
        debugDiv.innerHTML = '<p>Fetching snap token...</p>';

        fetch('http://localhost/usahain/subscription/get_snap_token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ paket: 'essential' })
        })
        .then(response => {
            debugDiv.innerHTML += '<p>Response received: ' + response.status + '</p>';
            return response.json();
        })
        .then(data => {
            debugDiv.innerHTML += '<p>Data: ' + JSON.stringify(data) + '</p>';

            if (data.snapToken) {
                debugDiv.innerHTML += '<p>Opening Snap popup...</p>';
                window.snap.pay(data.snapToken, {
                    onSuccess: function(result){
                        alert('Pembayaran berhasil!');
                        console.log(result);
                    },
                    onPending: function(result){
                        alert('Transaksi tertunda.');
                        console.log(result);
                    },
                    onError: function(result){
                        alert('Pembayaran gagal.');
                        console.log(result);
                    },
                    onClose: function(){
                        debugDiv.innerHTML += '<p>Popup closed</p>';
                    }
                });
            } else if (data.error) {
                debugDiv.innerHTML += '<p style="color:red">Error: ' + data.error + '</p>';
            }
        })
        .catch(err => {
            debugDiv.innerHTML += '<p style="color:red">Fetch Error: ' + err.message + '</p>';
            console.error(err);
        });
    }
    </script>
</body>
</html>

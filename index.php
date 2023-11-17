<?php
$fromCurrency = "AUD";
$toCurrency = "AUD";
$amount = "";
$rounded_number = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fromCurrency = $_POST["currency1"];
    $toCurrency = $_POST["currency2"];
    $amount = $_POST["pay"];

    $keyApi = "fca_live_D22BvMjeKImGKWWRYE7T8679g7TnrVk2Ju7jIKkY";
    $apiUrl = "https://api.freecurrencyapi.com/v1/latest";
    $url = "{$apiUrl}?apikey={$keyApi}&base_currency={$fromCurrency}&symbols={$toCurrency}";

    $certPath = __DIR__ . '/cacert.pem';

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CAINFO => $certPath,
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    if ($err) {
        echo "Erreur cURL : " . $err;
    } else {
        $data = json_decode($response, true);

        if ($data && isset($data['data'])) {
            $rates = $data['data'];

            if (isset($rates[$toCurrency])) {
                $conversionRate = $rates[$toCurrency];
                $rounded_conversion = number_format($conversionRate, 4);
                $result = $amount * $conversionRate;
                $rounded_number = number_format($result, 2);
               
            } else {
                echo "Erreur : Taux de change non disponibles pour la devise de destination.";
            }
        } else {
            echo "Erreur lors de la conversion.";
        }

        curl_close($curl);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A simple live currency converter">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link href="styles.css" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <title>Currency Converter</title>
    </head>
    <body>
        <form method="post" action="index.php" id="currency-converter">
            <h1 class="mb-4">Currency Converter</h1> 
            <div class="form-group grid-container">
                <select name="currency1" id="from">
                    <option value="AUD" <?php if ($fromCurrency == "AUD") echo "selected"; ?>>AUD - Australian Dollar</option>
                    <option value="EUR" <?php if ($fromCurrency == "EUR") echo "selected"; ?>>EUR - Euro</option>
                    <option value="INR" <?php if ($fromCurrency == "INR") echo "selected"; ?>>INR - Indian Rupee</option>
                    <option value="CNY" <?php if ($fromCurrency == "CNY") echo "selected"; ?>>CNY - Chinese Yuan</option>
                    <option value="USD" <?php if ($fromCurrency == "USD") echo "selected"; ?>>USD - US Dollar</option>
                </select>

                <input type="number" inputmode="numeric" name="pay" aria-label="Pay" min="0" placeholder="0" value=<?php echo $amount; ?>>
                
                <button type="button" class="button1" onclick="invertSelection()"><span class="material-symbols-outlined">sync</span></button>

                <select name="currency2" id="to">
                    <option value="AUD" <?php if ($toCurrency == "AUD") echo "selected"; ?>>AUD - Australian Dollar</option>
                    <option value="EUR" <?php if ($toCurrency == "EUR") echo "selected"; ?>>EUR - Euro</option>
                    <option value="INR" <?php if ($toCurrency == "INR") echo "selected"; ?>>INR - Indian Rupee</option>
                    <option value="CNY" <?php if ($toCurrency == "CNY") echo "selected"; ?>>CNY - Chinese Yuan</option>
                    <option value="USD" <?php if ($toCurrency == "USD") echo "selected"; ?>>USD - US Dollar</option>
                </select>

                <output type="number" id="receive" placeholder="0" aria-label="Convert" aria-describedby="button-addon1" readonly><?php echo $rounded_number ?></output>
                <button type="submit" class="button2">Convert</button>
            </div>
        </form>

        <script>
        function invertSelection() {
            var fromCurrency = document.getElementById('from').value;
            var toCurrency = document.getElementById('to').value;

            document.getElementById('from').value = toCurrency;
            document.getElementById('to').value = fromCurrency;
        }
        </script>
    </body>
</html>
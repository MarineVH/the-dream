<?php
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
        <title>Currency Converter</title>
    </head>
    <body>
        <form method="post" action="convert.php" id="currency-converter">
            <h1 class="mb-4">Currency Converter</h1> 
            <div class="form-group grid-container">
                <select name="currency1" selected>
                    <option value="AUD">AUD - Australian Dollar</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="INR">INR - Indian Rupee</option>
                    <option value="CNY">CNY - Chinese Yuan</option>
                    <option value="USD">USD - US Dollar</option>
                </select>

                <input type="number" inputmode="numeric" name="pay" aria-label="Pay" min="0" placeholder="0" value=<?= if (isset($_POST["pay"])) ?>>
                
                <select name="currency2" selected>
                    <option value="AUD">AUD - Australian Dollar</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="INR">INR - Indian Rupee</option>
                    <option value="CNY">CNY - Chinese Yuan</option>
                    <option value="USD">USD - US Dollar</option>
                </select>

                <output type="number" id="receive" placeholder="0" aria-label="Convert" aria-describedby="button-addon1" readonly><?php echo $rounded_number ?></output>
                <button type="submit">Convert</button>
            </div>
        </form>
    </body>
</html>
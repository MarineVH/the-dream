<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $amount = $_POST['pay'];
    $from_currency = $_POST['currency1'];
    $to_currency = $_POST['currency2'];

    // Replace 'YOUR_API_KEY' with your actual ExchangeRate-API key
    $api_key = '?apikey=fca_live_XG0eGRlXIjrDcXrkm0YOGg4sKqjhwAqFAoXZXjg0';

    // API endpoint
    $api_endpoint = "https://api.freecurrencyapi.com/v1/latest/{$api_key}";

    // Fetch exchange rates from the API
    $exchange_rates_json = file_get_contents($api_endpoint);
    $exchange_rates = json_decode($exchange_rates_json, true);

    // Check if the API request was successful
    if ($exchange_rates['result'] == 'success') {
        // Get exchange rates
        $rates = $exchange_rates['rates'];

        // Convert currency
        $converted_amount = $amount * ($rates[$to_currency] / $rates[$from_currency]);

        // Display the result
        echo '<h1 class="mb-4">Currency converter</h1>';
        echo '<div class="form-group">';
        echo '<select name="currency1" value="' . $from_currency . '" disabled>';
        echo '<option>' . $from_currency . ' - ' . array_search($rates[$from_currency], $rates) . '</option>';
        echo '</select>';
        echo '<input type="text" name="pay" aria-label="Pay" placeholder="' . $amount . '" disabled></br>';
        echo '<select name="currency2" value="' . $to_currency . '" disabled>';
        echo '<option>' . $to_currency . ' - ' . array_search($rates[$to_currency], $rates) . '</option>';
        echo '</select>';
        echo '<input type="text" id="receive" placeholder="' . number_format($converted_amount, 2) . '" aria-label="Convert" aria-describedby="button-addon1" readonly>';
        echo '</div>';
    } else {
        // Display an error message if the API request failed
        echo '<p>Error fetching exchange rates. Please try again later.</p>';
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
        <form method="post" id="currency-converter">
            <h1 class="mb-4">Currency Converter</h1> 
            <div class="form-group grid-container">
                <select name="currency1">
                    <option value="AUD">AUD - Australian Dollar</option>
                    <option value="EGP">EGP - Egyptian Pound</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="INR">INR - Indian Rupee</option>
                    <option value="CNY">CNY - Chinese Yuan</option>
                    <option value="USD">USD - US Dollar</option>
                </select>

                <input type="text" name="pay" aria-label="Pay" placeholder="0">
                
                <select name="currency2">
                    <option value="AUD">AUD - Australian Dollar</option>
                    <option value="EGP">EGP - Egyptian Pound</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="INR">INR - Indian Rupee</option>
                    <option value="CNY">CNY - Chinese Yuan</option>
                    <option value="USD">USD - US Dollar</option>
                </select>

                <input type="text" id="receive" placeholder="0" aria-label="Convert" aria-describedby="button-addon1" readonly >
            </div>
        </form>
    </body>
</html>
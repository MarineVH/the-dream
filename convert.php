<?php

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link href="styles.css" rel="stylesheet">
        <title>Currency Converter</title>
    </head>
    <body>
        <div class="container w-25 p-5 mt-5" id="currency-converter">
            <h1 class="mb-4">Currency converter</h1> 
            <div class="inputs">
                <div class="input-group mb-3" id="currency">
                    <label class="input-group-text" for="inputGroupSelect01">From</label>
                    <select class="form-select" id="inputGroupSelect01">
                    </select>
                </div>
                <div class="input-group mb-3" id="pay">
                    <label class="input-group-text">Pay</label>
                    <input type="text" class="form-control" aria-label="Pay" placeholder="1500">
                </div>
                <div class="input-group mb-3" id="currency">
                    <label class="input-group-text" for="inputGroupSelect02">To</label>
                    <select class="form-select" id="inputGroupSelect02">
                    </select>
                </div>
                <div class="input-group mb-3" id="receive">
                    <label class="input-group-text">Receive</label>
                    <input type="text" class="form-control" placeholder="" aria-label="Convert" aria-describedby="button-addon1" readonly >
                </div>
            </div>
        </div>
    </body>
</html>
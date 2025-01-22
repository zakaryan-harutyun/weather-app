<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="js/scripts.js" defer></script>
</head>
<body>
<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-5">
            <span class="text-danger">Jacket</span> or
            <span class="text-success">No Jacket</span>
        </h1>
        <p class="lead">Find out whether you need a jacket based on the weather forecast!</p>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" id="cityInput" class="form-control" placeholder="Enter city name (e.g., Tel Aviv)">
                <button class="btn btn-primary" onclick="fetchWeatherFromAPI()">Get from API</button>
                <button class="btn btn-warning" onclick="fetchWeatherFromDB()">Get from DB</button>
            </div>
        </div>
    </div>

    <div id="errorMessage" class="alert alert-danger d-none text-center" role="alert">
        No data found for the entered city. Please try again with a valid city name.
    </div>

    <div id="infoArea" class="card shadow mb-4 d-none">
        <div class="card-body">
            <h5 id="cityName" class="card-title text-center"></h5>
            <p id="forecastPeriod" class="card-text text-center"></p>
            <div id="saveForecastBtn" class="text-center">
                <button class="btn btn-success" onclick="saveForecast()">Save Forecast</button>
            </div>
        </div>
    </div>

    <div id="forecastTable" class="table-responsive d-none">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-light">
            <tr>
                <th>Datetime</th>
                <th>Min Temp (°C)</th>
                <th>Max Temp (°C)</th>
                <th>Wind Speed (km/h)</th>
            </tr>
            </thead>
            <tbody id="forecastBody"></tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

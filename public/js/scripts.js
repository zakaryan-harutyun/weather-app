let cityName = ''; // Declare a variable to store the city name
let forecastData = []; // Declare a variable to store the forecast data

function getWeather() {
    const city = document.getElementById('cityInput').value;
    axios.post('/get-weather', { city_name: city })
        .then(response => {
            cityName = response.data.city.name; // Store the city name
            forecastData = response.data.list; // Store the forecast data
            displayWeather(response.data);
        }).catch(error => console.error(error));
}

function saveForecast() {
    if (forecastData.length > 0) {
        const firstForecast = forecastData[0];
        const timestamp = firstForecast.dt_txt;
        const minTemp = firstForecast.main.temp_min.toFixed(1);
        const maxTemp = firstForecast.main.temp_max.toFixed(1);
        const windSpeed = firstForecast.wind.speed.toFixed(1);

        axios.post('/save-weather', {
            city_name: cityName, // Use the stored city name
            timestamp_dt: timestamp,
            min_tmp: minTemp,
            max_tmp: maxTemp,
            wind_spd: windSpeed
        })
            .then(response => {
                alert('Weather data saved successfully!');
            })
            .catch(error => console.error('Error saving data: ', error));
    } else {
        alert('No forecast data available to save!');
    }
}

function loadFromDb() {
    const city = document.getElementById('cityInput').value;

    axios.get(`/load-weather/${city}`)
        .then(response => {
            const data = response.data.data;
            if (data) {
                displayWeatherFromDb([data]);
                const updatedAt = new Date(data['updated_at']).toLocaleString();
                document.getElementById('forecastPeriod').innerText = `Updated at: ${updatedAt}`;
            } else {
                alert('No forecast data found for this city!');
            }
        })
        .catch(error => {
            console.error(error);
            displayWeatherFromDb(null);
        });
}

function displayWeather(data) {
    const forecastContainer = document.getElementById('forecastTable');
    const forecastBody = document.getElementById('forecastBody');
    const infoArea = document.getElementById('infoArea');
    const errorMessage = document.getElementById('errorMessage');
    const saveForecastBtn = document.getElementById('saveForecastBtn');

    forecastContainer.classList.add('d-none');
    forecastBody.innerHTML = '';

    infoArea.classList.add('d-none');
    saveForecastBtn.classList.remove('d-none');

    if (!data || !data.list || data.cod !== "200") {
        errorMessage.classList.remove('d-none');
        return;
    }

    errorMessage.classList.add('d-none');

    const cityName = data.city.name;
    document.getElementById('cityName').innerText = cityName;

    const startPeriod = new Date(data.list[0].dt * 1000).toLocaleString();
    const endPeriod = new Date(data.list[data.list.length - 1].dt * 1000).toLocaleString();

    document.getElementById('forecastPeriod').innerText = `Forecast period: ${startPeriod} to ${endPeriod}`;

    infoArea.classList.remove('d-none');
    forecastContainer.classList.remove('d-none');

    if (data.list && Array.isArray(data.list)) {
        data.list.forEach(item => {
            const timestamp = item.dt_txt;
            const minTemp = item.main.temp_min.toFixed(1);
            const maxTemp = item.main.temp_max.toFixed(1);
            const windSpeed = item.wind.speed.toFixed(1);

            let row = `<tr>
                        <td>${timestamp}</td>
                        <td>${minTemp}°C</td>
                        <td>${maxTemp}°C</td>
                        <td>${windSpeed} km/h</td>
                    </tr>`;
            forecastBody.innerHTML += row;
        });
    }
}

function displayWeatherFromDb(data) {
    const forecastContainer = document.getElementById('forecastTable');
    const forecastBody = document.getElementById('forecastBody');
    const infoArea = document.getElementById('infoArea');
    const saveForecastBtn = document.getElementById('saveForecastBtn');
    const errorMessage = document.getElementById('errorMessage');

    forecastContainer.classList.add('d-none');
    forecastBody.innerHTML = '';

    infoArea.classList.add('d-none');
    saveForecastBtn.classList.add('d-none');

    if (!data) {
        errorMessage.classList.remove('d-none');
        return;
    }

    errorMessage.classList.add('d-none');

    const cityName = data[0].city_name;
    document.getElementById('cityName').innerText = cityName;

    const updatedAt = new Date(data[0].updated_at).toLocaleString();
    document.getElementById('forecastPeriod').innerText = `Updated at: ${updatedAt}`;

    let row = `<tr>
                <td>${data[0].timestamp_dt}</td>
                <td>${data[0].min_tmp}°C</td>
                <td>${data[0].max_tmp}°C</td>
                <td>${data[0].wind_spd} km/h</td>
            </tr>`;
    forecastBody.innerHTML += row;

    infoArea.classList.remove('d-none');
    forecastContainer.classList.remove('d-none');
}

function fetchWeatherFromAPI() {
    getWeather();
}

function fetchWeatherFromDB() {
    loadFromDb();
}

# Universal Travel Planner API


A centralized PHP-based API that aggregates travel-related information from multiple third-party APIs, including weather (OpenWeatherMap), hotel availability (Expedia via RapidAPI), and local events (Eventbrite). It provides a unified JSON response for a given destination, leveraging SQLite for caching and search history.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Project Structure](#project-structure)
- [Requirements](#requirements)
- [Setup Instructions](#setup-instructions)
- [API Endpoints](#api-endpoints)
- [Usage Examples](#usage-examples)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## Overview
The Universal Travel Planner API simplifies travel planning by fetching and combining data from multiple sources into a single, consistent response. Instead of querying multiple APIs, users can make one request to get weather, hotel, and event information for a destination city.

## Features
- **Unified Data**: Aggregates weather, hotel, and event data for a given city.
- **Caching**: Uses SQLite to cache API responses, reducing third-party API calls.
- **Search History**: Logs user searches for analytics or personalization.
- **Error Handling**: Gracefully handles third-party API failures with partial responses.
- **Extensible**: Modular design with services and transformers for easy addition of new APIs.
- **Secure**: Supports API key authentication via `X-API-Key` header.

## Project Structure
```
universal-travel-api/
├── app/
│   ├── Cache/
│   │   └── CacheManager.php
│   ├── Core/
│   │   ├── ApiWrapper.php
│   │   ├── Logger.php
│   │   └── Router.php
│   ├── Database/
│   │   └── Database.php
│   ├── Exceptions/
│   │   ├── InvalidRequestException.php
│   │   └── ThirdPartyApiException.php
│   ├── Middleware/
│   │   └── AuthMiddleware.php
│   ├── Models/
│   │   └── SearchHistory.php
│   ├── Services/
│   │   ├── EventsClient.php
│   │   ├── HotelClient.php
│   │   └── WeatherClient.php
│   ├── Transformers/
│   │   ├── EventsTransformer.php
│   │   ├── HotelTransformer.php
│   │   └── WeatherTransformer.php
├── config/
│   ├── api_keys.php
│   ├── cache.php
│   └── database.php
├── logs/
├── public/
│   └── index.php
├── storage/
│   └── travel.db
├── tests/
│   └── Services/
│       └── WeatherClientTest.php
├── .env
├── .gitignore
├── composer.json
└── README.md
```

## Requirements
- PHP 8.1 or higher
- Composer
- SQLite (included with PHP via `pdo_sqlite` extension)
- API keys for:
  - [OpenWeatherMap](https://openweathermap.org/api)
  - [Expedia (via RapidAPI)](https://rapidapi.com/hub)
  - [Eventbrite](https://www.eventbrite.com/developer/v3/)

## Setup Instructions
1. **Clone the Repository**
   ```bash
   git clone https://github.com/AliOding12/universal-travel-api.git
   cd universal-travel-api
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Configure Environment**
   - Copy `.env.example` to `.env` (create one if not provided):
     ```bash
     cp .env.example .env
     ```
   - Add your API keys and configurations in `.env`:
     ```
     OPENWEATHERMAP_API_KEY=your_openweathermap_api_key
     EXPEDIA_API_KEY=your_expedia_api_key
     EVENTBRITE_API_KEY=your_eventbrite_api_key
     API_KEY=your_api_key_for_auth
     DB_DRIVER=sqlite
     DB_PATH=storage/travel.db
     CACHE_DRIVER=sqlite
     CACHE_TTL=3600
     ```

4. **Set Up SQLite Database**
   - Ensure the `storage` directory is writable:
     ```bash
     mkdir storage
     chmod 775 storage
     ```
   - The `Database.php` class will automatically create `travel.db` and tables on first run.

5. **Run a Local Server**
   - Use PHP's built-in server for testing:
     ```bash
     php -S localhost:8000 -t public
     ```

6. **Test the API**
   - Make a request to `http://localhost:8000/destination/new-york` with the `X-API-Key` header.

## API Endpoints
### GET `/destination/{city}`
Fetches aggregated travel data for a specified city.

- **Parameters**:
  - `city`: The name of the city (e.g., `new-york`, `london`).
- **Headers**:
  - `X-API-Key`: Your API key for authentication.
- **Response**:
  ```json
  {
    "city": "new-york",
    "weather": {
      "city": "New York",
      "temperature": 20,
      "description": "clear sky",
      "humidity": 65,
      "wind_speed": 5,
      "timestamp": 1696114800
    },
    "hotels": [
      {
        "name": "Example Hotel",
        "latitude": 40.7128,
        "longitude": -74.0060,
        "destination_id": "12345"
      }
    ],
    "events": [
      {
        "name": "Concert in Central Park",
        "start_time": "2025-08-10T19:00:00",
        "venue": "Central Park",
        "url": "https://www.eventbrite.com/e/12345"
      }
    ],
    "errors": []
  }
  ```

## Usage Examples
### cURL
```bash
curl -H "X-API-Key: your_api_key" http://localhost:8000/destination/new-york
```

### PHP
```php
$ch = curl_init('http://localhost:8000/destination/new-york');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-API-Key: your_api_key']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
```

## Testing
Run unit tests using PHPUnit:
```bash
composer test
```

The test suite includes:
- `WeatherClientTest.php`: Tests the `WeatherClient` class with mocked API responses.

## Contributing
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -m "Add your feature"`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Open a pull request.

Please include tests for new features and follow PSR-12 coding standards.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---
*Built with :heart: by Abbas Ali *
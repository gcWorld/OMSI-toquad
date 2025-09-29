# OMSI-toquad
PHP script to use Bing, Azure Maps, Google, and Yandex aerial imagery within the OMSI 2 Editor.

## Services Available

- **Bing Maps** (`service=bing`): Original Bing Maps API (maintained for backward compatibility)
- **Azure Maps** (`service=azure`): New Azure Maps API (recommended for future use)
- **Google Maps** (`service=google`): Google Maps Static API  
- **Yandex Maps** (`service=yandex`): Yandex Static Maps API

## Dependencies

For Bing Maps service, requires the PHP REST Client:
https://github.com/tcdent/php-restclient

Azure Maps service has no external dependencies.

## Usage

### Azure Maps (Recommended)
```
toquad.php?service=azure&apicode=YOUR_AZURE_SUBSCRIPTION_KEY&x=1&y=1&z=2
```

### Bing Maps (Legacy)
```
toquad.php?service=bing&apicode=YOUR_BING_API_KEY&x=1&y=1&z=2
```

Note: Azure Maps requires a subscription key which can be obtained from the Azure Portal.

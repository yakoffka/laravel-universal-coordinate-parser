# Универсальный парсер координат для фреймворка laravel

## Общие сведения
Библиотека преобразования строки координат в одном из распространенных форматов в объект Point для фреймворка Laravel

## Установка
```
composer require yakoffka/laravel-universal-coordinate-parser
```

## Использование
Библиотека предоставляет один метод, принимающих в качестве обязательного аргумента координаты географической точки в
строковом представлении и возвращающего объект Yakoffka\UniversalCoordinateParser\Dto\PointDTO:
- getPointDto(string $subject): PointDto;

```
$point = UniversalCoordinateParser::getPointDto('36°01′N/75°01′W')

dd($point);

// Outputs:
Yakoffka\UniversalCoordinateParser\Dto\PointDTO {
    +lat: 36.016667
    +lon: -75.016667
    +src: "36°01′N/75°01′W"
    +pattern: "pattern01"
}
```


# Laravel universal coordinate parser

## General information
Library for converting a coordinate string in one of the common formats into a Point object for the Laravel framework

## Install
```
composer require yakoffka/laravel-universal-coordinate-parser
```

## Usage
The library provides one method that takes as a mandatory argument the coordinates of a geographic point in a string 
representation and returns a Yakoffka\UniversalCoordinateParser\Dto\PointDTO object:
- getPointDto(string $subject): PointDto;

```
$point = UniversalCoordinateParser::getPointDto('36°01′N/75°01′W')

dd($point);

// Outputs:
Yakoffka\UniversalCoordinateParser\Dto\PointDTO {
    +lat: 36.016667
    +lon: -75.016667
    +src: "36°01′N/75°01′W"
    +pattern: "pattern01"
}
```

## License

Laravel universal coordinate parser is open-sourced software licensed under the MIT license

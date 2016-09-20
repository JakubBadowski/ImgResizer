# ImgResizer
Klasa kopiuje obrazki z podanego katalogu do innego i zmienia ich rozdzielczość

## How to use
### Create file run.php
```php
include_once 'copyImgClass.php';

$imgLib = new copyImgClass();

$imgLib->setInputDir('/path/to/input/dir/');
$imgLib->setOutputDir(__DIR__ . '/path/to/output/dir/');
$imgLib->goWork();

```
### Run via console
```bash
php run.php
```

# Config builder

[![Build Status](https://travis-ci.org/iamsalnikov/config-builder.svg?branch=master)](https://travis-ci.org/iamsalnikov/config-builder)

Библиотека предназначена для сборки конфгов.

## 1. Установка

```
composer require iamsalnikov/config-builder
```

## 2. Использование

Определим базовые понятия:

1. PlaceholderProcessor - это компонент, который находит шаблоны в файле, который нужно
собрать. Также этот компонент производит замену шаблона на конкретное значение
2. ValueProvider - это компонент, который отдает то или иное значение для запрашиваемого
шаблона.

### 2.1. Конфиг

Перед началом работы нужно сконфигурировать билдер таким образом, чтобы он знал, как извлекать
шаблоны, где брать значения для этих шаблонов. Пример файла конфигурации (`config_builder.yaml`):

```yaml
# Определяем обработчики шаблонов. Их может быть несколько
placeholder_processors:
  # Просто имя, ничего не значит
  Basic:
    # Класс обработчика. Можно определить свой (об этом будет рассказано ниже)
    class: iamsalnikov\ConfigBuilder\PlaceholderProcessors\BasicProcessor
    # Список аргументов для конструктора обработчика. В данном примере
    # первый аргумент - левая граница плейсхолдера
    # второй аргумент - правая граница плейсхолдера
    arguments:
      - "{{"
      - "}}"

# Определим провайдеры значений для плейсхолдеров (все будут описаны ниже)
# Значения получаем из провайдеров, определенных по порядку. Если в первом провайдере
# значение не найдено, то попробуем его найти в следующем. И так до самого конца списка
# провайдеров
value_providers:
  # Просто имя, ничего не значит
  YamlProvider:
    # Класс провайдера. Можно определить свой (об этом будет рассказано ниже)
    class: iamsalnikov\ConfigBuilder\ValueProviders\Yaml
    # Список аргументов для конструктора провайдера. В данном случае - путь до файла со значениями
    arguments:
      - /var/www/placeholders/data.yaml
      
  Environment:
    class: iamsalnikov\ConfigBuilder\ValueProviders\Environment
    arguments:
      - PRF_
```

### 2.2. Запуск

Для запуска нужно выполнить команду:

```
vendor/bin/config_builder path/to/config.php
```

В данном случае будет произведена попытка найти файл конфигурации билдера (`config_builder.yaml`) в текущей активной директории
пользоваля. После чего будет прочитан файл `path/to/config.php` и в нем будут заменены все плейсхолдеры на значения из
источников.

В том случае, если конфиг для билдера лежит в каком-то другом месте, можно передать путь до конфига с помощью опции `-c`
или `--config`:

```
vendor/bin/config_builder -c path/to/config_builder.yaml path/to/config.php
```

Результат работы выдается в stdout. В том случае, если нужно все сохранить в файл, то можно
воспользоваться перенаправлением вывода:

```
vendor/bin/config_builder path/to/config.example.php > path/to/config.php
```

## 3. Имена шаблонов

Каждый шаблон обычно ограничен какими-либо рамками в начале и конце. Например: `{{db.host}}`. В текущем
примере имя шаблона - это `db.host`

В именах мы можем использовать вложенность, если нам нужно получить значение из массива. Уровни
разделяем с помощью точки (`.`). Есть возможность использовать и цифровые индексы.

## 4. Обработчики шаблонов

Каждый обработчик шаблона должен реализовывать интерфейс `iamsalnikov\ConfigBuilder\Interfaces\PlaceholderProcessor`.

На текущий момент есть только один обработчик шаблонов - `iamsalnikov\ConfigBuilder\PlaceholderProcessors\BasicProcessor`. 
Его конструктор принимает два аргумента: левая граница плейсхоледра и правая граница плейсхолдера.

## 5. Провайдеры значений

Каждый провайдер значений реализует интерфейс `iamsalnikov\ConfigBuilder\Interfaces\ValueProvider`.

На текущий момет есть три провайдера значений:

1. `iamsalnikov\ConfigBuilder\ValueProviders\Environment` - провайдер значений из переменных окружения.

Конструктор принимает один необязательный аргумент: префикс переменной окружения.

Имена шаблонов, которые используют вложенность (например, `db.host`) будут преобразованы в `DB_HOST`.
Если же установлен префикс, например, `GG_`, то значение для шаблона будет искаться в переменной
окружения `GG_DB_HOST`.

2. `iamsalnikov\ConfigBuilder\ValueProviders\Json` - провайдер значений из `json`-файла.

Конструктор принимает один обязательный аргумент: путь до файла со значениями.
Если путь не абсолютный, то он будет вычисляться относительно папки, содержащей конфиг
сборщика.

Для получения вложенных значений используем синтаксис из пункта 3 (`db.host`, `user.0.email`).

3. `iamsalnikov\ConfigBuilder\ValueProviders\Yaml` - аналогично провайдеру `Json`, только работает
с `yaml`-файлами.

> Всегда есть возможность определить свой собственный провайдер данных и использовать его

Провайдеров данных может быть множество. В этом случае мы ищем значение для шаблона до тех пор, пока какой-то
из провайдеров не отдаст там что-то, либо пока не будет достигнут конец списка провайдеров.

## 6. Пример работы

Имеем файл конфига `/var/www/config_builder.yaml`:

```yaml
placeholder_processors:
  Basic:
    class: iamsalnikov\ConfigBuilder\PlaceholderProcessors\BasicProcessor
    arguments:
      - "{{"
      - "}}"

value_providers:
  YamlProvider:
    class: iamsalnikov\ConfigBuilder\ValueProviders\Yaml
    arguments:
      - placeholders/data.yaml # файл будет найден в /var/www/placeholders/data.yaml
      
  Environment:
    class: iamsalnikov\ConfigBuilder\ValueProviders\Environment
    arguments:
      - PRF_
```

Данные из файла `/var/www/placeholders/data.yaml`:

```yaml
db:
  host: localhost
  port: 3306
  dbName: hello
  user: user
  password: superpassword
```

Переменная окружения `PRF_DB_SECURITY_KEY="securnost"`
 
Контент файла с шаблонами (`config.php`):

```php
<?php

return [
    'db' => [
      'connectionString' => 'mysql:{{db.host}}:{{db.port}}/{{db.dbName}}',
      'user' => '{{db.user}}',
      'password' => '{{db.password}}',
      'encryptionKey' => '{{db.securityKey}}'
    ]
];
```

Запускаем команду:

```
vendor/bin/config_builder config.php
```

Получаем вывод:

```php
<?php

return [
    'db' => [
      'connectionString' => 'mysql:localhost:3306/hello',
      'user' => 'user',
      'password' => 'superpassword',
      'encryptionKey' => 'securnost'
    ]
];
```
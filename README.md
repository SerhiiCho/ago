![Ago package](https://serhiicho.com/storage/other/ago.png)

[![Ago](https://github.com/php-ago/ago/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/php-ago/ago/actions/workflows/php.yml)
[![Total Downloads](https://poser.pugx.org/serhii/ago/downloads)](https://packagist.org/packages/serhii/ago)
[![License](https://poser.pugx.org/serhii/ago/license)](https://packagist.org/packages/serhii/ago)

Date/time converter into "n time ago" format that supports multiple languages, such as 🇷🇺 🇬🇧 🇳🇱 🇺🇦 🇩🇪. You can contribute any language that you wish easily by creating a pull request. When new PHP version comes out, this package will be updated to support it as soon as possible.

This package is well tested, optimized and already used in many production apps. It has shown itself pretty well. If you find any issues or bugs 🐞, please create an [issue](https://github.com/php-ago/ago/issues/new), and I'll fix it as soon as I can.

### Follow the [official documentation](https://php-ago.github.io/) for more information

## Supported Languages
| Flag | Language              | ISO 639-1 |
| ---- | --------------------- | --------- |
| 🇬🇧   | English               | `en`      |
| 🇷🇺   | Russian               | `ru`      |
| 🇺🇦   | Ukrainian             | `uk`      |
| 🇳🇱   | Dutch                 | `nl`      |
| 🇩🇪   | German                | `de`      |
| 🇨🇳   | Chinese Simplified    | `zh`      |

## Quick Start
```bash
composer require serhii/ago
```

## License
The Ago project is licensed under the [MIT License](https://github.com/php-ago/ago/blob/master/LICENSE)

## Contribute
### With Container Engine
> [!NOTE]
> If you use [🐳 Docker](https://app.docker.com/) instead of [🦦 Podman](https://podman.io/), just replace `podman-compose` with `docker compose`, and `podman` with `docker` in code examples below.

#### Build an Image
To build an image, navigate to the root of project and run this command:
```bash
podman-compose build app
```

#### Run the Container
To run the container, navigate to the root of and run this command:
```bash
podman-compose run --rm app
```

#### Cleanup
After you are done working on a project, you can cleanup and run the command below to remove things like created networks for the current project run this:
```bash
podman-compose down
```

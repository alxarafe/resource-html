#!/bin/bash
# Description: Runs static analysis tools (PHPStan, Psalm).

echo "Running PHPStan..."
docker exec alxarafe-html ./vendor/bin/phpstan analyse src --memory-limit=1G

echo "Running Psalm..."
docker exec alxarafe-html ./vendor/bin/psalm src --output-format=console

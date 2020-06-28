# employees-salary-library

The framework agnostic library to calculate employees salary based on the specific rules. 
Write on pure PHP7.2+ with simple bootstrap page for showing net salary for specific employee.

To build library simply run composer install in the root directory.
For testing uses php-unit library. Test can be run with the following standard command: _"./vendor/bin/phpunit tests"_ in the root directory.

To check salary results with custom employee's settings uses simple page with bootstrap inside public directory.
Script can be run by using some web-servers (nginx, apache, etc) or simply using php internal server by using the following command:
_php -S localhost:8000_ in the public directory of root application page.
# Aegon task

## Installation
1. Clone this repository
2. Install composer dependencies by running `composer install`
   (`composer update` may be also needed)

## Running
Run this command in root of the project: `php ./src/generate_language_files.php`

## Tests
If you want to run tests, run this command: `./vendor/bin/phpunit`

## Task:
Your task is to refactor the LanguageBatchBo!
The solution will be evaluated based on the following goals:
* Keep the original functionality.
* Increase the inner code quality.

## Rules:
* Create local git repository for the project.
* Commit after each coding step, when the system is in working condition.
* The interface of the LanguageBatchBo can't be changed (the
generate_language_files.php should remain the same), but (of course) it's
content can change and it can be split into new classes.
* The ApiCall, and Config classes are mock/simplified versions of the original
dependencies, they can not be changed.
* The error message of the exceptions can be simplified.
* The console output of the script doesn't have to be the same as in the original
version.
* You can upgrade code and dependencies to PHP 7.4
* Inline comments are not necessary.
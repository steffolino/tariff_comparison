#Tariff Comparison Assignment

#Prerequisites
1.Setup 2 MySQL Databases:
- "homestead" for regular use & dev
- "testing" for testing
or change config in .env and phpunit.xml files accordingly

2.Install nodejs/npm for compilation of js and vue files

#Local Setup
open bash in root directoy:
1. composer update
2. php artisan serve
3. php artisan migrate (setup database)
4. php artisan db:seed (fill database) - optionally uncomment below line 43 for more random data
5. npm install
6. npm run watch
7. call 127.0.0.1:8000

#Testing
open bash in root directory:
vendor/bin/phpunit

#Enhancement Ideas
- More Vue.js frontend magic
- Improve CSS/SCSS
- Add/Delete/Edit Feature for Tariffs
- User Authentication for CRUD Actions (currently not implemented)
- Frontend / Javascript Testing
- Frontend: Pagination, Sort by ..., Search, Slider for Consumption Selection
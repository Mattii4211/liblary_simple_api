## Endpoints:

## BookController:

* 'api/books/list' - wyświetlanie książek
* 'api/books/list?find=text' - wyświetlanie książek spełniających szukaną farazę (można by bardziej parametryzować ale na podstawie info w mailu wydaje się to wystarczjące)
* 'api/books/{book}' - info o danej książce, {book} - id danej książki

## CustomerController:

* 'api/customers/list' - lista klientów (bez filtriowania)
* 'api/customers/{customer}' - dane klienta, {customer} - id klienta
* 'api/customers/add' - dodanie klienta, wymagane pola name, last_name
* 'api/customers/{customer}/remove' - usunięcie klienta (jeśli nie ma żadnych wypożyczonych książek), {customer} - id klienta

## RentalController:

* 'api/rental/add' - dodanie wypożyczenia, wymagane customer_id oraz book_id
* 'api//rental/{rental}/remove' - usunięcie wypożyczenia, {rental} - uuid wypożyczenia
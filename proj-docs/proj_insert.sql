insert into Users values
('omgitzme', 'admin', 'hihi', 'Harry Zhi', '6042312412', 
'6223 Bateman St.', DATE '1961-01-01', 'F');

insert into Users values
('Wewic', 'admin', 'password', 'Eric Wu', '6041232040', 
'604 Vancouver Ave.', DATE '1995-04-18', 'F');

insert into Users values
('ptlin', 'admin', 'greetings', 'Patrick Lin', '6041235235', 
'6224 Bateman St.', DATE '1961-01-01', 'F');

insert into Users values
('quanbao', 'admin', 'ptran', 'Paul Tran', '6041252341', 
'6225 Bateman St.', DATE '1961-01-02', 'F');

insert into Users values
('newuser', 'customer', 'random', 'John Smith', '8329103291', 
'1513 Las Vegas St.', DATE '2016-11-01', 'F');

insert into Users values
('chef1', 'chef', 'cooking', 'Rordon Gamsey', '8329192919', 
'1514 Las Vegas St.', DATE '2016-11-02', 'F');

insert into Chef values
('chef1', 'omgitzme', 100000, 234213205);

insert into Orders values
(1, 'newuser', 'chef1', DATE '2016-11-01', 
NULL, 'processing');

insert into Orders values
(2, 'newuser', 'chef1', DATE '2016-11-02', 
NULL, 'processing');

insert into Invoice values
(1, 'newuser', 34.50, DATE '2016-11-01', 'credit');

insert into Invoice values
(2, 'newuser', 125.23, DATE '2016-11-02', 'cash');

insert into Menuitem values
('Shrimp Fried Rice', 11.00, 'http://', 'Egg fried rice with shrimps', 'F');

insert into MenuItem values
('Deluxe Burger', 8.95, 'http://', 'Hamburger with lettuce, tomato, pickles, and 
	a beef patty', 'F');

insert into Ingredient values
('Lettuce', 8, 'F');

insert into Ingredient values
('Tomato', 6, 'F');

insert into Ingredient values
('Burger Buns', 4, 'F');

insert into Ingredient values
('Beef Patty', 4, 'F');

insert into Ingredient values
('Rice', 5, 'F');

insert into Ingredient values
('Egg', 4, 'F');

insert into Ingredient values
('Shrimp', 4, 'F');

insert into Contains values
(1, 'Shrimp Fried Rice', 1);

insert into Contains values
(1, 'Deluxe Burger', 1);

insert into Contains values
(2, 'Shrimp Fried Rice', 3);

insert into MadeOf values
('Shrimp Fried Rice', 'Rice');

insert into MadeOf values
('Shrimp Fried Rice', 'Egg');

insert into MadeOf values
('Shrimp Fried Rice', 'Shrimp');

insert into MadeOf values
('Deluxe Burger', 'Burger Buns');

insert into MadeOf values
('Deluxe Burger', 'Lettuce');

insert into MadeOf values
('Deluxe Burger', 'Tomato');

insert into MadeOf values
('Deluxe Burger', 'Beef Patty');







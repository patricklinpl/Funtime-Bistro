insert into Users values ('omgitzme', 'admin', 'hihi', 'Harry Zhi', '6042312412', '6223 Bateman St.', DATE '1961-01-01', 'F');

insert into Users values ('Wewic', 'chef', 'password', 'Eric Wu', '6041232040', '604 Vancouver Ave.', DATE '1995-04-18', 'F');

insert into Users values ('ptlin', 'customer', 'greetings', 'Patrick Lin', '6041235235', '6224 Bateman St.', DATE '1961-01-01', 'F');

insert into Users values ('quanbao', 'customer', 'ptran', 'Paul Tran', '6041252341', '6225 Bateman St.', DATE '1961-01-02', 'F');

insert into Users values ('newuser', 'customer', 'random', 'John Smith', '8329103291', '1513 Las Vegas St.', DATE '2016-11-01', 'F');

insert into Users values ('chef1', 'chef', 'cooking', 'Rordon Gamsey', '8329192919', '1514 Las Vegas St.', DATE '2016-11-02', 'F');


insert into Chef (chef_userName, admin_userName, ssNum) values ('chef1', 'omgitzme', 234213205);

insert into Chef (chef_userName, admin_userName, ssNum) values ('Wewic', 'omgitzme', 234013005);


insert into Orders (customer_userName, chef_userName, orderdate, cookeddate, status) values ('newuser', 'chef1', DATE '2016-11-01', DATE '2016-11-01', 'open');

insert into Orders (customer_userName, chef_userName, orderdate, cookeddate, status) values ('ptlin', 'Wewic', DATE '2016-11-02', DATE '2016-11-01', 'open');

insert into Orders (customer_userName, chef_userName, orderdate, cookeddate, status) values ('quanbao', 'Wewic', DATE '2016-11-01', DATE '2016-11-01', 'open');


insert into Invoice values (1, 'newuser', 34.50, DATE '2016-11-01', 'credit');

insert into Invoice values (2, 'ptlin', 125.23, DATE '2016-11-02', 'cash');

insert into Invoice values (3, 'quanbao', 125.23, DATE '2016-11-02', 'cash');


insert into Menuitem (name, price, imagepath, description, quantity, m_deleted) values ('Shrimp Fried Rice', 11.00, 'http://', 'Egg fried rice with shrimps', 3, 'F');

insert into Menuitem (name, price, imagepath, description, quantity, m_deleted) values ('Deluxe Burger', 8.95, 'http://', 'Hamburger with lettuce, tomato, pickles, and a beef patty', 5, 'F');

insert into Menuitem (name, price, imagepath, description, quantity, m_deleted) values ('Ice cream ramen', 5.23, 'http://', 'Noodles in a cone!', 10, 'F');

insert into Menuitem (name, price, imagepath, description, quantity, m_deleted) values ('Beef smoothie', 6.21, 'http://', 'A healthy blend of greens and beef to ensure you hit your protein macros.', 1, 'F');

insert into Menuitem (name, price, imagepath, description, quantity, m_deleted) values ('Deep fried protein powder', 18.43, 'http://', 'Anything is better deep fried!', 15, 'F');


insert into Ingredient (name, i_deleted) values ('Lettuce', 'F');

insert into Ingredient (name, i_deleted) values ('Tomato',  'F');

insert into Ingredient (name, i_deleted) values ('Burger Buns', 'F');

insert into Ingredient (name, i_deleted) values ('Beef Patty', 'F');

insert into Ingredient (name, i_deleted) values ('Rice',  'F');

insert into Ingredient (name, i_deleted) values ('Egg',  'F');

insert into Ingredient (name, i_deleted) values ('Shrimp', 'F');

insert into Ingredient (name, i_deleted) values ('Ramen', 'F');

insert into Ingredient (name, i_deleted) values ('Ice cream', 'F');

insert into Ingredient (name, i_deleted) values ('Protein', 'F');


insert into Contains values (1, 'Shrimp Fried Rice', 2);

insert into Contains values (1, 'Deluxe Burger', 3);

insert into Contains values (2, 'Ice cream ramen', 3);

insert into Contains values (2, 'Beef smoothie', 1);

insert into Contains values (2, 'Shrimp Fried Rice', 1);

insert into Contains values (3, 'Deep fried protein powder', 10);

insert into Contains values (3, 'Deluxe Burger', 2);


insert into MadeOf values ('Shrimp Fried Rice', 'Rice');

insert into MadeOf values ('Shrimp Fried Rice', 'Egg');

insert into MadeOf values ('Shrimp Fried Rice', 'Shrimp');

insert into MadeOf values ('Deluxe Burger', 'Burger Buns');

insert into MadeOf values ('Deluxe Burger', 'Lettuce');

insert into MadeOf values ('Deluxe Burger', 'Tomato');

insert into MadeOf values ('Deluxe Burger', 'Beef Patty');

insert into MadeOf values ('Ice cream ramen', 'Ramen');

insert into MadeOf values ('Ice cream ramen', 'Ice cream');

insert into MadeOf values ('Beef smoothie', 'Beef Patty');

insert into MadeOf values ('Deep fried protein powder', 'Protein');
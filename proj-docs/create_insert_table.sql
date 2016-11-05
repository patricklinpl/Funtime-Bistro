DROP TABLE MadeOf;
DROP TABLE Contains;
DROP TABLE Ingredient;
DROP TABLE Menuitem;
DROP TABLE Invoice;
DROP TABLE Orders;
DROP TABLE Chef;
DROP TABLE Users;

CREATE TABLE Users
	(userName VARCHAR(20),
	type VARCHAR(8) NOT NULL,
	password VARCHAR(20) NOT NULL,
	name VARCHAR(40) NOT NULL,
	phone CHAR(10) NULL,
	address VARCHAR(40) NULL,
	createDate DATE NOT NULL,
	u_deleted CHAR(1) NOT NULL,
	PRIMARY KEY (userName));

CREATE TABLE Chef
	(chef_userName VARCHAR(20),
	admin_userName VARCHAR(20) NOT NULL,
	employee_id INT NOT NULL,	
	ssNum NUMBER(9) NULL,
	PRIMARY KEY (chef_userName),
	FOREIGN KEY (chef_userName) REFERENCES Users(userName) 
	ON DELETE CASCADE,
	FOREIGN KEY (admin_userName) REFERENCES Users(userName)); 

CREATE TABLE Orders
	(order_id INT,
	customer_userName VARCHAR(20) NOT NULL,
	chef_userName VARCHAR(20) NOT NULL,
	orderdate DATE NOT NULL,
	cookeddate DATE NULL, 
	status VARCHAR(20) NOT NULL,
	PRIMARY KEY (order_id),
	FOREIGN KEY (chef_userName) REFERENCES Chef(chef_userName), 
	FOREIGN KEY (customer_userName) REFERENCES Users(userName));

CREATE TABLE Invoice
	(order_id INT NOT NULL,
	customer_userName VARCHAR(20) NOT NULL,
	cost DECIMAL(5, 2) NOT NULL,
	createdate DATE NULL,
	paymentType VARCHAR(20) NULL,
	PRIMARY KEY (order_id),
	FOREIGN KEY (order_id) REFERENCES Orders ON DELETE CASCADE,
	FOREIGN KEY (customer_userName) REFERENCES Users(userName) ON DELETE CASCADE);

CREATE TABLE Menuitem
	(name VARCHAR(80),
	price DECIMAL(5, 2) NOT NULL,
	imagepath VARCHAR(300) NULL,
	description VARCHAR(300) NULL,
	m_deleted CHAR(1) NOT NULL,
	PRIMARY KEY (name));

CREATE TABLE Ingredient
	(name VARCHAR(20),
	qty INT NOT NULL,
	i_deleted CHAR(1) NOT NULL,
	PRIMARY KEY(name));

CREATE TABLE Contains
	(order_id INT NOT NULL,
	name VARCHAR(80) NOT NULL,
	qty INT NOT NULL,
	PRIMARY KEY (order_id, name),
	FOREIGN KEY (order_id) REFERENCES Orders ON DELETE CASCADE,
	FOREIGN KEY (name) REFERENCES Menuitem 
	ON DELETE CASCADE);

CREATE TABLE MadeOf
	(menuItem_name VARCHAR(80) NOT NULL,
	ingredient_name VARCHAR(80) NOT NULL,
	PRIMARY KEY (menuItem_name, ingredient_name),
	FOREIGN KEY (ingredient_name) REFERENCES Ingredient(name)
	ON DELETE CASCADE,
	FOREIGN KEY (menuItem_name) REFERENCES Menuitem(name) 
	ON DELETE CASCADE);


insert into Users values
('omgitzme', 'admin', 'hihi', 'Harry Zhi', '6042312412', 
'6223 Bateman St.', TO_DATE ('01/01/1961', 'mm/dd/yyyy'), 'F');

insert into Users values
('Wewic', 'admin', 'password', 'Eric Wu', '6041232040', 
'604 Vancouver Ave.', TO_DATE ('04/18/1995', 'mm/dd/yyyy'), 'F');

insert into Users values
('ptlin', 'admin', 'greetings', 'Patrick Lin', '6041235235', 
'6224 Bateman St.', TO_DATE ('01/01/1961', 'mm/dd/yyyy'), 'F');

insert into Users values
('quanbao', 'admin', 'ptran', 'Paul Tran', '6041252341', 
'6225 Bateman St.', TO_DATE ('01/02/1961', 'mm/dd/yyyy'), 'F');

insert into Users values
('newuser', 'customer', 'random', 'John Smith', '8329103291', 
'1513 Las Vegas St.', TO_DATE ('11/01/2016', 'mm/dd/yyyy'), 'F');

insert into Users values
('chef1', 'chef', 'cooking', 'Rordon Gamsey', '8329192919', 
'1514 Las Vegas St.', TO_DATE ('11/01/2016', 'mm/dd/yyyy'), 'F');

insert into Chef values
('chef1', 'omgitzme', 100000, 234213205);

insert into Orders values
(1, 'newuser', 'chef1', TO_DATE ('11/01/2016', 'mm/dd/yyyy'), 
NULL, 'processing');

insert into Orders values
(2, 'newuser', 'chef1', TO_DATE ('11/02/2016', 'mm/dd/yyyy'), 
NULL, 'processing');

insert into Invoice values
(1, 'newuser', 34.50, TO_DATE ('11/01/2016', 'mm/dd/yyyy'), 'credit');

insert into Invoice values
(2, 'newuser', 125.23, TO_DATE ('11/02/2016', 'mm/dd/yyyy'), 'cash');

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
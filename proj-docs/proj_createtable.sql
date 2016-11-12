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
	employee_id INT AUTO_INCREMENT,	
	ssNum INT(9) NULL,
	UNIQUE (employee_id),
	UNIQUE (ssNum),
	PRIMARY KEY (chef_userName),
	FOREIGN KEY (chef_userName) REFERENCES Users(userName) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (admin_userName) REFERENCES Users(userName) ON UPDATE CASCADE); 

CREATE TABLE Orders
	(order_id INT AUTO_INCREMENT,
	customer_userName VARCHAR(20) NOT NULL,
	chef_userName VARCHAR(20),
	orderdate DATE NOT NULL,
	cookeddate DATE NULL, 
	paymentStatus VARCHAR(20) NOT NULL,
    cookedStatus VARCHAR(20) NOT NULL,
	PRIMARY KEY (order_id),
	FOREIGN KEY (chef_userName) REFERENCES Chef(chef_userName) ON DELETE SET NULL ON UPDATE CASCADE, 
	FOREIGN KEY (customer_userName) REFERENCES Users(userName) ON UPDATE CASCADE);

CREATE TABLE Invoice
	(order_id INT NOT NULL,
	customer_userName VARCHAR(20) NOT NULL,
	cost DECIMAL(5, 2) NOT NULL,
	createdate DATE NULL,
	paymentType VARCHAR(20) NULL,
	PRIMARY KEY (order_id),
	FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON UPDATE CASCADE,
	FOREIGN KEY (customer_userName) REFERENCES Users(userName) ON UPDATE CASCADE);

CREATE TABLE Menuitem
	(menu_id INT AUTO_INCREMENT,
	name VARCHAR(80),
	price DECIMAL(5, 2) NOT NULL,
	category VARCHAR(30) NOT NULL,
	description VARCHAR(300) NULL,
	quantity INT NOT NULL,
	m_deleted CHAR(1) NOT NULL,
	UNIQUE (menu_id),
	PRIMARY KEY (name));

CREATE TABLE Ingredient
	(ing_id INT AUTO_INCREMENT,
	name VARCHAR(20),
	type VARCHAR(30) NOT NULL,
	i_deleted CHAR(1) NOT NULL,
	UNIQUE (ing_id),
	PRIMARY KEY(name));

CREATE TABLE Contains
	(order_id INT NOT NULL,
	name VARCHAR(80) NOT NULL,
	qty INT NOT NULL,
	PRIMARY KEY (order_id, name),
	FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON UPDATE CASCADE,
	FOREIGN KEY (name) REFERENCES Menuitem(name) ON UPDATE CASCADE);

CREATE TABLE MadeOf
	(menuItem_name VARCHAR(80) NOT NULL,
	ingredient_name VARCHAR(80) NOT NULL,
	PRIMARY KEY (menuItem_name, ingredient_name),
	FOREIGN KEY (ingredient_name) REFERENCES Ingredient(name) ON UPDATE CASCADE,
	FOREIGN KEY (menuItem_name) REFERENCES Menuitem(name) ON UPDATE CASCADE);
	
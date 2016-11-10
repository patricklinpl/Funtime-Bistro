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
	ssNum INT(9) NULL,
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
	FOREIGN KEY (order_id) 
		REFERENCES Orders(order_id) 
		ON DELETE CASCADE,
	FOREIGN KEY (customer_userName) 
		REFERENCES Users(userName) 
		ON DELETE CASCADE);

CREATE TABLE Menuitem
	(name VARCHAR(80),
	price DECIMAL(5, 2) NOT NULL,
	imagepath VARCHAR(300) NULL,
	description VARCHAR(300) NULL,
	qty INT NOT NULL,
	m_deleted CHAR(1) NOT NULL,
	PRIMARY KEY (name));

CREATE TABLE Ingredient
	(name VARCHAR(20),
	i_deleted CHAR(1) NOT NULL,
	PRIMARY KEY(name));

CREATE TABLE Contains
	(order_id INT NOT NULL,
	name VARCHAR(80) NOT NULL,
	qty INT NOT NULL,
	PRIMARY KEY (order_id, name),
	FOREIGN KEY (order_id) 
		REFERENCES Orders(order_id) 
		ON DELETE CASCADE,
	FOREIGN KEY (name) 
		REFERENCES Menuitem(name)
		ON DELETE CASCADE);

CREATE TABLE MadeOf
	(menuItem_name VARCHAR(80) NOT NULL,
	ingredient_name VARCHAR(80) NOT NULL,
	PRIMARY KEY (menuItem_name, ingredient_name),
	FOREIGN KEY (ingredient_name) REFERENCES Ingredient(name)
	ON DELETE CASCADE,
	FOREIGN KEY (menuItem_name) REFERENCES Menuitem(name) 
	ON DELETE CASCADE);


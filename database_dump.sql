/*
You will need to create a DB named pizza_restaurant
create a user named pizza_user
with a password of pizza

this database still needs to have the menu items uploaded,
which I'll create another dump for that

You should be able to copy and paste all of the sql in one swing to start your database
*/

/*
John Doe Manager
username: manager
password: manager

Jane Doe Customer
username: customer
password: customer

Passwords are hashed using PHP's built in hashing function with no changes
*/

CREATE TABLE `user` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255),
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password` varchar(255) COMMENT 'must be encrypted',
  `employee` boolean NOT NULL DEFAULT false,
  `created_at` timestamp
);

CREATE TABLE `address` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `customer_id` integer,
  `line1` varchar(255) NOT NULL,
  `line2` varchar(255),
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zipcode` integer(5) NOT NULL,
  `created_at` timestamp
);

CREATE TABLE `address_type` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `address_id` integer,
  `billingAddress` boolean,
  `shippingAddress` boolean
);

CREATE TABLE `order` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `customer_id` integer,
  `fulfilled` boolean DEFAULT false,
  `created_at` timestamp,
  `order_total` float,
  `session_id` varchar(255) COMMENT 'for guest checkout'
);

CREATE TABLE `order_item` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `order_id` bigint,
  `item_id` integer,
  `quantity` integer NOT NULL DEFAULT 1
);

CREATE TABLE `order_topping` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `topping_id` integer,
  `order_id` integer,
  `orderitem_id` integer
);

CREATE TABLE `item` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `item_description` varchar(255),
  `item_price` float NOT NULL,
  `category_id` integer NOT NULL
);

CREATE TABLE `category` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `display_order` integer UNIQUE NOT NULL,
  `display_boolean` boolean NOT NULL DEFAULT true
);

CREATE TABLE `topping` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `topping_name` varchar(255) NOT NULL,
  `premium_topping` boolean DEFAULT false
);

ALTER TABLE `address` ADD FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`);

ALTER TABLE `address_type` ADD FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);

ALTER TABLE `order` ADD FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`);

ALTER TABLE `item` ADD FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

ALTER TABLE `order_item` ADD FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE;

INSERT INTO `category` (`id`, `category_name`, `display_order`, `display_boolean`) VALUES ('1', 'appetizers', '1', '1');
INSERT INTO `category` (`id`, `category_name`, `display_order`, `display_boolean`) VALUES ('2', 'pizzas', '2', '1');
INSERT INTO `category` (`id`, `category_name`, `display_order`, `display_boolean`) VALUES ('3', 'kid\'s meals', '4', '1');
INSERT INTO `category` (`id`, `category_name`, `display_order`, `display_boolean`) VALUES ('4', 'combos', '3', '1');
INSERT INTO `category` (`id`, `category_name`, `display_order`, `display_boolean`) VALUES ('5', 'drinks', '5', '1');

INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `password`, `employee`, `created_at`) VALUES ('1', 'manager', 'John', 'Doe', '$2y$10$UlG7JQHcdDlN5cuYg078C.Z4SnkJZB7Dc8IiXUEXlif7WS1jPBWKu', '1', current_timestamp());
INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `password`, `employee`, `created_at`) VALUES ('2', 'customer', 'Jane', 'Doe', '$2y$10$jgcBqUTA8arxnqFrSMpN1.edTL4ShD/uA1X0RnuXiKYxwy3EUki2W', '0', current_timestamp());
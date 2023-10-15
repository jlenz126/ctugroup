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
  `quantity` integer NOT NULL DEFAULT 1,
  `created_at` timestamp
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

/* Added toppings, appetizers, pizzas, combos, and drinks*/

INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('1', 'pepperoni', '0');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('2', 'sausage', '0');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('3', 'bacon', '1');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('4', 'italian sausage', '1');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('5', 'chicken', '1');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('6', 'onion', '0');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('7', 'spinach', '0');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('8', 'green bell peppers', '0');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('9', 'mozzarella cheese', '0');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('10', 'parmesan cheese', '0');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('11', 'cheddar cheese', '0');
INSERT INTO `topping` (`id`, `topping_name`, `premium_topping`) VALUES ('12', 'olives', '0');

INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('1', 'cheesy breadsticks', NULL, '8.00', '1');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('2', 'fries', NULL, '5.00', '1');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('3', 'chips and dip', NULL, '3.00', '1');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('4', 'fired pickles', NULL, '6.00', '1');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('5', 'mac n\' cheese', NULL, '6.00', '1');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('6', 'salad', NULL, '5.00', '1');

INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('7', 'kid\'s meal 1', '1 slice of pepperoni or OG pizza and a drink', '6.00', '3');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('8', 'kid\'s meal 2', 'Mac n\' Cheese and a drink', '6.00', '3');

INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('9', 'cheese pizza', 'plain cheese pizza', '10.00', '2');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('10', 'pepperoni pizza', 'pizza with pepperoni', '11.00', '2');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('11', 'Meatzilla', 'Pepperoni, sausage, and bacon', '13.50', '2');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('12', 'Veggie Pizza', 'Onion, spinach, olives, and green bell peppers', '14.00', '2');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('13', 'the godfather', 'Italian sausage, pepperoni, onion, olives, and spinach', '15.50', '2');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('14', 'queen bee', 'Chicken, bacon, and spinach', '14.00', '2');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('15', 'The OG', 'Mozzarella, parmesan, and cheddar cheese', '13.00', '2');

INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('16', 'combo 1', '1 slice of pizza and 1 small drink', '6.00', '4');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('17', 'combo 2', '1 small pizza and 1 large drink, and 1 appetizer', '15.00', '4');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('18', 'combo 3', '1 medium pizza and 1 large drink, and 1 appetizer', '18.00', '4');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('19', 'combo 4', '1 large pizza and 2 large drinks, and 2 appetizer', '25.00', '4');

INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('20', 'coke', NULL, '2.00', '5');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('21', 'pepsi', NULL, '2.00', '5');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('22', 'Dr. Pepper', NULL, '2.00', '5');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('23', 'Mt. Dew', NULL, '2.00', '5');
INSERT INTO `item` (`id`, `item_name`, `item_description`, `item_price`, `category_id`) VALUES ('24', 'Lemonade', NULL, '2.00', '5');

/* Adding column to item table to store default toppings*/

ALTER TABLE item add default_topping varchar(255);
UPDATE `item` SET `default_topping` = 'pepperoni' WHERE `item`.`id` = 10;
UPDATE `item` SET `default_topping` = 'pepperoni,sausage,bacon' WHERE `item`.`id` = 11;
UPDATE `item` SET `default_topping` = 'onion,spinach,olives,green bell peppers' WHERE `item`.`id` = 12;
UPDATE `item` SET `default_topping` = 'italian sausage,pepperoni,onion,olives,spinach' WHERE `item`.`id` = 13;
UPDATE `item` SET `default_topping` = 'chicken,bacon,spinach' WHERE `item`.`id` = 14;
UPDATE `item` SET `default_topping` = 'mozzarella,parmesan,cheddar cheese' WHERE `item`.`id` = 15;
UPDATE `item` SET `item_description` = '1 slice of cheese pizza and a drink' WHERE `item`.`id` = 7;

/* Created test order cart id=1 session_id=123 no customer_id*/

INSERT INTO `order` (`id`, `customer_id`, `fulfilled`, `created_at`, `order_total`, `session_id`) VALUES ('1', NULL, '0', current_timestamp(), NULL, '123');

/* added drink type and size to order_item table */

ALTER TABLE `order_item` ADD `drink_size` VARCHAR(255) NULL DEFAULT NULL AFTER `quantity`, ADD `drink_type` VARCHAR(255) NULL DEFAULT NULL AFTER `drink_size`;
UPDATE `item` SET `default_topping` = 'mozzarella cheese,parmesan cheese,cheddar cheese' WHERE `item`.`id` = 15;
ALTER TABLE `order_item` ADD `pizza_type` VARCHAR(255) NULL DEFAULT NULL AFTER `drink_type`;
ALTER TABLE `order_item` ADD `appetizer_type` VARCHAR(255) NULL DEFAULT NULL AFTER `pizza_type`;
ALTER TABLE `order_item` ADD `item_price` FLOAT NOT NULL AFTER `quantity`;
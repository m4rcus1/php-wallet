SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `Onlinebanking` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
use  `Onlinebanking`;

create table Account
(
    Phonenumber varchar(10),
    Email varchar(100),
	Fullname nvarchar(255),
	Pass varchar(255),
	Dateofbirth datetime,
    Diachi nvarchar(20),
    FP varchar(50),
    PP varchar(50),
    sts int
);
create table Money_card
(
    Cardnumber varchar(10),
    Phonenumber varchar(10),
    surplus int,
    cvv int,
    date_at_exp date
);
create table Wallet
(
    Phonenumber varchar(10),
    W_surplus int
);
create table transaction_history(
    Phonenumber varchar(10),
    type_of_transaction varchar(50),
    money_of_transaction int,
    date_transaction date,
    note varchar(100)
);
create table wait_accept_transaction(
    
    id int,
    type_of_transaction varchar(50),
    source varchar(50),
    vertex varchar(50),
    money_of_transaction int,
    date_transaction date,
    note varchar(100)
)
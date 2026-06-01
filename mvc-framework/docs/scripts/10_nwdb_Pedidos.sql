-- Active: 1780259884966@@127.0.0.1@3306@nwdb
CREATE TABLE `orders` (
    `orderId` int(11) NOT NULL AUTO_INCREMENT,
    `customerName` varchar(100) NOT NULL,
    `customerPhone` varchar(20) NOT NULL,
    `customerAddress` varchar(255) NOT NULL,
    `orderDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `orderStatus` char(3) NOT NULL DEFAULT 'PEN',
    PRIMARY KEY (`orderId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orderdetails` (
    `detailId` int(11) NOT NULL AUTO_INCREMENT,
    `orderId` int(11) NOT NULL,
    `productId` int(11) NOT NULL,
    `quantity` int(11) NOT NULL,
    `unitPrice` decimal(10,2) NOT NULL,

    PRIMARY KEY (`detailId`),

    KEY `fk_orderdetails_orders_idx` (`orderId`),
    KEY `fk_orderdetails_products_idx` (`productId`),

    CONSTRAINT `fk_orderdetails_orders`
        FOREIGN KEY (`orderId`)
        REFERENCES `orders` (`orderId`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT `fk_orderdetails_products`
        FOREIGN KEY (`productId`)
        REFERENCES `products` (`productId`)
        ON DELETE CASCADE
        ON UPDATE CASCADE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orderstatuslog` (
    `logId` int(11) NOT NULL AUTO_INCREMENT,
    `orderId` int(11) NOT NULL,
    `oldStatus` char(3) NOT NULL,
    `newStatus` char(3) NOT NULL,
    `changeDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`logId`),

    KEY `fk_orderstatuslog_orders_idx` (`orderId`),

    CONSTRAINT `fk_orderstatuslog_orders`
        FOREIGN KEY (`orderId`)
        REFERENCES `orders` (`orderId`)
        ON DELETE CASCADE
        ON UPDATE CASCADE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
-- -- 用户表
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `password` (`password`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--产品表
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` INT(11) NOT NULL REFERENCES category(`id`),
  `productName` VARCHAR(255) DEFAULT NULL,
  `productModel` VARCHAR(255) DEFAULT NULL,
  `productUnit` VARCHAR(255) DEFAULT NULL,
  `productPrice` VARCHAR(255) DEFAULT NULL,
  `productIntroduce` VARCHAR(255) DEFAULT NULL,
  `productSize` VARCHAR(255) DEFAULT NULL,
  `productDes` VARCHAR(255) DEFAULT NULL,
  `productPic` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--产品分类表
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(11) NOT NULL,
  `categoryName` varchar(255) DEFAULT NULL,
  `state` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--收藏表
CREATE TABLE IF NOT EXISTS `collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL REFERENCES user(`id`),
  `pid` int(11) NOT NULL REFERENCES product(`id`),
  `createTime` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

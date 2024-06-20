CREATE TABLE
  `clients` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `nomeFantasia` varchar(100) DEFAULT NULL,
    `razaoSocial` varchar(100) DEFAULT NULL,
    `cpf` varchar(100) DEFAULT NULL,
    `cidade` varchar(100) DEFAULT NULL,
    `data_cadastro` datetime DEFAULT current_timestamp(),
    `data_deleted` date DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci

CREATE TABLE
  `products` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `codigo` varchar(100) DEFAULT NULL,
    `descricao` varchar(100) DEFAULT NULL,
    `valor` varchar(100) DEFAULT NULL,
    `fornecedor` varchar(100) DEFAULT NULL,
    `data_cadastro` datetime DEFAULT current_timestamp(),
    `data_deleted` date DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci


CREATE TABLE
  `sales` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `cliente` varchar(255) DEFAULT NULL,
    `tipoPagamento` varchar(100) DEFAULT NULL,
    `valorIntegral` varchar(100) DEFAULT NULL,
    `vendedor` varchar(100) DEFAULT NULL,
    `produto` varchar(100) DEFAULT NULL,
    `quantidade` varchar(100) DEFAULT NULL,
    `valorUnitario` varchar(255) DEFAULT NULL,
    `data_cadastro` datetime DEFAULT current_timestamp(),
    `data_deleted` date DEFAULT NULL,
    `id_venda` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci


  CREATE TABLE 
  `payments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `numero` INT NOT NULL,
    `valorParcela` DECIMAL(10, 2) NOT NULL,
    `dataVencimento` DATE NOT NULL
  );

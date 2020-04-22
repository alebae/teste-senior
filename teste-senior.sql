CREATE TABLE `teste_senior`.`produto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo` INT ZEROFILL NOT NULL,
  `descricao` VARCHAR(255) NULL,
  `preco` DECIMAL(10,2) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC) VISIBLE);


CREATE TABLE `teste_senior`.`documento` (
  `numero` INT NOT NULL AUTO_INCREMENT,
  `total` DECIMAL(10,2) NULL,
  `confirmado` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`numero`));

CREATE TABLE `teste_senior`.`item` (
  `idProduto` INT NULL,
  `idDocumento` INT NULL,
  INDEX `FK_PRODUTO_idx` (`idProduto` ASC) VISIBLE,
  INDEX `FK_DOCUMENTO_idx` (`idDocumento` ASC) VISIBLE,
  CONSTRAINT `FK_PRODUTO`
    FOREIGN KEY (`idProduto`)
    REFERENCES `teste_senior`.`produto` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_DOCUMENTO`
    FOREIGN KEY (`idDocumento`)
    REFERENCES `teste_senior`.`documento` (`numero`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

ALTER TABLE `teste_senior`.`documento` 
ADD INDEX `key_confirmado` (`confirmado` ASC) VISIBLE;
;
ALTER TABLE `teste_senior`.`produto` 
CHANGE COLUMN `codigo` `codigo` INT(10) UNSIGNED NOT NULL ;



DELIMITER $$

USE `teste_senior`$$

DROP PROCEDURE IF EXISTS `procTotalVenda`$$

CREATE PROCEDURE `procTotalVenda`(IN doc INTEGER)
BEGIN
   select sum(p.preco) as totalVenda from produto p, documento d, item i
	where p.id = i.idProduto
	and d.numero = i.idDocumento
	and i.idDocumento = doc;
END$$

DELIMITER ;

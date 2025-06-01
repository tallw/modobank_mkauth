-- phpMiniAdmin dump 1.9.170730
-- Datetime: 2024-08-08 15:55:28
-- Host: 
-- Database: mkradius

/*!40030 SET NAMES utf8 */;
/*!40030 SET GLOBAL max_allowed_packet=16777216 */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

DROP TABLE IF EXISTS `pix_info2`;
CREATE TABLE `pix_info2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `txid` varchar(35) NOT NULL,
  `qrcode` text NOT NULL,
  `pix_copia_cola` text NOT NULL,
  `data_criacao` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `id_lanc` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_id_cliente` (`id_cliente`),
  KEY `idx_id_lanc` (`id_lanc`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `pix_info2` DISABLE KEYS */;
INSERT INTO `pix_info2` VALUES ('1','1','6tlj228oxtiypte3odtdb180468jp7elqp','img/6tlj228oxtiypte3odtdb180468jp7elqp.png','00020126990014br.gov.bcb.pix2577qrcodes-h.sulcredi.coop.br/v2/v3/at/cobv/85f793cb-23d7-4d6e-bbb7-39b652fd42105204000053039865802BR5911TPR_TELECOM6014SAO_MIGUEL_DO_62070503***6304B7ED','2024-08-08 12:30:23','ATIVA','1'),('2','1','3qsfe25a9xblmm7ifjrqttsk49tf04culvz','img/3qsfe25a9xblmm7ifjrqttsk49tf04culvz.png','00020126990014br.gov.bcb.pix2577qrcodes-h.sulcredi.coop.br/v2/v3/at/cobv/a48d39d2-f657-40a4-a668-2b3b46ed86995204000053039865802BR5911TPR_TELECOM6014SAO_MIGUEL_DO_62070503***630495E2','2024-08-08 12:30:23','ATIVA','2'),('3','1','nvqmjryv4v3a5kqo48zz8i4yd7ios8','img/nvqmjryv4v3a5kqo48zz8i4yd7ios8.png','00020126990014br.gov.bcb.pix2577qrcodes-h.sulcredi.coop.br/v2/v3/at/cobv/27298f10-781f-488a-a998-3f558ffded835204000053039865802BR5911TPR_TELECOM6014SAO_MIGUEL_DO_62070503***63049DBA','2024-08-08 12:30:23','ATIVA','3');
/*!40000 ALTER TABLE `pix_info2` ENABLE KEYS */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;


-- phpMiniAdmin dump end

-- phpMiniAdmin dump 1.9.170730
-- Datetime: 2024-08-08 15:55:51
-- Host: 
-- Database: mkradius

/*!40030 SET NAMES utf8 */;
/*!40030 SET GLOBAL max_allowed_packet=16777216 */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

DROP TABLE IF EXISTS `webhook_logs`;
CREATE TABLE `webhook_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payload` text DEFAULT NULL,
  `txid` varchar(255) DEFAULT NULL,
  `valor` varchar(255) DEFAULT NULL,
  `horario` datetime DEFAULT NULL,
  `pagador_cpf_cnpj` varchar(255) DEFAULT NULL,
  `pagador_nome` varchar(255) DEFAULT NULL,
  `end_to_end_id` varchar(255) DEFAULT NULL,
  `recebido_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `webhook_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `webhook_logs` ENABLE KEYS */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;


-- phpMiniAdmin dump end

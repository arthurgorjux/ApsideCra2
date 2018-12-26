
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- type
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `type`;

CREATE TABLE `type`
(
    `id` VARCHAR(255) NOT NULL,
    `designation` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- utilisateur
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `utilisateur`;

CREATE TABLE `utilisateur`
(
    `matricule` INTEGER NOT NULL,
    `nom` VARCHAR(255),
    `prenom` VARCHAR(255),
    `admin` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`matricule`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cellule
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cellule`;

CREATE TABLE `cellule`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `designation` VARCHAR(255) NOT NULL,
    `type` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `cellule_fi_1b4e73` (`type`),
    CONSTRAINT `cellule_fk_1b4e73`
        FOREIGN KEY (`type`)
        REFERENCES `type` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- etat_incident
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `etat_incident`;

CREATE TABLE `etat_incident`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `designation` VARCHAR(255) NOT NULL,
    `abreviation` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- etat_demande
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `etat_demande`;

CREATE TABLE `etat_demande`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `designation` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- incident
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `incident`;

CREATE TABLE `incident`
(
    `id` VARCHAR(255) NOT NULL,
    `cellule` INTEGER,
    `etat` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `incident_fi_ae23a4` (`cellule`),
    INDEX `incident_fi_0ef3a2` (`etat`),
    CONSTRAINT `incident_fk_ae23a4`
        FOREIGN KEY (`cellule`)
        REFERENCES `cellule` (`id`),
    CONSTRAINT `incident_fk_0ef3a2`
        FOREIGN KEY (`etat`)
        REFERENCES `etat_incident` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- demande
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `demande`;

CREATE TABLE `demande`
(
    `id` VARCHAR(255) NOT NULL,
    `cellule` INTEGER,
    `etat` INTEGER,
    `date_soumission` DATE,
    `date_maj` DATE,
    `date_livraison` DATE,
    `charge` FLOAT,
    `projet` VARCHAR(255),
    `priorite` TINYINT,
    PRIMARY KEY (`id`),
    INDEX `demande_fi_ae23a4` (`cellule`),
    INDEX `demande_fi_b3abf9` (`etat`),
    CONSTRAINT `demande_fk_ae23a4`
        FOREIGN KEY (`cellule`)
        REFERENCES `cellule` (`id`),
    CONSTRAINT `demande_fk_b3abf9`
        FOREIGN KEY (`etat`)
        REFERENCES `etat_demande` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- suivi
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `suivi`;

CREATE TABLE `suivi`
(
    `id` INTEGER NOT NULL,
    `matricule` INTEGER,
    `temps_passe` FLOAT,
    `cellule` INTEGER,
    `demande` INTEGER,
    `incident` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `suivi_fi_17d3bb` (`matricule`),
    INDEX `suivi_fi_ae23a4` (`cellule`),
    INDEX `suivi_fi_ec8e9b` (`demande`),
    INDEX `suivi_fi_0bc6d2` (`incident`),
    CONSTRAINT `suivi_fk_17d3bb`
        FOREIGN KEY (`matricule`)
        REFERENCES `utilisateur` (`matricule`),
    CONSTRAINT `suivi_fk_ae23a4`
        FOREIGN KEY (`cellule`)
        REFERENCES `cellule` (`id`),
    CONSTRAINT `suivi_fk_ec8e9b`
        FOREIGN KEY (`demande`)
        REFERENCES `demande` (`id`),
    CONSTRAINT `suivi_fk_0bc6d2`
        FOREIGN KEY (`incident`)
        REFERENCES `incident` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

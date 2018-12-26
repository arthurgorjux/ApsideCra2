
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
    `type_c` VARCHAR(255),
    PRIMARY KEY (`id`),
    INDEX `cellule_fi_6563cd` (`type_c`),
    CONSTRAINT `cellule_fk_6563cd`
        FOREIGN KEY (`type_c`)
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
    `cellule_i` INTEGER,
    `etat_i` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `incident_fi_d0a661` (`cellule_i`),
    INDEX `incident_fi_9f4d89` (`etat_i`),
    CONSTRAINT `incident_fk_d0a661`
        FOREIGN KEY (`cellule_i`)
        REFERENCES `cellule` (`id`),
    CONSTRAINT `incident_fk_9f4d89`
        FOREIGN KEY (`etat_i`)
        REFERENCES `etat_incident` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- demande
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `demande`;

CREATE TABLE `demande`
(
    `id` VARCHAR(255) NOT NULL,
    `cellule_d` INTEGER,
    `etat_d` INTEGER,
    `date_soumission` DATE,
    `date_maj` DATE,
    `date_livraison` DATE,
    `charge` FLOAT,
    `projet` VARCHAR(255),
    `priorite` TINYINT,
    PRIMARY KEY (`id`),
    INDEX `demande_fi_485b0f` (`cellule_d`),
    INDEX `demande_fi_bb62e9` (`etat_d`),
    CONSTRAINT `demande_fk_485b0f`
        FOREIGN KEY (`cellule_d`)
        REFERENCES `cellule` (`id`),
    CONSTRAINT `demande_fk_bb62e9`
        FOREIGN KEY (`etat_d`)
        REFERENCES `etat_demande` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- suivi
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `suivi`;

CREATE TABLE `suivi`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `matricule_s` INTEGER,
    `temps_passe` FLOAT,
    `cellule_s` INTEGER,
    `demande_s` VARCHAR(255),
    `incident_s` VARCHAR(255),
    PRIMARY KEY (`id`),
    INDEX `suivi_fi_799716` (`matricule_s`),
    INDEX `suivi_fi_6f3e1f` (`cellule_s`),
    INDEX `suivi_fi_841f8a` (`demande_s`),
    INDEX `suivi_fi_77892d` (`incident_s`),
    CONSTRAINT `suivi_fk_799716`
        FOREIGN KEY (`matricule_s`)
        REFERENCES `utilisateur` (`matricule`),
    CONSTRAINT `suivi_fk_6f3e1f`
        FOREIGN KEY (`cellule_s`)
        REFERENCES `cellule` (`id`),
    CONSTRAINT `suivi_fk_841f8a`
        FOREIGN KEY (`demande_s`)
        REFERENCES `demande` (`id`),
    CONSTRAINT `suivi_fk_77892d`
        FOREIGN KEY (`incident_s`)
        REFERENCES `incident` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

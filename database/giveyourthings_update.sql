
DROP TABLE IF EXISTS `ads`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `users`;


CREATE TABLE IF NOT EXISTS `users`
(
    `id`         int(11)      NOT NULL AUTO_INCREMENT,
    `uid`        varchar(255) NOT NULL,
    `username`   varchar(255) NOT NULL,
    `firstname`  varchar(255) NOT NULL,
    `lastname`   varchar(255) NOT NULL,
    `email`      varchar(255) NOT NULL,
    `photoUrl`   varchar(255) DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `users` (`uid`, `username`, `firstname`, `lastname`, `email`, `photoUrl`)
VALUES ('fs65sf46ds4fs5dfs5df6', 'napobona', 'Napoléon', 'BONAPARTE', 'napoleonbonaparte@gmail.com', 'https://images.radio-canada.ca/w_635,h_357/v1/ici-premiere/16x9/histo-napoleon-bonaparte-david-peinture.jpg'),
       ('f65qze6f5g4ers65g46d5', 'super menteur', 'Jacques', 'CHIRAC', 'jacques.chirac@gmail.com', 'https://resize-europe1.lanmedia.fr/r/622,311,forcex,center-middle/img/var/europe1/storage/images/europe1/politique/jacques-chirac-itineraire-dune-icone-swag-3921992/53544725-1-fre-FR/Jacques-Chirac-itineraire-d-une-icone-swag.jpg'),
       ('sh6dg45fgs6d5f4gsg6df', 'le ricain', 'Bob', 'Sylvestre', 'americafuckyeah@gmail.com', 'https://pbs.twimg.com/media/DjR68MXXsAAujxh.jpg');

CREATE TABLE IF NOT EXISTS `categories`
(
    `id`         int(11)      NOT NULL AUTO_INCREMENT,
    `label`      varchar(255) NOT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `categories` (`id`, `label`)
VALUES (1, 'Vetements'),
       (2, 'Accessoires de mode'),
       (3, 'Chaussures'),
       (4, 'Livres, films et musique'),
       (5, 'Hygiène & Beauté'),
       (6, 'Cuisine & Maison'),
       (7, 'Meubles'),
       (8, 'Art et déco'),
       (9, 'Art Pour bébé'),
       (10, 'Électroménager'),
       (11, 'Bricolage & Jardin'),
       (12, 'Électronique'),
       (13, 'Jeux & Jouets'),
       (14, 'Sports & Loisirs'),
       (15, 'Le monde des animaux'),
       (16, 'Fournitures de bureau');

CREATE TABLE IF NOT EXISTS `ads`
(
    `id`           int(11)      NOT NULL AUTO_INCREMENT,
    `title`        varchar(255) NOT NULL,
    `description`  varchar(255) NOT NULL,
    `localisation` varchar(255) DEFAULT NULL,
    `type`         varchar(255) NOT NULL,
    `condition`    varchar(255) NOT NULL,
    `user_id`      int(11)      NOT NULL,
    `category_id`  int(11)      NOT NULL,
    `created_at`   datetime     DEFAULT NULL,
    `updated_at`   datetime     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

ALTER TABLE `ads`
    ADD CONSTRAINT `fk_foreign_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    ADD CONSTRAINT `fk_foreign_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

INSERT INTO `ads` (`title`, `description`, `type`, `condition`, `user_id`, `category_id`)
VALUES ('Chaussettes en Mithril', 'Elles brillent dans le noir', 'Don', 'État moyen', 1, 1),
       ('Épée Durandil', 'Meme qu\'elle m\'a couté 10 000 pièces d\'or !!', 'Don', 'Comme neuf', 1, 13),
       ('Polochon mystique de Zuggira', 'L’histoire étrange d’une arme moelleuse', 'Don', 'À Bricoler', 2, 6),
       ('Brasero Nécromantique Multifonction', 'Parce que bon, il faut bien décorer chez soi.', 'Don', 'Comme neuf', 2, 6);

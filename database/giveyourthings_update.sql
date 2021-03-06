DROP TABLE IF EXISTS `discussion_replies`;
DROP TABLE IF EXISTS `discussions`;
DROP TABLE IF EXISTS `ads`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `conditions`;
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
    `created_at` datetime     DEFAULT NULL,
    `updated_at` datetime     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `users` (`uid`, `username`, `firstname`, `lastname`, `email`, `photoUrl`, `created_at`, `updated_at`)
VALUES ('117740440099072643116', 'Guillaume H', 'Guillaume', 'H', 'guillaumehanotel37@gmail.com',
        'https://lh3.googleusercontent.com/a-/AAuE7mCTd-IU_YJi0DFLuKKrQYwBkozgN1k3UkGazHoRzQ', NOW(), NOW()),
       ('112423483758891914989', 'Cassiopeia Incurvée', 'Cassiopeia', 'Incurvée', 'etoilegale@gmail.com',
        'https://lh3.googleusercontent.com/a-/AAuE7mC5_iz_OXRa7MDZDnu2ySy-STNmomrCLoDxW3Cv', NOW(), NOW()),
       ('106991751138921408306', 'Alexandre Abruzzese', 'Alexandre', 'Abruzzese', 'alex.abruzzese96@gmail.com',
        'https://lh3.googleusercontent.com/a-/AAuE7mD3H8Us9vhDr8OtVu6hvPwS1VTXIZTeDcc636O0Tg', NOW(), NOW());

CREATE TABLE IF NOT EXISTS `categories`
(
    `id`         int(11)      NOT NULL AUTO_INCREMENT,
    `label`      varchar(255) NOT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `categories` (`id`, `label`, `created_at`, `updated_at`)
VALUES (1, 'Vetements', NOW(), NOW()),
       (2, 'Accessoires de mode', NOW(), NOW()),
       (3, 'Chaussures', NOW(), NOW()),
       (4, 'Livres, films et musique', NOW(), NOW()),
       (5, 'Hygiène & Beauté', NOW(), NOW()),
       (6, 'Cuisine & Maison', NOW(), NOW()),
       (7, 'Meubles', NOW(), NOW()),
       (8, 'Art et déco', NOW(), NOW()),
       (9, 'Art Pour bébé', NOW(), NOW()),
       (10, 'Électroménager', NOW(), NOW()),
       (11, 'Bricolage & Jardin', NOW(), NOW()),
       (12, 'Électronique', NOW(), NOW()),
       (13, 'Jeux & Jouets', NOW(), NOW()),
       (14, 'Sports & Loisirs', NOW(), NOW()),
       (15, 'Le monde des animaux', NOW(), NOW()),
       (16, 'Fournitures de bureau', NOW(), NOW());

CREATE TABLE IF NOT EXISTS `conditions`
(
    `id`         int(11)      NOT NULL AUTO_INCREMENT,
    `label`      varchar(255) NOT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `conditions` (`id`, `label`, `created_at`, `updated_at`)
VALUES (1, 'Comme neuf', NOW(), NOW()),
       (2, 'État moyen', NOW(), NOW()),
       (3, 'À bricoler', NOW(), NOW());

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
    `booker_id`    int(11)      NULL,
    `is_given`     boolean      DEFAULT false,
    `latitude`     varchar(255) NULL,
    `longitude`    varchar(255) NULL,
    `image_url`    varchar(255) NULL,
    `created_at`   datetime     DEFAULT NULL,
    `updated_at`   datetime     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

ALTER TABLE `ads`
    ADD CONSTRAINT `fk_foreign_ads_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    ADD CONSTRAINT `fk_foreign_ads_booker_id` FOREIGN KEY (`booker_id`) REFERENCES `users` (`id`),
    ADD CONSTRAINT `fk_foreign_ads_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

INSERT INTO `ads` (`id`, `title`, `description`, `type`, `condition`, `user_id`, `category_id`, `booker_id`, `is_given`, `latitude`, `longitude`, `created_at`, `updated_at`, `image_url`)
VALUES (1, 'Vélo rouge', 'Lorem Ipsum...', 'Don', 'État moyen', 1, 1, 2, false, '44.8333', '-0.5667', NOW(), NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573195631/redbike_v1ukgs.jpg'),
       (2, 'Canapé en cuir', 'Lorem Ipsum...', 'Don', 'Comme neuf', 1, 13, null, false, '44.8233', '-0.5767', NOW(),NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573195688/canap_flldag.jpg'),
       (3, 'Table basse', 'Lorem Ipsum...', 'Don', 'À Bricoler', 2, 6, 1, false, '44.8433', '-0.5867', NOW(), NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573195727/WB159156300_1_zp9huw.jpg'),
       (4, 'Sac à main', 'Lorem Ipsum...', 'Don', 'Comme neuf', 3, 5, null, false, '44.8533', '-0.5*67', NOW(), NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196088/WB161947010_1_bok6jk.jpg'),
       (5, 'Tshirt enfant', 'Lorem Ipsum...', 'Don', 'État moyen', 2, 7, 3, false, '44.8633', '-0.6067', NOW(), NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196087/24383e89227813ad4d86014a5017b810_qdawvi.jpg'),
       (6, 'Iphone 3', 'Lorem Ipsum...', 'Don', 'À Bricoler', 1, 6, null, false, '44.8733', '-0.6167', NOW(), NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196088/WB153109754_1_h7hdlg.jpg'),
       (7, 'Lit 2 places', 'Lorem Ipsum...', 'Don', 'Comme neuf', 2, 6, null, false, '44.8833', '-0.6267', NOW(),NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196087/bed_dymoi1.jpg'),
       (8, 'Chassures', '      Lorem Ipsum...', 'Don', 'État moyen', 3, 13, null, false, '44.8033', '-0.6367', NOW(),NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196087/choose_t0cmzs.jpg'),
       (9, 'Pneus neige', 'Lorem Ipsum...', 'Don', 'Comme neuf', 1, 15, 3, false, '44.8133', '-0.6467', NOW(), NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196087/lot-4-pneus-neige-michelin-265-45r21-1_800x430_ixxprn.jpg'),
       (10, 'Meuble de cuisine', 'Lorem Ipsum...', 'Don', 'À Bricoler', 2, 2, null, false, '44.8513', '-0.5567', NOW(),NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196087/WB149494448_1_vyhhtz.jpg'),
       (11, 'Lustre', 'Lorem Ipsum...', 'Don', 'Comme neuf', 3, 3, 1, false, '44.8333', '-0.5467', NOW(), NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196088/WB162314333_1_kcxq2v.jpg'),
       (12, 'Mirroir', 'Lorem Ipsum...', 'Don', 'État moyen', 1, 6, null, false, '44.8333', '-0.5367', NOW(), NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196087/mirroir_kdjoce.jpg'),
       (13, 'Boite de Lego', 'Lorem Ipsum...', 'Don', 'Comme neuf', 2, 5, null, false, '44.8333', '-0.5667', NOW(),NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196088/WB162810147_1_zoiqw5.jpg'),
       (14, 'Fauteuil', 'Lorem Ipsum...', 'Don', 'À Bricoler', 3, 9, 2, false, '44.8333', '-0.5667', NOW(), NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196089/WB161956595_1_fplppg.jpg'),
       (15, 'Draps blancs', 'Lorem Ipsum...', 'Don', 'État moyen', 2, 10, null, false, '44.8333', '-0.5667', NOW(),NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196088/WB160992660_1_cxkifd.jpg'),
       (16, 'Robe', 'Lorem Ipsum...', 'Don', 'Comme neuf', 1, 4, null, false, '44.8333', '-0.5667', NOW(), NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196088/WB158493117_1_ybmelq.jpg'),
       (17, 'Album AC/DC', 'Lorem Ipsum...', 'Don', 'À Bricoler', 2, 16, null, false, '44.8333', '-0.5667', NOW(),NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196088/WB150137154_1_o2zwdv.jpg'),
       (18, 'Tapis de salon', 'Lorem Ipsum...', 'Don', 'Comme neuf', 3, 15, null, false, '44.8333', '-0.5667', NOW(),NOW(), 'https://res.cloudinary.com/dqjfz4lgc/image/upload/v1573196088/WB162394945_1_a8eawn.jpg');


CREATE TABLE IF NOT EXISTS `discussions`
(
    `id`           int(11) NOT NULL AUTO_INCREMENT,
    `ad_id`        int(11) NOT NULL,
    `requester_id` int(11) NOT NULL,
    `created_at`   datetime DEFAULT NULL,
    `updated_at`   datetime DEFAULT NULL,
    primary key (`id`)
);

ALTER TABLE `discussions`
    ADD CONSTRAINT `fk_foreign_discussions_requester_id` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`),
    ADD CONSTRAINT `fk_foreign_discussions_ad_id` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`);


INSERT INTO `discussions` (`id`, `ad_id`, `requester_id`, `created_at`, `updated_at`)
VALUES (1, 1, 2, NOW(), NOW()),
       (2, 3, 1, NOW(), NOW()),
       (3, 5, 3, NOW(), NOW()),
       (4, 9, 3, NOW(), NOW()),
       (5, 11, 1, NOW(), NOW()),
       (6, 14, 2, NOW(), NOW()),
       (7, 2, 2, NOW(), NOW()),
       (8, 12, 3, NOW(), NOW()),
       (9, 4, 2, NOW(), NOW()),
       (10, 15, 1, NOW(), NOW()),
       (11, 15, 3, NOW(), NOW());


CREATE TABLE IF NOT EXISTS `discussion_replies`
(
    `id`            int(11) NOT NULL AUTO_INCREMENT,
    `user_id`       int(11) NOT NULL,
    `discussion_id` int(11) NOT NULL,
    `message`       text    NOT NULL,
    `created_at`    datetime DEFAULT NULL,
    `updated_at`    datetime DEFAULT NULL,
    primary key (`id`)
);

ALTER TABLE `discussion_replies`
    ADD CONSTRAINT `fk_foreign_discussion_replies_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    ADD CONSTRAINT `fk_foreign_discussion_replies_discussion_id` FOREIGN KEY (`discussion_id`) REFERENCES `discussions` (`id`);

INSERT INTO `discussion_replies` (`user_id`, `discussion_id`, `message`, `created_at`)
VALUES (2, 1, 'Je suis intéressé par ton vélo', SUBTIME(NOW(), '02:00:00')),
       (1, 1, 'Bah viens le chercher', SUBTIME(NOW(), '01:00:00')),
       (1, 2, 'Quelle taille la table basse ?', SUBTIME(NOW(), '01:00:00'));
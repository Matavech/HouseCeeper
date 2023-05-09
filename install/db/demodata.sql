INSERT INTO hc_houseceeper_house (ID, NAME, ADDRESS, NUMBER_OF_APARTMENT, UNIQUE_PATH, INFO)
VALUES
    (1,
     'ЖК "Парковый квартал"',
     'ул. Пушкина, д. 5',
     '50',
     'parkovyikvartal',
     'Жилой комплекс "Парковый квартал" расположен на берегу реки, в зеленой зоне города. В доме есть консьерж, подземная парковка, детская площадка и зона отдыха на крыше.'
    ),
    (2,
    'ЖК "Золотой квадрат"',
    'ул. Ленина, д. 10',
    '1',
    'zolotoykvadrat',
    'Жилой комплекс "Золотой квадрат" расположен в центре города, рядом с парком и множеством магазинов. В доме есть охрана, подземная парковка, детская площадка и фитнес-центр.'
    );

INSERT INTO hc_houseceeper_apartment (number, house_id, reg_key)
SELECT n, 1, substring(MD5(RAND()),1,15)
FROM (SELECT 1 n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
      UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
      UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION SELECT 15
      UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION SELECT 20
      UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION SELECT 25
      UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30
      UNION SELECT 31 UNION SELECT 32 UNION SELECT 33 UNION SELECT 34 UNION SELECT 35
      UNION SELECT 36 UNION SELECT 37 UNION SELECT 38 UNION SELECT 39 UNION SELECT 40
      UNION SELECT 41 UNION SELECT 42 UNION SELECT 43 UNION SELECT 44 UNION SELECT 45
      UNION SELECT 46 UNION SELECT 47 UNION SELECT 48 UNION SELECT 49 UNION SELECT 50) nums;

INSERT INTO hc_houseceeper_apartment (number, house_id, reg_key)
VALUE (1, 2, HEX(RAND(15)));

INSERT INTO hc_houseceeper_apartment_user(USER_ID, APARTMENT_ID)
VALUES (id0, 1),
       (id1, 1),
       (id2, 3),
       (id3, 4),
       (id1, 51);

INSERT INTO hc_houseceeper_user_role (USER_ID, ROLE_ID, HOUSE_ID)
VALUES (id0, 2, 1),
       (id1, 3, 1),
       (id2, 3, 1),
       (id3, 3, 1),
       (id1, 2, 2);

INSERT INTO hc_houseceeper_post (ID, HOUSE_ID, USER_ID, TITLE, TYPE_ID, CONTENT)
VALUES (1, 1, '', 'Отключение горячей воды', 2, '12.05.2023 во всем доме будет отключена горячая вода для проведения ремонтых работ. Надеемся на ваше понимание!'),
       (2, 1, id2, 'Напоминание', 3, 'Просто напоминаю: после 23 НИКАКОГО ШУМА быть НЕ должно! В следующий раз полицию вызову!!!');


INSERT INTO hc_houseceeper_comment (ID, USER_ID, POST_ID, CONTENT, PARENT_COMMENT_ID)
VALUES (1, id1, 1, 'Ни стыда, ни совести! Весь день ни помыться, ни побриться.', ''),
       (2, id2, 1, 'И не говорите, еще бы за час предупредили!', 1),
       (3, id3, 1, 'Да ладно вам ребят! Потерпим немного, не на неделю же отключают', 2);

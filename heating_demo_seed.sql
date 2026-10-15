
BEGIN;

-- Base de démonstration neuve, créée par les migrations Doctrine.
-- Mot de passe commun aux 7 comptes : Demo2026!Chauffage
-- À utiliser uniquement en environnement local de développement.

INSERT INTO utilisateur
    (id, email, first_name, last_name, birth_date, phone, roles, password)
VALUES
    (1, 'admin@demo.local', 'Alexandre', 'Bernard', '1988-04-12', '0600000001', '["ROLE_ADMIN"]'::json, '$2y$12$ATLP513ZFXtD1wR9Didcbe2CWSyf3aGNs.3NwrGJ9VQe9rnUQ5Kwy'),
    (2, 'secretaire1@demo.local', 'Camille', 'Martin', '1992-03-14', '0600000002', '["ROLE_SECRETAIRE"]'::json, '$2y$12$ATLP513ZFXtD1wR9Didcbe2CWSyf3aGNs.3NwrGJ9VQe9rnUQ5Kwy'),
    (3, 'secretaire2@demo.local', 'Julie', 'Petit', '1995-07-21', '0600000003', '["ROLE_SECRETAIRE"]'::json, '$2y$12$ATLP513ZFXtD1wR9Didcbe2CWSyf3aGNs.3NwrGJ9VQe9rnUQ5Kwy'),
    (4, 'chauffagiste1@demo.local', 'Thomas', 'Dubois', '1987-02-10', '0600000004', '["ROLE_CHAUFFAGISTE"]'::json, '$2y$12$ATLP513ZFXtD1wR9Didcbe2CWSyf3aGNs.3NwrGJ9VQe9rnUQ5Kwy'),
    (5, 'chauffagiste2@demo.local', 'Lucas', 'Moreau', '1990-09-08', '0600000005', '["ROLE_CHAUFFAGISTE"]'::json, '$2y$12$ATLP513ZFXtD1wR9Didcbe2CWSyf3aGNs.3NwrGJ9VQe9rnUQ5Kwy'),
    (6, 'chauffagiste3@demo.local', 'Hugo', 'Laurent', '1993-05-17', '0600000006', '["ROLE_CHAUFFAGISTE"]'::json, '$2y$12$ATLP513ZFXtD1wR9Didcbe2CWSyf3aGNs.3NwrGJ9VQe9rnUQ5Kwy'),
    (7, 'chauffagiste4@demo.local', 'Nicolas', 'Lefebvre', '1985-11-26', '0600000007', '["ROLE_CHAUFFAGISTE"]'::json, '$2y$12$ATLP513ZFXtD1wR9Didcbe2CWSyf3aGNs.3NwrGJ9VQe9rnUQ5Kwy');

INSERT INTO skill (id, wording, description) VALUES
    (1, 'Chaudiere gaz', 'Installation, entretien et depannage des chaudieres gaz'),
    (2, 'Pompe a chaleur', 'Maintenance des pompes a chaleur'),
    (3, 'Plomberie', 'Recherche et reparation de fuites'),
    (4, 'Regulation', 'Diagnostic et remplacement des thermostats'),
    (5, 'Radiateurs', 'Installation et entretien des radiateurs');

INSERT INTO user_skill (utilisateur_id, skill_id) VALUES
    (4, 1), (4, 4),
    (5, 2), (5, 4),
    (6, 3), (6, 5),
    (7, 1), (7, 5);

INSERT INTO fault (id, wording, description) VALUES
    (1, 'Panne de chauffage', 'Absence ou insuffisance de chauffage'),
    (2, 'Fuite hydraulique', 'Fuite sur le circuit de chauffage'),
    (3, 'Defaut de pression', 'Pression du circuit anormale'),
    (4, 'Thermostat defectueux', 'Dysfonctionnement de la regulation'),
    (5, 'Entretien annuel', 'Visite de maintenance preventive');

INSERT INTO vehicle (id, license_plate, brand, model) VALUES
    (1, 'AA-101-AA', 'Renault', 'Kangoo'),
    (2, 'BB-202-BB', 'Peugeot', 'Partner'),
    (3, 'CC-303-CC', 'Citroen', 'Berlingo'),
    (4, 'DD-404-DD', 'Ford', 'Transit Connect');

INSERT INTO stock (id, wording, description, quantity) VALUES
    (1, 'Joint fibre 20 mm', 'Joint pour raccord hydraulique', '120'),
    (2, 'Thermostat programmable', 'Thermostat mural', '15'),
    (3, 'Circulateur', 'Pompe de circulation chauffage', '8'),
    (4, 'Vase expansion 12 L', 'Vase pour circuit ferme', '6'),
    (5, 'Sonde temperature', 'Capteur de temperature', '24'),
    (6, 'Purgeur automatique', 'Purgeur de circuit chauffage', '35'),
    (7, 'Robinet thermostatique', 'Tete et corps de robinet', '40'),
    (8, 'Flexible raccordement', 'Flexible de raccordement', '50');

-- Les dates sont relatives au jour de l'import.
-- Les interventions futures sont visibles dans le calendrier.
INSERT INTO intervention
    (id, user_id, fault_id, vehicle_id, wording, "timestamp",
     description, address, status, remarque, start_date)
VALUES
    (1, 4, 5, 1, 'Entretien chaudiere - Centre',
     CURRENT_DATE - INTERVAL '12 days' + TIME '09:00',
     'Controle annuel de la chaudiere',
     '12 rue de la Tranchee, Poitiers', 'Terminee',
     'Entretien effectue, fonctionnement normal.', NULL),

    (2, 5, 4, 2, 'Remplacement thermostat',
     CURRENT_DATE - INTERVAL '8 days' + TIME '10:30',
     'Thermostat sans reponse',
     '8 rue Carnot, Poitiers', 'Terminee',
     'Thermostat remplace et teste.', NULL),

    (3, 6, 2, 3, 'Reparation fuite radiateur',
     CURRENT_DATE - INTERVAL '5 days' + TIME '14:00',
     'Fuite sur raccord de radiateur',
     '24 avenue de Nantes, Poitiers', 'Terminee',
     'Joint remplace.', NULL),

    (4, 7, 3, 4, 'Controle pression chaudiere',
     CURRENT_DATE - INTERVAL '2 days' + TIME '08:30',
     'Baisse recurrente de pression',
     '16 rue Magenta, Poitiers', 'Terminee',
     'Circuit controle et remis en pression.', NULL),

    (5, 4, 1, 1, 'Diagnostic chauffage collectif',
     CURRENT_DATE + INTERVAL '1 day' + TIME '09:00',
     'Plusieurs radiateurs restent froids',
     '5 boulevard du Grand Cerf, Poitiers', 'Planifiee',
     NULL, NULL),

    (6, 5, 4, 2, 'Installation thermostat',
     CURRENT_DATE + INTERVAL '1 day' + TIME '14:00',
     'Pose et configuration thermostat programmable',
     '19 rue de la Marne, Poitiers', 'Planifiee',
     NULL, NULL),

    (7, 6, 2, 3, 'Recherche fuite circuit',
     CURRENT_DATE + INTERVAL '2 days' + TIME '10:00',
     'Recherche de fuite sur tuyauterie',
     '42 rue de la Pierre Levee, Poitiers', 'Planifiee',
     NULL, NULL),

    (8, 7, 5, 4, 'Maintenance chaudiere gaz',
     CURRENT_DATE + INTERVAL '2 days' + TIME '15:00',
     'Maintenance preventive annuelle',
     '7 rue des Carmes, Poitiers', 'Planifiee',
     NULL, NULL),

    (9, 4, 3, 1, 'Controle vase expansion',
     CURRENT_DATE + INTERVAL '4 days' + TIME '08:30',
     'Pression instable du circuit',
     '31 avenue de Paris, Poitiers', 'Planifiee',
     NULL, NULL),

    (10, 5, 1, 2, 'Depannage pompe a chaleur',
     CURRENT_DATE + INTERVAL '5 days' + TIME '11:00',
     'Pompe a chaleur en defaut',
     '14 rue de la Gibauderie, Poitiers', 'Planifiee',
     NULL, NULL),

    (11, 6, 2, 3, 'Remplacement robinet radiateur',
     CURRENT_DATE + INTERVAL '6 days' + TIME '13:30',
     'Robinet thermostatique bloque',
     '3 rue de Blossac, Poitiers', 'Planifiee',
     NULL, NULL),

    (12, 7, 5, 4, 'Visite entretien chauffage',
     CURRENT_DATE + INTERVAL '7 days' + TIME '09:30',
     'Controle general de l installation',
     '28 rue de la Cathedrale, Poitiers', 'Planifiee',
     NULL, NULL);

INSERT INTO intervention_stock (intervention_id, stock_id) VALUES
    (1, 1), (1, 6),
    (2, 2),
    (3, 1), (3, 8),
    (4, 4),
    (5, 3),
    (6, 2),
    (7, 1), (7, 8),
    (8, 6),
    (9, 4),
    (10, 5),
    (11, 7),
    (12, 6);

-- Synchronise les sequences si elles existent.
-- Sur ton schema actuel, les IDs sont fournis explicitement.
DO $$
DECLARE
    t text;
    seq_name text;
BEGIN
    FOREACH t IN ARRAY ARRAY[
        'utilisateur', 'skill', 'fault',
        'vehicle', 'stock', 'intervention'
    ]
    LOOP
        seq_name := pg_get_serial_sequence(t, 'id');
        IF seq_name IS NOT NULL THEN
            EXECUTE format(
                'SELECT setval(%L, (SELECT MAX(id) FROM %I), true)',
                seq_name, t
            );
        END IF;
    END LOOP;
END
$$;

COMMIT;

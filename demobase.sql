USE demobase;
DROP TABLE IF EXISTS basic_user_auth;

CREATE TABLE basic_user_auth (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(100) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    creation_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO basic_user_auth(user, pass)
VALUES
('Shipman', SHA2('shipman@1278', 256)),
('Versatile', SHA2('vertyg#**9012', 256));
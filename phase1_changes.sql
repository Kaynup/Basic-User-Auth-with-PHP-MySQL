USE demobase;

ALTER TABLE basic_user_auth ADD COLUMN role VARCHAR(20) DEFAULT 'user';

UPDATE basic_user_auth
SET role = 'admin' WHERE user = 'Shipman';
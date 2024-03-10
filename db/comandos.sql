CREATE DATABASE IF NOT EXISTS dev_junior;

CREATE TABLE IF NOT EXISTS ramais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(20) NOT NULL,
    Host VARCHAR(50) NOT NULL,
    Dyn CHAR(1) NOT NULL,
    Nat CHAR(1) NOT NULL,
    ACL VARCHAR(10) NOT NULL,
    Port VARCHAR(20) NOT NULL,
    Status VARCHAR(50) NOT NULL
);

INSERT INTO ramais (name, host, dyn, nat, acl, port) VALUES
('7000/7000', '181.219.125.7', 'D', 'N', '42367', 'OK (33 ms)'),
('7001/7001', '181.219.125.7', 'D', 'N', '42368', 'OK (20 ms)'),
('7004/7002', '(Unspecified)', 'D', 'N', '0', 'UNKNOWN'),
('7003/7003', '(Unspecified)', 'D', 'N', '0', 'UNKNOWN'),
('7002/7004', '181.219.125.7', 'D', 'N', '42369', 'OK (15 ms)');

--------------

CREATE TABLE filas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    extension VARCHAR(255) NOT NULL,
    penalty INT NOT NULL,
    status VARCHAR(255) NOT NULL,
    calls_taken INT NOT NULL,
    last_call_secs_ago INT,
    name VARCHAR(255) NOT NULL,
    paused BOOLEAN
);

INSERT INTO filas (extension, penalty, status, calls_taken, last_call_secs_ago, name, paused)
VALUES 
    ('SIP/7000', 1, 'In use', 0, NULL, 'Chaves', NULL),
    ('SIP/7001', 1, 'Ring', 0, NULL, 'Kiko', NULL),
    ('SIP/7002', 1, 'Unavailable', 3, 1800, 'Chiquinha', NULL),
    ('SIP/7003', 1, 'Unavailable', 48, 15447, 'Nhonho', NULL),
    ('SIP/7004', 1, 'Not in use', 0, NULL, 'Godines', 1);


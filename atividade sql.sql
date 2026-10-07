-- ==========================================
-- BANCO DE DADOS DA CLÍNICA
-- ==========================================

CREATE DATABASE clinicas;

USE clinicas;


-- ==========================================
-- TABELA PACIENTE
-- ==========================================

CREATE TABLE Paciente (
    id_paciente INT PRIMARY KEY,
    nome VARCHAR(100),
    cpf VARCHAR(14),
    data_nascimento DATE,
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco VARCHAR(150),
    cidade VARCHAR(80)
);


-- ==========================================
-- TABELA MEDICO
-- ==========================================

CREATE TABLE Medico (
    id_medico INT PRIMARY KEY,
    nome VARCHAR(100),
    crm VARCHAR(20),
    especialidade VARCHAR(80),
    telefone VARCHAR(20),
    email VARCHAR(100),
    valor_consulta DECIMAL(10,2)
);


-- ==========================================
-- TABELA FAZ_CONSULTA
-- ==========================================

CREATE TABLE Faz_Consulta (
    id_consulta INT PRIMARY KEY,
    id_paciente INT,
    id_medico INT,
    data_consulta DATE,
    horario TIME,
    motivo VARCHAR(200),
    observacoes VARCHAR(500),
    status VARCHAR(30),

    FOREIGN KEY (id_paciente) REFERENCES Paciente(id_paciente),
    FOREIGN KEY (id_medico) REFERENCES Medico(id_medico)
);


-- ==========================================
-- CADASTRANDO OS PACIENTES
-- ==========================================

INSERT INTO Paciente VALUES
(1, 'Joao Silva', '111.111.111-11', '1995-03-15',
'(34) 99999-1111', 'joao@email.com',
'Rua das Flores, 100', 'Uberlandia');

INSERT INTO Paciente VALUES
(2, 'Maria Oliveira', '222.222.222-22', '1990-07-20',
'(34) 99999-2222', 'maria@email.com',
'Rua Central, 200', 'Uberlandia');

INSERT INTO Paciente VALUES
(3, 'Carlos Santos', '333.333.333-33', '1985-11-10',
'(34) 99999-3333', 'carlos@email.com',
'Avenida Brasil, 300', 'Uberaba');

INSERT INTO Paciente VALUES
(4, 'Ana Souza', '444.444.444-44', '2000-01-25',
'(34) 99999-4444', 'ana@email.com',
'Rua Goias, 400', 'Araguari');

INSERT INTO Paciente VALUES
(5, 'Pedro Almeida', '555.555.555-55', '1978-09-05',
'(34) 99999-5555', 'pedro@email.com',
'Rua Sao Paulo, 500', 'Uberlandia');


-- ==========================================
-- CADASTRANDO OS MEDICOS
-- ==========================================

INSERT INTO Medico VALUES
(1, 'Ricardo Mendes', 'CRM-MG 12345',
'Cardiologia', '(34) 98888-1111',
'ricardo@email.com', 350.00);

INSERT INTO Medico VALUES
(2, 'Fernanda Costa', 'CRM-MG 23456',
'Dermatologia', '(34) 98888-2222',
'fernanda@email.com', 280.00);

INSERT INTO Medico VALUES
(3, 'Marcelo Ferreira', 'CRM-MG 34567',
'Ortopedia', '(34) 98888-3333',
'marcelo@email.com', 300.00);


-- ==========================================
-- CADASTRANDO AS CONSULTAS
-- ==========================================

INSERT INTO Faz_Consulta VALUES
(1, 1, 1, '2026-10-10', '08:00:00',
'Dor no peito',
'Paciente sentiu dor durante exercicio',
'Agendada');

INSERT INTO Faz_Consulta VALUES
(2, 1, 2, '2026-10-15', '14:30:00',
'Avaliacao da pele',
'Paciente possui algumas manchas',
'Agendada');

INSERT INTO Faz_Consulta VALUES
(3, 2, 3, '2026-10-11', '09:00:00',
'Dor no joelho',
'Paciente sente dor ao caminhar',
'Realizada');

INSERT INTO Faz_Consulta VALUES
(4, 3, 1, '2026-10-12', '10:30:00',
'Avaliacao do coracao',
'Consulta de rotina',
'Realizada');

INSERT INTO Faz_Consulta VALUES
(5, 4, 2, '2026-10-13', '13:00:00',
'Acne',
'Paciente possui acne no rosto',
'Agendada');

INSERT INTO Faz_Consulta VALUES
(6, 5, 3, '2026-10-14', '15:00:00',
'Dor nas costas',
'Paciente sente dor lombar',
'Agendada');

INSERT INTO Faz_Consulta VALUES
(7, 2, 1, '2026-10-16', '08:30:00',
'Exame cardiologico',
'Retorno para mostrar exames',
'Agendada');

INSERT INTO Faz_Consulta VALUES
(8, 3, 3, '2026-10-17', '11:00:00',
'Dor no ombro',
'Paciente sente dificuldade para movimentar',
'Cancelada');


-- ==========================================
-- MOSTRAR TODAS AS TABELAS
-- ==========================================

SHOW TABLES;


-- ==========================================
-- 1. MOSTRAR TODOS OS PACIENTES
-- ==========================================

SELECT * FROM Paciente;


-- ==========================================
-- 2. MOSTRAR NOME E TELEFONE DOS PACIENTES
-- ==========================================

SELECT nome, telefone
FROM Paciente;


-- ==========================================
-- 3. MOSTRAR TODOS OS MEDICOS
-- ==========================================

SELECT * FROM Medico;


-- ==========================================
-- 4. MOSTRAR NOME, ESPECIALIDADE E VALOR
-- ==========================================

SELECT nome, especialidade, valor_consulta
FROM Medico;


-- ==========================================
-- 5. MOSTRAR MEDICOS DE UMA ESPECIALIDADE
-- ==========================================

SELECT *
FROM Medico
WHERE especialidade = 'Cardiologia';


-- ==========================================
-- 6. MOSTRAR TODAS AS CONSULTAS
-- ==========================================

SELECT * FROM Faz_Consulta;


-- ==========================================
-- 7. MOSTRAR CONSULTAS AGENDADAS
-- ==========================================

SELECT *
FROM Faz_Consulta
WHERE status = 'Agendada';


-- ==========================================
-- 8. CONSULTAS DE UMA DATA ESPECIFICA
-- ==========================================

SELECT *
FROM Faz_Consulta
WHERE data_consulta = '2026-10-10';


-- ==========================================
-- 9. CONSULTAS ORDENADAS PELA DATA
-- ==========================================

SELECT *
FROM Faz_Consulta
ORDER BY data_consulta;


-- ==========================================
-- 10. CONSULTAS ORDENADAS PELO HORARIO
-- DO MAIOR PARA O MENOR
-- ==========================================

SELECT *
FROM Faz_Consulta
ORDER BY horario DESC;


-- ==========================================
-- DESAFIO - JOIN
-- ==========================================


-- NOME DO PACIENTE, NOME DO MEDICO
-- E DATA DA CONSULTA

SELECT
Paciente.nome,
Medico.nome,
Faz_Consulta.data_consulta
FROM Faz_Consulta
JOIN Paciente
ON Faz_Consulta.id_paciente = Paciente.id_paciente
JOIN Medico
ON Faz_Consulta.id_medico = Medico.id_medico;


-- NOME DO PACIENTE, ESPECIALIDADE
-- E STATUS DA CONSULTA

SELECT
Paciente.nome,
Medico.especialidade,
Faz_Consulta.status
FROM Faz_Consulta
JOIN Paciente
ON Faz_Consulta.id_paciente = Paciente.id_paciente
JOIN Medico
ON Faz_Consulta.id_medico = Medico.id_medico;


-- TODAS AS CONSULTAS DE UM PACIENTE
-- NESTE CASO, JOAO

SELECT *
FROM Faz_Consulta
JOIN Paciente
ON Faz_Consulta.id_paciente = Paciente.id_paciente
WHERE Paciente.nome = 'Joao Silva';


-- TODAS AS CONSULTAS DE UM MEDICO
-- NESTE CASO, RICARDO

SELECT *
FROM Faz_Consulta
JOIN Medico
ON Faz_Consulta.id_medico = Medico.id_medico
WHERE Medico.nome = 'Ricardo Mendes';
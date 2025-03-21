- Atualizado em 18/03

CREATE TABLE usuarios (
  	id			INT 			NOT NULL 	AUTO_INCREMENT,
	nome		VARCHAR(350)	NOT NULL,
	email		VARCHAR(350)	NOT NULL,
	senha		VARCHAR(150)	NOT NULL,
	CONSTRAINT 	usuarios_pkey PRIMARY KEY (id),
	CONSTRAINT 	usuario_email_unico UNIQUE (email)
)ENGINE=InnoDB;

-- mock data
-- senha "123"
INSERT INTO usuarios (nome, email, senha) VALUES
('Eder Pansani', 'epansani@gmail.com', '$2y$10$Yow6I9Zp7LMKTUJtWNFB2.KBRKqvJO7ta5oULDnin55vp/N1rrwB6');

INSERT INTO usuarios (nome, email, senha) VALUES
('Marcos Morlin', 'marcos.morlin@aluno.ifsp.edu.br', '$2y$10$Yow6I9Zp7LMKTUJtWNFB2.KBRKqvJO7ta5oULDnin55vp/N1rrwB6');

CREATE TABLE profissionais (
    	id 				INT 			NOT NULL 	AUTO_INCREMENT,
    	id_usuario		INT			NOT NULL,	
        telefone		VARCHAR(150)		NOT NULL, 
        rede_social		TEXT			NOT NULL,
    	descricao		TEXT			NOT NULL,
    	PRIMARY KEY (id),
    	FOREIGN KEY (id_usuario) 	REFERENCES usuarios(id),
		CONSTRAINT 	profissional_usuario UNIQUE (id_usuario)
) ENGINE=InnoDB;
INSERT INTO profissionais (id_usuario, telefone, rede_social, descricao) VALUES
(1, '(17) 99999-9999', 'linkedin.com/in/ederpansani', 'Desenvolvedor web e professor, apaixonado por tecnologia e educação.');

INSERT INTO profissionais (id_usuario, telefone, rede_social, descricao) VALUES
(2, '(17) 98888-8888', 'linkedin.com/in/marcosmorlin', 'Estudante de Sistemas de Informação, entusiasta de programação e design.');
-- mock data



CREATE TABLE servicos (
  	id				INT				NOT NULL	AUTO_INCREMENT,
	nome			VARCHAR(150)	NOT NULL,
	descricao		TEXT			NOT NULL,			
	foto_servico	TEXT			NULL, 	
	PRIMARY KEY (id)
)ENGINE = InnoDB;

-- mock data
INSERT INTO servicos(nome, descricao)
	VALUES('Consultoria de TI','consultoria especializada para empresas que buscam melhorar sua infraestrutura de tecnologia da informação.');

INSERT INTO servicos(nome, descricao)
	VALUES('Manutenção de Computadores','Serviço de manutenção e reparo de computadores, incluindo formatação, atualização de hardware e solução de problemas técnicos.');

INSERT INTO servicos (nome, descricao, foto_servico) VALUES
('Desenvolvimento de Sites', 'Criação de sites modernos e responsivos para empresas e profissionais.', NULL),
('Suporte Técnico', 'Atendimento remoto e presencial para resolução de problemas de TI.', NULL),
('Segurança da Informação', 'Análise e implementação de medidas de proteção contra ataques cibernéticos.', NULL),
('Treinamento em Tecnologia', 'Capacitação em ferramentas e linguagens de programação para equipes e indivíduos.', NULL),
('Gerenciamento de Redes', 'Configuração e manutenção de redes corporativas, garantindo segurança e desempenho.', NULL);


CREATE TABLE servico_profissional(
	id					INT			NOT NULL	AUTO_INCREMENT,	
	id_profissional		INT			NOT NULL,	
	id_servico			INT			NOT NULL,	
	CONSTRAINT 	servico_profissional_pkey PRIMARY KEY (id),
    CONSTRAINT FOREIGN KEY (id_profissional) REFERENCES profissionais (id),
    CONSTRAINT FOREIGN KEY (id_servico) REFERENCES servicos (id),
	CONSTRAINT 	profissional_servico UNIQUE (id_profissional,id_servico)
)
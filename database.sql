-- Apaga o banco de dados caso ele exista:
-- Isso é útil em "tempo de desenvolvimento".
-- Quando o aplicativo estiver pronto, isso NUNCA deve ser usado.
DROP DATABASE IF EXISTS technovatas;

-- Recria o banco de dados:
-- CHARACTER SET utf8 especifica que o banco de dados use a tabela UTF-8.
-- COLLATE utf8_general_ci especifica que as buscas serão "case-insensitive".
CREATE DATABASE technovatas CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Seleciona banco de dados:
-- Todas as ações seguintes se referem a este banco de dados, até que outro
-- "USE nomedodb" seja encontrado.
USE technovatas;

-- Cria a tabela users:
CREATE TABLE users (

    -- O campo id (PK → Primary Key) é usado para identificar cada registro 
    -- como único. Ele não pode ter valores repetidos.
    -- A opção AUTO_INCREMENT força que o próprio MySQL incremente o id.
    uid INT PRIMARY KEY AUTO_INCREMENT,

    -- A data do cadastro está no fomrato TIMESTAMP (AAAA-MM-DD HH:II:SS).
    -- Só funciona com datas à partir de 01/01/1970 (Unix timestamp).
    -- DEFAULT especifica um valor padrão para o campo, durante a inserção.
    -- CURRENT_TIMESTAMP insere a data atual do sistema neste campo.
    udate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- NOT NULL especifica que este campo precisa de um valor.
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255),

    -- Formato do tipo DATE → AAAA-MM-DD.
    birth DATE,

    -- O tipo TEXT aceita strings de até 65.536 caracteres. 
    bio TEXT,

    -- O tipo ENUM(lista) só aceita um dos valores de "lista".
    -- DEFAULT especifica um valor padrão para o campo, durante a inserção.
    -- Neste caso, DEFAULT deve ter um avalor presente na lista de ENUM.
    type ENUM('admin', 'author', 'moderator', 'user') DEFAULT 'user',

    -- Formato do tipo DATETIME → AAAA-MM-DD HH:II:SS.
    -- DATETIME pode ser NULL, já TIMESTAMP não pode.
    last_login DATETIME,
    ustatus ENUM('online', 'offline', 'deleted', 'banned') DEFAULT 'online'
);

-- Cadastra alguns usuários para testes:
INSERT INTO users (
        -- Listamos somente os campos onde queremos inserir dados.
        -- Os outros campos já inserem automaticamente, valores padrão (DEFAULT).
        uid,
        name,
        email,
        password,
        photo,
        birth,
        bio,
        type
    )
VALUES (
        -- Dados a serem inseridos nos campos.
        -- Muito cuidado com a ordem e a quantidade de dados,
        -- elas devem coincidir com os campos acima.
        '1',
        'Joca da Silva',
        'joca@silva.com',

        -- A senha será criptografada pela função SHA1 antes de ser inserida.
        SHA1('senha123'),

        -- Não vamos inserir a imagem diretamente no banco de dados.
        -- Buscamos a imagem pela URL dela.
        'https://randomuser.me/api/portraits/men/14.jpg',

        -- Lembre-se de sempre inserir datas e números no formato correto.
        '1990-12-14',
        'Pintor, programador, escultor e enrolador.',

        -- O campo "type" é do tipo ENUM e aceita somente os valores da lista.
        'author'
    ),

    -- Para inserir um novo registro, basta adicionar vírgula no final do anterior
    -- e inserir os dados, sem repetir a query inteira.
    -- Dependendo do sistema, pode haver algum limite máximo para o tamanho 
    -- da query, portanto, evite repetir este processo muitas vezes.
    (
        '2',
        'Marineuza Siriliano',
        'mari@neuza.com',
        SHA1('senha123'),
        'https://randomuser.me/api/portraits/women/72.jpg',
        '2002-03-21',
        'Escritora, montadora, organizadora e professora.',
        'author'
    ),
    (
        '3',
        'Hemengarda Sirigarda',
        'hemen@garda.com',
        SHA1('senha123'),
        'https://randomuser.me/api/portraits/women/20.jpg',
        '2004-08-19',
        'Sensitiva, intuitiva, normativa e omissiva.',
        'author'
    ),
    (
        '4',
        'Setembrino Trocatapas',
        'set@brino.com',
        SHA1('senha123'),
        'https://randomuser.me/api/portraits/men/20.jpg',
        '1979-02-03',
        'Um dos maiores inimigos do Pernalonga.',
        'author'
    );

-- Cria tabela articles:
CREATE TABLE articles (
    aid INT PRIMARY KEY AUTO_INCREMENT,
    adate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    author INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    thumbnail VARCHAR(255) NOT NULL,
    resume VARCHAR(255) NOT NULL,
    astatus ENUM('online', 'offline', 'deleted') DEFAULT 'online',
    views INT DEFAULT 0,

    -- Define author como chave estrangeira.
    -- Isso faz com que a tabela "articles" seja dependente da tabela "users"
    -- para receber valores.
    -- Somente o id de um usuário já cadastrado na tabela "users" pode ser 
    -- usado no campo "author" da tabela "articles".
    FOREIGN KEY (author) REFERENCES users (uid)
);

-- Insere alguns artigos para testes:
INSERT INTO articles (
        author,
        title,
        content,
        thumbnail,
        resume
    )
VALUES (
        '1',
        'Por que as folhas são verdes',
        '<h2>Título de teste</h2><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum fugit praesentium alias deserunt sed maiores id rerum odio delectus perferendis voluptatum totam!</p><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero hic, modi pariatur culpa animi cum! Consequatur, odit! Repudiandae, dolorem temporibus, quaerat, unde enim error eum minus praesentium libero quibusdam consequuntur.</p><img src="https://picsum.photos/200/200" alt="Imagem aleatória." /><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia recusandae illum aliquam aperiam, laborum fugiat quos sunt expedita culpa! Minima harum mollitia aperiam nihil dolorem animi accusantium quia maxime expedita.</p><h3>Lista de links:</h3><ul><li><a href="https://github.com/Luferat">GitHub do Fessô</a></li><li><a href="https://catabits.com.br">Blog do Fessô</a></li><li><a href="https://facebook.com/Luferat">Facebook do Fessô</a></li></ul><p> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam commodi inventore nemo doloribus asperiores provident, recusandae maxime quam molestiae sapiente autem, suscipit perspiciatis. Numquam labore minima, accusamus vitae exercitationem quod!</p>',
        'https://picsum.photos/200',
        'Saiba a origem da cor verde nas folhas das arvores que tem folhas verdes.'
    ),
    (
        '2',
        'Por que os peixes nadam',
        '<h2>Título de teste</h2><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum fugit praesentium alias deserunt sed maiores id rerum odio delectus perferendis voluptatum totam!</p><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero hic, modi pariatur culpa animi cum! Consequatur, odit! Repudiandae, dolorem temporibus, quaerat, unde enim error eum minus praesentium libero quibusdam consequuntur.</p><img src="https://picsum.photos/200/200" alt="Imagem aleatória." /><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia recusandae illum aliquam aperiam, laborum fugiat quos sunt expedita culpa! Minima harum mollitia aperiam nihil dolorem animi accusantium quia maxime expedita.</p><h3>Lista de links:</h3><ul><li><a href="https://github.com/Luferat">GitHub do Fessô</a></li><li><a href="https://catabits.com.br">Blog do Fessô</a></li><li><a href="https://facebook.com/Luferat">Facebook do Fessô</a></li></ul><p> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam commodi inventore nemo doloribus asperiores provident, recusandae maxime quam molestiae sapiente autem, suscipit perspiciatis. Numquam labore minima, accusamus vitae exercitationem quod!</p>',
        'https://picsum.photos/199',
        'Alguns peixes nadam melhor que outros. Sabe por que?'
    ),
    (
        '2',
        'Quando as árvores tombam',
        '<h2>Título de teste</h2><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum fugit praesentium alias deserunt sed maiores id rerum odio delectus perferendis voluptatum totam!</p><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero hic, modi pariatur culpa animi cum! Consequatur, odit! Repudiandae, dolorem temporibus, quaerat, unde enim error eum minus praesentium libero quibusdam consequuntur.</p><img src="https://picsum.photos/200/200" alt="Imagem aleatória." /><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia recusandae illum aliquam aperiam, laborum fugiat quos sunt expedita culpa! Minima harum mollitia aperiam nihil dolorem animi accusantium quia maxime expedita.</p><h3>Lista de links:</h3><ul><li><a href="https://github.com/Luferat">GitHub do Fessô</a></li><li><a href="https://catabits.com.br">Blog do Fessô</a></li><li><a href="https://facebook.com/Luferat">Facebook do Fessô</a></li></ul><p> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam commodi inventore nemo doloribus asperiores provident, recusandae maxime quam molestiae sapiente autem, suscipit perspiciatis. Numquam labore minima, accusamus vitae exercitationem quod!</p>',
        'https://picsum.photos/198',
        'Quando uma arvore cai na floresta e ninguém vê, ela realmente caiu ou foi derrubada?'
    ),
    (
        '4',
        'Esquilos tropeçam no ar',
        '<h2>Título de teste</h2><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum fugit praesentium alias deserunt sed maiores id rerum odio delectus perferendis voluptatum totam!</p><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero hic, modi pariatur culpa animi cum! Consequatur, odit! Repudiandae, dolorem temporibus, quaerat, unde enim error eum minus praesentium libero quibusdam consequuntur.</p><img src="https://picsum.photos/200/200" alt="Imagem aleatória." /><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia recusandae illum aliquam aperiam, laborum fugiat quos sunt expedita culpa! Minima harum mollitia aperiam nihil dolorem animi accusantium quia maxime expedita.</p><h3>Lista de links:</h3><ul><li><a href="https://github.com/Luferat">GitHub do Fessô</a></li><li><a href="https://catabits.com.br">Blog do Fessô</a></li><li><a href="https://facebook.com/Luferat">Facebook do Fessô</a></li></ul><p> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam commodi inventore nemo doloribus asperiores provident, recusandae maxime quam molestiae sapiente autem, suscipit perspiciatis. Numquam labore minima, accusamus vitae exercitationem quod!</p>',
        'https://picsum.photos/201',
        'Bichinos fofinhos que podem transformar seu dia em um inferno de fofura.'
    ),
    (
        '3',
        'Impacto verde',
        '<h2>Título de teste</h2><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum fugit praesentium alias deserunt sed maiores id rerum odio delectus perferendis voluptatum totam!</p><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero hic, modi pariatur culpa animi cum! Consequatur, odit! Repudiandae, dolorem temporibus, quaerat, unde enim error eum minus praesentium libero quibusdam consequuntur.</p><img src="https://picsum.photos/200/200" alt="Imagem aleatória." /><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia recusandae illum aliquam aperiam, laborum fugiat quos sunt expedita culpa! Minima harum mollitia aperiam nihil dolorem animi accusantium quia maxime expedita.</p><h3>Lista de links:</h3><ul><li><a href="https://github.com/Luferat">GitHub do Fessô</a></li><li><a href="https://catabits.com.br">Blog do Fessô</a></li><li><a href="https://facebook.com/Luferat">Facebook do Fessô</a></li></ul><p> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam commodi inventore nemo doloribus asperiores provident, recusandae maxime quam molestiae sapiente autem, suscipit perspiciatis. Numquam labore minima, accusamus vitae exercitationem quod!</p>',
        'https://picsum.photos/202',
        'Não esqueça de todos os itens necessários para adentrar uma grande floresta.'
    ),
    (
        '3',
        'Cheiro de mato',
        '<h2>Título de teste</h2><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum fugit praesentium alias deserunt sed maiores id rerum odio delectus perferendis voluptatum totam!</p><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero hic, modi pariatur culpa animi cum! Consequatur, odit! Repudiandae, dolorem temporibus, quaerat, unde enim error eum minus praesentium libero quibusdam consequuntur.</p><img src="https://picsum.photos/200/200" alt="Imagem aleatória." /><p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia recusandae illum aliquam aperiam, laborum fugiat quos sunt expedita culpa! Minima harum mollitia aperiam nihil dolorem animi accusantium quia maxime expedita.</p><h3>Lista de links:</h3><ul><li><a href="https://github.com/Luferat">GitHub do Fessô</a></li><li><a href="https://catabits.com.br">Blog do Fessô</a></li><li><a href="https://facebook.com/Luferat">Facebook do Fessô</a></li></ul><p> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam commodi inventore nemo doloribus asperiores provident, recusandae maxime quam molestiae sapiente autem, suscipit perspiciatis. Numquam labore minima, accusamus vitae exercitationem quod!</p>',
        'https://picsum.photos/203',
        'Conheça os melhores equipamentos para cortar sua grama de forma elegante e moderna.'
    );

-- Cria a tabela "comments":
CREATE TABLE comments (
    cid INT PRIMARY KEY AUTO_INCREMENT,
    cdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cauthor INT NOT NULL,
    article INT NOT NULL,
    comment TEXT NOT NULL,
    cstatus ENUM('online', 'offline', 'deleted') DEFAULT 'online',
    FOREIGN KEY (cauthor) REFERENCES users (uid),
    FOREIGN KEY (article) REFERENCES articles (aid)
);

-- Insere alguns comentários para testes:
INSERT INTO comments (
    cauthor,
    article,
    comment
) VALUES (
    '1',
    '2',
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum.'
), (
    '2',
    '2',
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum.'
), (
    '4',
    '2',
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum.'
), (
    '3',
    '2',
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum.'
), (
    '2',
    '6',
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum.'
), (
    '2',
    '3',
    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo quia provident reiciendis earum, tenetur reprehenderit iure ipsum.'
);

-- Cria a tabela "contacts":
CREATE TABLE contacts (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  status ENUM ('sended','readed','responded','deleted') DEFAULT 'sended'
);

-- CRIANDO E TESTANDO:
-- Selecione todo este conteúdo teclando [Ctrl]+[A];
-- Copie o conteúdo para a área de transferência teclando [Ctrl]+[C];
-- Acesse o PHPMyAdmin → http://localhost/phpmyadmin;
-- Clique na guia [SQL] na porção esquerda;
-- Cole o código no campo, teclando [Ctrl]+[V];
-- Verifique se ocorreram erros de sintaxe.
--     Aparece um "X" dentro de uma bola vermelha.
-- Clique no botão [Continuar] que está logo abaixo;
-- Verifique se não ocorrem erros.
-- Atualize a página para ver se o banco foi corretamente criado, juntamente
-- com as tabelas e os campos destas...


# Tech Elevate: Sua Plataforma para Eventos de Tecnologia 

Tech Elevate é uma aplicação web desenvolvida em Laravel ⚡, projetada para conectar profissionais  e entusiastas de tecnologia  através da criação, gerenciamento e participação em eventos.

## Funcionalidades Principais ✨

* **Criação e Gerenciamento de Eventos :**
    * Permite a criação de eventos com título, data, local , descrição, imagem ️ e detalhes de infraestrutura.
    * Organizadores podem editar ✏️ e excluir ️ seus eventos.
* **Participação em Eventos ✅:**
    * Usuários podem se inscrever ✅ e cancelar sua participação ❌ em eventos.
* **Busca e Filtro :**
    * Sistema de busca por título e filtro por tags de tecnologia (Cloud ☁️, Back-end ⚙️, Front-end , etc.).
* **Perfil do Usuário (Dashboard) :**
    * Painel personalizado com eventos criados ➕ e eventos inscritos ️.
* **Autenticação e Validação :**
    * Sistema de login  e registro de usuários .
    * Validação de formulários com mensagens de erro em português ️.
* **Gerenciamento de Mídia :**
    * Upload e armazenamento de imagens para eventos.

## Tecnologias Utilizadas ️

* **Backend:**
    * Laravel (PHP Framework MVC) 
    * PHP 
    * Eloquent ORM ️
    * Middleware (Autenticação e Rotas) ️
* **Frontend:**
    * Blade (Templates Laravel) 
    * Bootstrap 5 (Design Responsivo) 
    * HTML/CSS 

## Configuração e Execução ⚙️

1.  **Clone o repositório:**
    ```bash
    git clone [link do repositório]
    cd tech-elevate
    ```
2.  **Instale as dependências do Composer:**
    ```bash
    composer install
    ```
3.  **Copie o arquivo .env.example para .env e configure as variáveis de ambiente:**
    ```bash
    cp .env.example .env
    ```
4.  **Gere a chave da aplicação:**
    ```bash
    php artisan key:generate
    ```
5.  **Configure o banco de dados no arquivo .env.**
6.  **Execute as migrations:**
    ```bash
    php artisan migrate
    ```
7.  **Inicie o servidor de desenvolvimento:**
    ```bash
    php artisan serve
    ```
8.  **Acesse a aplicação no seu navegador:** `http://localhost:8000`

## Contribuição 

Contribuições são bem-vindas! Se você deseja contribuir com o projeto, siga estas etapas:

1.  Faça um fork do repositório.
2.  Crie uma branch para sua feature (`git checkout -b feature/NovaFuncionalidade`).
3.  Faça commit das suas mudanças (`git commit -am 'Adiciona nova funcionalidade'`).
4.  Faça push para a branch (`git push origin feature/NovaFuncionalidade`).
5.  Abra um Pull Request.

## Licença 

Este projeto está sob a licença [MIT](link da licença).

## Contato 

Se tiver alguma dúvida, entre em contato: [seu email]

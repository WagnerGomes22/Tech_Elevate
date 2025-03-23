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
    * Painel personalizado com eventos criados ➕ e eventos inscritos .
* **Autenticação e Validação :**
    * Sistema de login  e registro de usuários .
    * Validação de formulários com mensagens de erro em português ️.
* **Gerenciamento de Mídia ️:**
    * Upload e armazenamento de imagens para eventos.

## Tecnologias Utilizadas ️

* **Backend:**
    * Laravel (PHP Framework MVC) 
    * PHP 
    * Eloquent ORM 
    * Middleware (Autenticação e Rotas) ️
* **Frontend:**
    * Blade (Templates Laravel) 
    * Bootstrap 5 (Design Responsivo) 
    * HTML/CSS 

## Configuração e Execução ⚙️

1.  **Clone o repositório:**

    ```bash
    git clone [https://github.com/WagnerGomes22/Tech_Elevate.git](https://www.google.com/search?q=https://github.com/WagnerGomes22/Tech_Elevate.git)
    cd Tech_Elevate
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

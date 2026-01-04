# MPenha Finance CRM

Sistema de controle financeiro pessoal simples e eficiente.

## Requisitos

- PHP 7.4 ou superior
- MySQL / MariaDB
- Servidor Web (Apache/Nginx)
- Recomendado: XAMPP para ambiente Windows local.

## Instalação

Siga os passos abaixo para configurar o projeto em sua máquina local.

### 1. Clonar o Repositório

```bash
git clone https://github.com/mychelpenhadev/projeto_financeiro.git
cd projeto_financeiro
```

### 2. Configurar o Banco de Dados

1. Abra seu gerenciador de banco de dados (ex: phpMyAdmin).
2. Importe o arquivo `database.sql` localizado na raiz do projeto.
   - Isso criará o banco de dados `iafinancecrm` e as tabelas necessárias.
   - **Nota**: O script já cria o banco se ele não existir.

#### Usuário Padrão
O banco de dados já vem com um usuário administrador configurado:
- **Email**: `admin@iafinance.com`
- **Senha**: `admin123` (ou verifique o hash no banco para redefinir se necessário)

### 3. Configurar Variáveis de Ambiente

Crie um arquivo `.env` na raiz do projeto baseado no exemplo fornecido:

- **Windows**:
  ```bash
  copy .env.example .env
  ```
- **Linux/Mac**:
  ```bash
  cp .env.example .env
  ```

Edite o arquivo `.env` com suas credenciais do banco de dados local:

```ini
DB_HOST=localhost
DB_NAME=iafinancecrm
DB_USER=root
DB_PASS=
```

### 4. Executar

Se estiver usando XAMPP:
1. Mova a pasta do projeto para `C:\xampp\htdocs\`.
2. Inicie o Apache e o MySQL pelo painel do XAMPP.
3. Acesse no navegador: `http://localhost/projeto_financeiro`

## Estrutura de Pastas

- `api/`: Endpoints JSON para o frontend.
- `assets/`: Imagens e recursos estáticos.
- `src/`: Lógica de backend e autenticação.
- `index.php`: Página de login.
- `dashboard.php`: Painel principal.

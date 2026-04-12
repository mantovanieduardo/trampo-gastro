<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20Logo%20Lockup%20Vertical/2%20Logo%20Lockup%20Vertical%20Black.svg" width="120" alt="Logo">
  <h1>🍴 Trampo Gastro</h1>
  <p><b>Gestão Full-Stack de Freelancers para Gastronomia</b></p>

  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white">
  <img src="https://img.shields.io/badge/Tailwind-3.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white">
</div>

<br>

## 📖 O Projeto
Plataforma desenvolvida para conectar estabelecimentos gastronômicos a garçons freelancers. O foco central é a **automação do fluxo de trabalho**: publicação de vagas, gestão de candidaturas e confirmação de agenda em tempo real.

---

## 🏗️ Engenharia de Software
O sistema foi arquitetado para ser resiliente e seguro, utilizando:
- **Padrão MVC:** Organização clara de responsabilidades.
- **Middleware RBAC:** Filtros de acesso baseados no perfil (`restaurante` vs `garcom`).
- **Transações ACID:** Processamento atômico em `VagaController` para evitar inconsistências no "match".
- **Sanitização:** Proteção contra XSS e SQL Injection nativa via Eloquent e Blade.

---

## 🗄️ Modelo de Dados (Schema Relacional)

Abaixo, a estrutura das tabelas principais e suas responsabilidades no ecossistema:

<table width="100%">
  <thead>
    <tr>
      <th align="left">Tabela</th>
      <th align="left">Responsabilidade</th>
      <th align="left">Relações / Chaves</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>users</code></td>
      <td>Autenticação e controle de perfil (admin/user).</td>
      <td>Chave primária (id) usada como FK em todas as tabelas.</td>
    </tr>
    <tr>
      <td><code>restaurantes</code></td>
      <td>Perfil empresarial e dados do estabelecimento.</td>
      <td><code>usuario_id</code> (FK) 1:1 com <code>users</code>.</td>
    </tr>
    <tr>
      <td><code>vagas</code></td>
      <td>Entidade central. Armazena valores, datas e status.</td>
      <td><code>restaurante_id</code> (FK) N:1. Possui timestamps e <code>data_hora_inicio</code>.</td>
    </tr>
    <tr>
      <td><code>candidaturas</code></td>
      <td>Tabela pivô. Gerencia o interesse e aprovação.</td>
      <td><b>Composite:</b> <code>vaga_id</code> (FK) + <code>usuario_id</code> (FK). Controla o status do match.</td>
    </tr>
  </tbody>
</table>

---

## 📸 Demonstração Visual

<div align="center">
  <b>1. Dashboard & RBAC</b><br>
  <img src="public/img/dashboard.png" width="800" style="border: 1px solid #ddd; border-radius: 8px;"><br><br>
  
  <b>2. Publicação de Vagas (CRUD Seguro)</b><br>
  <img src="public/img/vagas.png" width="800" style="border: 1px solid #ddd; border-radius: 8px;"><br><br>

  <b>3. Agenda do Freelancer</b><br>
  <img src="public/img/agenda.png" width="800" style="border: 1px solid #ddd; border-radius: 8px;">
</div>

---

## ⚙️ Setup do Ambiente

```bash
# Clone e instalação
git clone [https://github.com/seu-usuario/trampo-gastro.git](https://github.com/seu-usuario/trampo-gastro.git)
composer install && npm install

# Build dos assets (Vite)
npm run build

# Configuração Laravel
cp .env.example .env
php artisan key:generate
php artisan migrate

# Execução
php artisan serve

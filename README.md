<div align="center">
  <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel Logo" width="100">
  <h1>🍴 Trampo Gastro</h1>
  
  <p><b>A conexão definitiva entre restaurantes e talentos freelancers.</b></p>

  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind">
  <img src="https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
</div>

<hr>

## 📖 Sobre o Projeto

O **Trampo Gastro** é uma plataforma Full-Stack desenvolvida para otimizar a gestão de mão de obra no setor gastronômico. O sistema permite que restaurantes publiquem vagas pontuais para garçons freelancers, gerenciando todo o ciclo de vida da vaga: desde a publicação e candidatura até a aprovação e confirmação na agenda.

---

## 🛠️ Stack Tecnológica

<table align="center">
  <tr>
    <td align="center"><b>Backend</b></td>
    <td align="center"><b>Frontend</b></td>
    <td align="center"><b>Persistência</b></td>
  </tr>
  <tr>
    <td>PHP 8.1+ & Laravel Framework</td>
    <td>Blade Templates & Tailwind CSS</td>
    <td>MySQL (Banco de Dados Relacional)</td>
  </tr>
  <tr>
    <td align="center"><b>Autenticação</b></td>
    <td align="center"><b>Assets</b></td>
    <td align="center"><b>Ambiente</b></td>
  </tr>
  <tr>
    <td>Laravel Breeze (RBAC)</td>
    <td>Vite & Node.js</td>
    <td>Composer & Artisan</td>
  </tr>
</table>

---

## 🏗️ Engenharia e Arquitetura

O projeto foi construído seguindo rigorosos padrões de engenharia de software para garantir escalabilidade e segurança:

<ul>
  <li><b>Padrão MVC:</b> Separação lógica entre Modelos de dados, Views de interface e Controllers de fluxo.</li>
  <li><b>Segurança RBAC:</b> Controle de acesso baseado em papéis através de Middlewares customizados.</li>
  <li><b>Transações ACID:</b> Implementação de <code>DB::transaction</code> para garantir atomicidade em processos críticos (aprovação simultânea de candidatura e fechamento de vaga).</li>
  <li><b>Proteção de Dados:</b> Uso de Eloquent ORM contra <i>SQL Injection</i> e sanitização via Blade contra <i>XSS</i>.</li>
</ul>

---

## 📸 Demonstração

<div align="center">
  <h3>1. Dashboard Inteligente</h3>
  <p>Interface adaptativa que altera menus e permissões com base no perfil logado.</p>
  <img src="public/img/dashboard.png" width="800" alt="Dashboard">

  <br><br>

  <h3>2. Gestão de Candidatos (Visão Restaurante)</h3>
  <p>Filtro de garçons e aprovação instantânea com atualização de status em tempo real.</p>
  <img src="public/img/vagas.png" width="800" alt="Gestão de Vagas">

  <br><br>

  <h3>3. Agenda Confirmada (Visão Garçom)</h3>
  <p>Visualização clara dos eventos aceitos para organização profissional do freelancer.</p>
  <img src="public/img/agenda.png" width="800" alt="Agenda">
</div>

---

## ⚙️ Instalação Local

Siga os passos abaixo para rodar o projeto em sua máquina:

1. **Clonagem do Repositório**
```bash
git clone [https://github.com/seu-usuario/trampo-gastro.git](https://github.com/seu-usuario/trampo-gastro.git)
cd trampo-gastro

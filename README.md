# 🚀 API - Sistema de Produtos

API REST para gerenciamento de produtos, variações, cores, tamanhos e vendas.

---

## 📌 Base URL

```bash
http://localhost/seu-projeto/v1
```

> Exemplo:

```
http://localhost/seu-projeto/v1/produtos/
```

---

## ⚙️ Ambiente (XAMPP)

Esta API roda utilizando o Apache do XAMPP.

### Passos:

1. Clone o projeto na pasta:

```
C:\xampp\htdocs\
```

2. Exemplo:

```
C:\xampp\htdocs\seu-projeto
```

3. Inicie o XAMPP:

* Apache ✅
* MySQL (se necessário) ✅

4. Acesse no navegador ou via API client:

```
http://localhost/seu-projeto/v1
```

---

## 🔐 Segurança

* Rate limit aplicado por rota
* Suporte a API Key (opcional)

---

## 📦 Padrão de Resposta

```json
{
  "error": false,
  "message": "Sucesso",
  "data": []
}
```

---

## 📚 Endpoints

### 🧾 Produtos

* `GET /v1/produtos/` → Listar produtos
* `GET /v1/produtos/{uuid}` → Buscar por UUID
* `GET /v1/produtos/reference/{reference}` → Buscar por referência
* `POST /v1/produtos/c/create` → Criar produto
* `PUT /v1/produtos/u/update` → Atualizar produto

---

### 🎨 Cores

* `GET /v1/colors/` → Listar cores
* `GET /v1/colors/{uuid}` → Buscar por UUID
* `POST /v1/colors/c/create` → Criar cor
* `PUT /v1/colors/u/update` → Atualizar cor
* `DELETE /v1/colors/d/delete` → Remover cor

---

### 📏 Tamanhos

* `GET /v1/sizes/` → Listar tamanhos
* `GET /v1/sizes/{uuid}` → Buscar por UUID
* `POST /v1/sizes/c/create` → Criar tamanho

---

### 💰 Vendas

* `GET /v1/sales/` → Listar vendas
* `GET /v1/sales/{uuid}` → Buscar venda
* `GET /v1/sales/users/{uuid_user}` → Vendas por usuário
* `GET /v1/sales/items/{sale_uuid}` → Itens da venda
* `POST /v1/sales/c/create` → Criar venda
* `POST /v1/sales/itens/c/create` → Adicionar item à venda
* `DELETE /v1/sales/itens/d/delete/{variation_uuid}` → Remover item à venda
* `DELETE /v1/sales/itens/all/d/delete/sale/{sale_uuid}` → Remover todos os itens da venda

---

## 📄 Observações

* Todas as rotas retornam JSON
* Prefixo padrão: `/v1`
* Rate limit ativo conforme configuração

---

## 🚀 Evoluções Futuras

* Padronização REST (PUT, DELETE)
* Autenticação com JWT
* Documentação com Swagger (OpenAPI)

Claro! Abaixo está o conteúdo reorganizado, formatado e com símbolos para facilitar a leitura. Ele está pronto para ser adicionado ao GitHub como um `README.md`:

---

# 🧾 Integrador Modobank para MK-AUTH

Este integrador permite a geração de boletos via Modobank no sistema **MK-AUTH**.

---

## ✅ Requisitos

### 🔍 Versão do MK-AUTH

* ⚠️ Verifique a **versão do seu MK-AUTH**:

  * ✅ Versão **18 até 19**: utiliza arquivos `.php` e **Python 3.5**.
  * ✅ Versão **20 ou superior**: utiliza arquivos `.hhvm` e **Python 3.7 ou superior**.

---

## 💻 Instalação do Python e Pip

### 🐍 Para Python 3.5 (MK-AUTH v18 a v19)

```bash
curl https://bootstrap.pypa.io/pip/3.5/get-pip.py -o get-pip.py
python3.5 get-pip.py
```

Após a instalação do `pip`, execute:

```bash
pip install request qrcode
```

---

### 🐍 Para Python 3.7 (MK-AUTH v20+)

```bash
curl https://bootstrap.pypa.io/pip/3.7/get-pip.py -o get-pip.py
python3.7 get-pip.py
```

Após a instalação do `pip`, execute:

```bash
pip3 install request qrcode
```

---

## 📦 Baixando e Instalando o Integrador

1. 🔽 Baixe o arquivo `.zip` do projeto no GitHub.
2. 📂 Extraia o conteúdo para a pasta:

```bash
/var/www/
```

3. 🛠️ Ajuste as permissões:

```bash
chmod 777 /var/www/pix/gera.py
chmod 777 /var/www/pix/img
chmod 777 /var/www/pix/web.py
```

---

## 🔐 Acesso ao Painel (Versão 23+)

* 🌐 Acesse: `http://seumkauth/pix/admin`
* 👤 Login: `ADMIN`
* 🔑 Senha: `123`

---

## ▶️ Iniciando o Webhook

### 🔁 Para Python 3.5:

```bash
python3.5 web.py
```

### 🔁 Para Python 3.7:

```bash
python3.7 web.py
```

> Após isso, seu Webhook estará ativo para receber os pagamentos PIX.

---

## 🛠️ Configuração e Uso

1. 🔧 **Crie uma conta do tipo "Boleto Próprio do Provedor"** com o nome:

```
modobank
```

2. 💾 Salve a conta.

3. 🖥️ Acesse o painel de integração:

```
http://seumkauth/pix/admin
```

4. 🔐 Use o mesmo login e senha do seu painel administrativo do MK-AUTH.

5. ⚙️ Vá na opção **"Configurar API"** e preencha os dados da sua conta Modobank.

---

## 🧾 Gerando Boletos

1. Acesse a opção **"Gerar Boleto"** no painel.
2. 🔎 Pesquise pelo **nome do cliente**.
3. ▶️ Clique no botão **"Gerar Boleto"** ao lado do nome.

---

## 📁 Observações

* O sistema utiliza `qrcode` para exibir o código de pagamento.
* As imagens são salvas na pasta `/var/www/pix/img`.

---

## 📬 Suporte

Em caso de dúvidas ou sugestões, entre em contato com o desenvolvedor ou abra uma *issue* aqui no GitHub.

---

Se quiser que eu gere o arquivo `README.md` completo e formatado para você subir no GitHub, posso criar e enviar aqui também. Deseja isso?
